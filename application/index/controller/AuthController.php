<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 16:04
 */

namespace app\index\controller;


use Firebase\JWT\JWT;
use think\App;
use think\facade\Config;

class AuthController extends  BaseController
{

    protected $user_id;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        if(!empty($this->param['token'])){
            $token = JWT::decode($this->param['token'],Config::get('app.token.key'),['HS256']);
            $this->user_id = $token['user_id'];
        }else{
            $this->user_id = 1;
        }


    }


}