<?php
/**
 * 菜单管理控制器
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\OrderGiftModel;
use app\admin\model\UserAddressModel;
use app\admin\model\UserModel;
use common\profit\Profit;

use think\App;

class Ordergift extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,OrderGiftModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            $this->page->setHeader('ID,订单编号,用户姓名,手机号码,邀请人员,邀请人手机号码,邀请人会员等级,订单状态,礼品类型,订单金额,配送地址,配送快递,下单时间,最后操作时间,订单状态');
            $this->pageUtil->setColsWidthArr([1=>160,2=>100,3=>120,4=>240,7=>100,8=>200,9=>100,11=>220,12=>160,13=>160,15=>200]);
            $this->pageUtil->setColsMinWidthArr([10=>300]);
            $this->pageUtil->setColTemplet(4,"#combineTpl");
            $this->pageUtil->setColsHideArr([5,6,14]);
            $this->pageUtil->setColsEditArr([10]);
            $this->pageUtil->setShowNumbers(false);
            $this->pageUtil->setToolbarId("listBarTool");
        }else{
            $this->pageUtil->setDataDictArr([6=>'userLevel',7=>'orderStatus',8=>'giftType']);
            $where  = getWhereParam(['a.id','a.contact_name'=>'like','a.contact_phone'=>'like','b.name'=>'like','b.phone'=>'like','a.status','a.create_time'=>['create_start','create_end'],'a.update_time'=>['update_start','update_end']],$this->post);
            $pageData = $this->model::alias('a')
                ->join('pin_user b','a.from_id = b.id','left')
                ->join('pin_site_express c','a.express_id = c.id','left')
                ->field('a.id,a.id as order_id,a.contact_name,a.contact_phone,b.name,b.phone,b.level,a.status,a.gift_type,a.total_money,a.address_info,c.express as express_name,a.express,a.true_express_price,a.create_time,a.update_time,a.status as order_status')
                ->where($where)
                ->order('a.create_time desc')
                ->paginate($this->param['limit']?:"")
                ->each(function($item,$key){
                    if(!empty($item['express_name'])) $item['express_name'] .= '-'.$item['true_express_price'].'元（'.$item['express'].'）';

                    unset($item['express']);
                    unset($item['true_express_price']);
                });
            $this->page->setData($pageData);
        }
    }

    /**
     * 支付接口
     */
    public function setPay(){
        if($this->request->isPost()){
            $result = false;
            if(!isset($this->param['id']) || empty($info = $this->model::get($this->id))) return paramRes();
            if($info->status == 0){
                $result = $info->save(['status' => 1,'pay_time' => date('Y-m-d H:i:s',time())]);
                UserModel::where('id',$info['user_id'])->update(['join_time' => date('Y-m-d H:i:s',time())]);
                Profit::giftProfit($result['id']);//计算收益
            }
            return handleResult($result,'支付');
        }
    }

    /**
     * 发货接口
     */
    public function setSend(){
        if($this->request->isPost()){
            $result = false;
            if(!isset($this->param['id']) || empty($info = $this->model::get($this->id))) return paramRes();
            if($info->status == 1) $result = $info->save(['status' => 2,'send_time' => date('Y-m-d H:i:s',time())]);
            return handleResult($result,'发货');
        }
    }

    /**
     * 完成接口
     */
    public function setSuccess(){
        if($this->request->isPost()){
            $result = false;
            if(!isset($this->param['id']) || empty($info = $this->model::get($this->id))) return paramRes();
            if($info->status == 2) $result = $info->save(['status' => 4,'success_time' => date('Y-m-d H:i:s',time())]);
            return handleResult($result,'完成交易');
        }
    }

    /**
     * 取消接口
     */
    public function setCancel(){
        if($this->request->isPost()){
            $result = false;
            if(!isset($this->param['id']) || empty($info = $this->model::get($this->id))) return paramRes();
            if(!in_array($info->status,[3,4])) $result = $info->save(['status' => 3,'cancel_time' => date('Y-m-d H:i:s',time())]);
            return handleResult($result,'取消交易');
        }
    }

    /**
     * 达达叫单
     * @return array
     */
    public function makeOrderForDada(){
        if($this->param['type'] == 0){//获取快递物流的相关信息
            $orderInfo = $this->model::where(['id' => $this->param['id']])->find();
            $data['price'] = $orderInfo['total_money'];
            $data['user_phone'] = '';
            $data['user_name'] = '';
            $data['user_address'] = '';
            if(!empty($orderInfo['address_info'])){
                $address = explode('--',$orderInfo['address_info']);
                if(isset($address[0])) $data['user_phone'] = $address[0];
                if(isset($address[1])) $data['user_name'] = $address[1];
                if(isset($address[2])) $data['user_address'] = $address[2];
            }else{//无地址启用用户地址
                $address = UserAddressModel::where(['user_id' => $orderInfo['user_id']])->order('is_default desc')->find();
                if(!empty($address)){
                    $data['user_name'] = $address['contact_name'];
                    $data['user_phone'] = $address['contact_phone'];
                    $data['user_address'] = $address['address'];
                }
            }
            return sucRes($data);
        }elseif ($this->param['type'] == 1){//获取达达的预算价格
            $result = DadaApi::queryDeliverFee($this->param);
            $addressInfo = $this->param['user_name'].'--'.$this->param['user_phone'].'--'.$this->param['user_address'];
            $this->model::where(['id' => $this->param['id']])->update(['address_info' => $addressInfo]);
            return ['code'=>0,'result' =>['fee'=>15,'distance'=>1900,'deliveryNo'=>'dd1292738428']];
            return $result;
        }elseif ($this->param['type'] == 2){//达达下单
            $result = DadaApi::addAfterQuery($this->param['delivery_no']);
            if($result->code == 0){
                $this->model::where(['id' => $this->param['id']])->update(['send_time'=>date('Y-m-d H:i:s',time()),'true_express_price' => $this->param['fee'],'status' => 2,'express_id'=>100,'express'=>$this->param['delivery_no']]);
            }
            return $result;
        }
    }

    /**
     * 快递发货
     * @return array
     */
    public function makeOrderForExpress(){
        if($this->param['type'] == 0){//获取快递物流的相关信息
            $orderInfo = $this->model::where(['id' => $this->param['id']])->find();
            $data['price'] = $orderInfo['total_money'];
            $data['user_phone'] = '';
            $data['user_name'] = '';
            $data['user_address'] = '';
            if(!empty($orderInfo['address_info'])){
                $address = explode('--',$orderInfo['address_info']);
                if(isset($address[0])) $data['user_phone'] = $address[0];
                if(isset($address[1])) $data['user_name'] = $address[1];
                if(isset($address[2])) $data['user_address'] = $address[2];
            }else{//无地址启用用户地址
                $address = UserAddressModel::where(['user_id' => $orderInfo['user_id']])->order('is_default desc')->find();
                if(!empty($address)){
                    $data['user_name'] = $address['contact_name'];
                    $data['user_phone'] = $address['contact_phone'];
                    $data['user_address'] = $address['address'];
                }
            }
            return sucRes($data);
        }elseif ($this->param['type'] == 1){//快递发货
            $info = $this->model::get($this->param['id']);
            $this->param['address_info'] = $this->param['user_name'].'--'.$this->param['user_phone'].'--'.$this->param['user_address'];
            $this->param['status'] = 2;
            $this->param['send_time'] = date('Y-m-d H:i:s',time());
            return handleResult($info->save($this->param),'发货');
        }
    }


}