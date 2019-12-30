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

class Sms extends BaseController
{
    protected $data;
    function __construct(App $app = null)
    {
        parent::__construct($app);
    }

    /**
     * 发送验证码
     * @return \think\response\Json
     */
    public function sendCode(){
        $this->data['code'] = '1234';
        return json(sucRes($this->data,'验证码发送成功'));
    }



}

