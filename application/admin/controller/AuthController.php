<?php
/**
 * User: Lynn
 * Date: 2019/4/4
 * Time: 16:04
 */

namespace app\admin\controller;


use app\admin\model\UserModel;
use chromephp\chromephp;
use common\auth\AuthUtil;
use common\request\RequestUtil;
use think\App;
use think\Controller;
use think\facade\Session;
use think\response\Redirect;

class AuthController extends  Controller
{
    protected $data;
    protected $request;
    protected $param;
    protected $id;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->request = $app->request;
        $this->param = $this->request->param();
        $this->id = isset($this->param['id'])?intval($this->param['id']):0;
        $userSession = Session::get('userInfo');
//        $userSession = UserModel::get(1);//测试
        $login_url = 'admin/index/login';
        $action_url = RequestUtil::getUrlPath($this->request);
        if(empty($userSession) && $action_url != $login_url){
            $this->redirect($login_url);//强制跳转登录界面
        }elseif ($this->data['auth']['url'] != $login_url){//非登录接口权限验证
            $this->data['auth'] = AuthUtil::getUrlAuth(Session::get('auth'),$action_url,Session::get('userInfo'),$this->request);
            if(!$this->data['auth']) $this->error('您没有访问权限');
        }


    }


}