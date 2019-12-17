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
        $this->data['userInfo']['user_type'] = DictUtil::getDictName('userType',$this->data['userInfo']['type']);
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
                $v_v['wine_size_text'] = DictUtil::getDictName('wineSize',$v['wine_size']);
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
        $userInfo->save(['name' => $this->param['name'],'phone' => $this->param['phone']]);
        return json(sucRes($this->data));
    }

}

