<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 16:04
 */

namespace app\index\controller;


use think\App;

class BaseController extends  AuthController
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
    }


}