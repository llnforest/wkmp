<?php
/**
 * User: Lynn
 * Date: 2019/11/18
 * Time: 11:55
 */

namespace app\index\controller;


use app\index\model\OrderWineGoodsModel;
use app\index\model\OrderWineModel;
use app\index\model\SiteBannerModel;
use app\index\model\SiteInfoModel;
use app\index\model\SiteSearchHotModel;
use app\index\model\SysDictModel;
use app\index\model\SysDictValueModel;
use app\index\model\UserCartModel;
use app\index\model\UserModel;
use app\index\model\UserProfitModel;
use app\index\model\UserSerachModel;
use common\dict\DictUtil;
use think\App;
use think\facade\Config;

class User extends BaseController
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
        $this->data['payNum'] = OrderWineModel::where(['id'=>$this->user_id,'status'=>0])->count();
        return json(sucRes($this->data));
    }

    /**
     * 订单中心
     * @return \think\response\Json
     */
    public function orderlist(){
        $page = !empty($this->param['page'])?$this->param['page']:1;
        $where[] = ['user_id','=',$this->user_id];
        if(isset($this->post['status'])){
            $where[] = ['status','in',$this->post['status']];
        }
        $this->data['orderList'] = OrderWineModel::where($where)->page($page,Config::get('paginate.list_rows'))->select();
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


    //---------------------------------操作API---------------------------------
    /**
     * 修改个人信息
     * @return \think\response\Json
     */
    public function editUser(){
        if(empty($this->param['name']) || empty($this->param['phone'])) return json(errRes([],'参数错误'));
        $userInfo = UserModel::get($this->user_id);
        if($userInfo['phone'] == $this->param['phone']) return json(errRes([],'手机号码未修改'));
        $isExists = UserModel::where(['phone' => $this->param['phone']])->find();
        if(!empty($isExists)) return json(errRes([],'该手机号码已注册'));
        $userInfo->save(['name' => $this->param['name'],'phone' => $this->param['phone']]);
        return json(sucRes($this->data,'信息保存成功'));
    }

}

