<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 16:04
 */

namespace app\admin\controller;


use common\auth\AuthUtil;
use common\request\RequestUtil;
use think\App;
use think\Controller;
use think\facade\Session;

class AuthController extends  Controller
{
    protected $data;
    protected $request;
    protected $param;
    protected $post;
    protected $id;
    protected $userSession;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->request = $app->request;
        $this->param = $this->request->param();
        $this->post = $this->request->post();
        $this->id = isset($this->param['id'])?intval($this->param['id']):0;
        $this->userSession = Session::get('userInfo');
//        $this->userSession = null;
//        $this->userSession = SysUserModel::get(1);//测试
        $login_url = 'admin/index/login';
        $action_url = RequestUtil::getUrlPath($this->request);
        if(empty($this->userSession) && $action_url != $login_url){
            $this->redirect($login_url);//强制跳转登录界面
        }elseif ($this->data['auth']['url'] != $login_url){//非登录接口权限验证
            $this->data['auth'] = AuthUtil::getUrlAuth(Session::get('auth'),$action_url,Session::get('userInfo'),$this->request);
            if(!$this->data['auth']){
                if($this->request->isPost()) $this->error('您没有操作权限');
                else $this->error('您没有查看权限');
            }
        }


    }


}