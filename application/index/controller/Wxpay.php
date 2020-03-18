<?php
namespace app\index\controller;

use app\index\model\OrderGiftModel;
use app\index\model\OrderWineModel;
use app\index\model\SysConfigModel;
use app\index\model\UserModel;
use common\profit\Profit;
use common\sms\SendMsg;
use common\wechat\Tools;
use think\App;
use think\Controller;
use think\facade\Config;
use think\Request;

class Wxpay extends  Controller {
    protected $request;
    protected $obj;

    //构造函数
    public function __construct(App $app = null){
        parent::__construct($app);
        $this->request = $app->request;
    }

    //统一下单
    public function createOrder(){
        $param = $this->request->param();
        if(empty($param['order_id']) || empty($param['type'])) return json(errRes([],'参数错误'));
        $this->obj['appid'] = Config::get('app.wechat.appid');//公众号ID
        $this->obj['mch_id'] = Config::get('app.wechat.mch_id');//商户号
        $this->obj['nonce_str'] = Tools::genRandomString();//随机字符串
        if($param['type'] == 1){//商品
            $order = OrderWineModel::get($param['order_id']);
            $this->obj['body'] = '悟空名品商城商品';//商品描述
            $this->obj['notify_url'] = Config::get('app.wechat.notify_wine_url');//通知地址
        }else{//会员
            $order = OrderGiftModel::get($param['order_id']);
            $this->obj['body'] = '悟空名品会员礼包';//商品描述
            $this->obj['notify_url'] = Config::get('app.wechat.notify_gift_url');//通知地址
        }
        if(empty($order)) return json(errRes([],'订单编号错误'));
        $this->obj['out_trade_no'] = $param['order_id'];//商户订单号
        $this->obj['total_fee'] = $order['total_money'] * 100;//总价
        $this->obj['spbill_create_ip'] = $this->request->ip();//终端ip
        $this->obj['trade_type'] = 'JSAPI';//交易类型

        $this->obj['openid'] = UserModel::where(['id' => $order['user_id']])->value('openid');
        $this->obj['sign'] = Tools::getSign($this->obj,Config::get('app.wechat.key'));;//签名

        $xml = Tools::arrayToXml($this->obj);
        $response = Tools::postXmlCurl($xml,Config::get('app.wechat.create_order_url'));

        if(!$response) return json(errRes([],'统一下单失败'));
        $result = Tools::xmlToArray($response);
        if( !empty($result['result_code']) && !empty($result['err_code']) ){
            $result['err_msg'] = $result['err_code_des'];
        }
        if($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
            return json(sucRes(['prepay_id' => $result['prepay_id']],'统一下单成功'));
        }
        return json(errRes($result,'统一下单失败'));
    }

    //商品支付通知
    public function payOrderWineNotify(){
        $xml = file_get_contents('php://input');
        $data =Tools::xmlToArray($xml);
        $result = $this->verifyNotice($data);
        if($result){
            $order = OrderWineModel::get($data['out_trade_no']);
            if(in_array($order['status'],[1,2,4]) ){
                $order->save(['remark'=>'该笔订单于'.date('Y-m-d H:i:s',time()).'被重复支付，交易ID：'.$data['transaction_id'].'【系统提示】']);
            }else{
                $order->save(['status'=>1,'transaction_id'=>$data['transaction_id'],'pay_time'=>date('Y-m-d H:i:s',time())]);
            }

            //付款短信通知
            $content = SendMsg::getTemplate(2,['[0]' => $data['out_trade_no']]);
            $phone = SysConfigModel::where(['config_code' => 'orderMsgPhone'])->value('config_value');
            $result = SendMsg::send($phone,$content);
            exit(Tools::arrayToXml($result));
        }
    }

    //会员支付通知
    public function payOrderGifyNotify(){
        $xml = file_get_contents('php://input');
        $data =Tools::xmlToArray($xml);
        $result = $this->verifyNotice($data);
        if($result){
            $order = OrderGiftModel::get($data['out_trade_no']);
            if(in_array($order['status'],[1,2,4]) ){
                $order->save(['remark'=>'该笔订单于'.date('Y-m-d H:i:s',time()).'被重复支付，交易ID：'.$data['transaction_id'].'【系统提示】']);
            }else{
                $order->save(['status'=>1,'transaction_id'=>$data['transaction_id'],'pay_time'=>date('Y-m-d H:i:s',time())]);
                UserModel::where('id',$order['user_id'])->update(['join_time' => date('Y-m-d H:i:s',time())]);
                //佣金分销
                Profit::giftProfit($order['id']);//计算收益
            }

            //付款短信通知
            $content = SendMsg::getTemplate(3,['[0]' => $data['out_trade_no']]);
            $phone = SysConfigModel::where(['config_code' => 'orderMsgPhone'])->value('config_value');
            $result = SendMsg::send($phone,$content);
            exit(Tools::arrayToXml($result));
        }
    }

    //验证是否是通知内容
    private function verifyNotice($data){
        $sign = Tools::getSign($data,$this->key);
        //判断算出的签名和通知信息的签名是否一致
        if($sign == $data['sign']){
            //处理完成之后，告诉微信成功结果
            return ['return_code' => 'SUCCESS','return_msg' => 'OK'];
        }else{
            return false;
        }
    }
}