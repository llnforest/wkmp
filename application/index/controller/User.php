<?php
/**
 * User: Lynn
 * Date: 2019/11/18
 * Time: 11:55
 */

namespace app\index\controller;


use app\index\model\SiteBannerModel;
use app\index\model\SiteInfoModel;
use app\index\model\SiteSearchHotModel;
use app\index\model\SysDictModel;
use app\index\model\SysDictValueModel;
use app\index\model\UserCartModel;
use app\index\model\UserModel;
use app\index\model\UserProfitModel;
use app\index\model\UserSerachModel;
use app\index\model\UserTakeModel;
use app\index\model\WineBrandModel;
use app\index\model\WineImgsModel;
use app\index\model\WineModel;
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

