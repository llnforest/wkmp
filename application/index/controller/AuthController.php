<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 16:04
 */

namespace app\index\controller;


use think\App;
use think\Controller;

class AuthController extends  Controller
{
    protected $data;
    protected $request;
    protected $param;
    protected $post;
    protected $id;
    protected $user_id;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->request = $app->request;
        $this->param = $this->request->param();
        $this->post = $this->request->post();
        $this->id = isset($this->param['id'])?intval($this->param['id']):0;
        $this->user_id = 1;


    }


}