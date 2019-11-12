<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/17
 * Time: 13:48
 */
namespace common\request;


use chromephp\chromephp;

class RequestUtil
{
    /**
     * 获取url 的 模块/控制器/方法
     * @param $request
     * @return string
     */
    public static function getUrlPath($request){
        return strtolower($request->module().'/'.$request->controller().'/'.$request->action());
    }


}