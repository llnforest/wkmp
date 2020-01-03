<?php
/**
 * User: Lynn
 * Date: 2019/11/18
 * Time: 11:55
 */

namespace app\index\controller;


use app\index\model\OrderWineGoodsModel;
use app\index\model\OrderWineModel;
use app\index\model\UserModel;
use common\dict\DictUtil;
use think\App;
use think\facade\Config;

class User extends AuthController
{
    protected $data;
    function __construct(App $app = null)
    {
        parent::__construct($app);
    }

    /**
     * 个人中心
     * @return \think\response\Json
     */
    public function user(){
        $this->data['userInfo'] = UserModel::where('id',$this->user_id)->find();
//        $this->data['userInfo']['level'] = 0;
        $this->data['userInfo']['user_level_text'] = DictUtil::getDictName('userLevel',$this->data['userInfo']['level']);
        return json(sucRes($this->data));
    }

    /**
     * 未支付订单数量
     * @return \think\response\Json
     */
    public function payNum(){
        $this->data['payNum'] = OrderWineModel::where(['user_id'=>$this->user_id,'status'=>0])->count();
        return json(sucRes($this->data));
    }

    /**
     * 订单中心
     * @return \think\response\Json
     */
    public function orderlist(){
        $page = !empty($this->param['page'])?$this->param['page']:1;
        $where[] = ['user_id','=',$this->user_id];
        if(isset($this->post['status']) && $this->post['status'] != 100){
            $where[] = ['status','in',$this->post['status']];
        }
        $this->data['orderList'] = OrderWineModel::where($where)->order('update_time desc')->page($page,Config::get('paginate.list_rows'))->select();
        foreach($this->data['orderList'] as $v){
            $v['status_text'] = DictUtil::getDictName('orderStatus',$v['status']);
            $v['wineList'] = OrderWineGoodsModel::where('order_id',$v['id'])->order('id asc')->select();
            foreach($v['wineList'] as $v_v){
                $v_v['img'] = Config::get('app.upload.img_url').str_replace('\\','/',$v_v['img']);
                $v_v['wine_size_text'] = DictUtil::getDictName('wineSize',$v_v['wine_size']);
            }
        }
        return json(sucRes($this->data));
    }

    /**
     * 订单详情页面
     * @return \think\response\Json
     */
    public function orderDetail(){
        if(!$this->request->has('id')) return json(errRes([],'参数错误'));
        $this->data['orderInfo'] = OrderWineModel::where(['id' => $this->id,'user_id' => $this->user_id])->find();
        if(empty($this->data['orderInfo'])) return json(errRes([],'未知订单'));
        $this->data['orderInfo']['express_type_text'] = DictUtil::getDictName('expressType',$this->data['orderInfo']['express_type']);
        if($this->data['orderInfo']['express_type'] == 1){
            $addressArr = explode('-',$this->data['orderInfo']['address_info']);
        }else{
            $addressArr = explode('-',$this->data['orderInfo']['shop_info']);
        }
        $this->data['orderInfo']['address_name'] = $addressArr[0];
        $this->data['orderInfo']['address_phone'] = isset($addressArr[1]) ? $addressArr[1] : '';
        unset($addressArr[0]);
        if(isset($addressArr[1])) unset($addressArr[1]);
        $this->data['orderInfo']['address_address'] = implode('',$addressArr);
        $this->data['orderInfo']['status_text'] = DictUtil::getDictName('orderStatus',$this->data['orderInfo']['status']);
        $this->data['wineList'] = OrderWineGoodsModel::where('order_id',$this->id)->order('id asc')->select();
        foreach($this->data['wineList'] as $v){
            $v['img'] = Config::get('app.upload.img_url').str_replace('\\','/',$v['img']);
            $v['wine_size_text'] = DictUtil::getDictName('wineSize',$v['wine_size']);
        }
        return json(sucRes($this->data));
    }

    //---------------------------------操作API---------------------------------
    /**
     * 修改个人信息
     * @return \think\response\Json
     */
    public function editUser(){
        if(empty($this->param['name']) || empty($this->param['phone'])|| empty($this->param['code'])) return json(errRes([],'参数错误'));
        $userInfo = UserModel::get($this->user_id);
        if($userInfo['phone'] == $this->param['phone']) return json(errRes([],'手机号码未修改'));
        //判断是否发送
        $checkResult = Sms::checkSms($this->param['phone'],$this->param['code']);
        if($checkResult['code'] != lang('success_code')) return json($checkResult);
        $isExists = UserModel::where(['phone' => $this->param['phone']])->find();
        if(!empty($isExists)) return json(errRes([],'该手机号码已注册'));
        $result = $userInfo->save(['name' => $this->param['name'],'phone' => $this->param['phone']]);
        return json(operateResult($result,'信息保存'));
    }

    /**
     * 取消订单
     * @return \think\response\Json
     */
    public function cancelOrder(){
        if(empty($this->param['id'])) return json(errRes([],'参数错误'));
        $userInfo = OrderWineModel::get(['user_id' => $this->user_id,'id' => $this->id,'status' => 0]);
        if(empty($userInfo)) return json(errRes([],'参数错误'));
        $result = $userInfo->save(['status' => 3,'cancel_time' => date('Y-m-d',time())]);
        return json(operateResult($result,'取消订单'));
    }

}

