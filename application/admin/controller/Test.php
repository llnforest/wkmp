<?php
/**
 * 菜单管理控制器
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\SysDictModel;
use app\admin\model\SysMenuModel;
use chromephp\chromephp;
use common\dict\DictUtil;
use think\App;
use think\Controller;
use think\facade\Cache;
use think\facade\Hook;
use think\facade\Session;

class Test extends Controller
{
    function test1(){
        $value = SysDictModel::where(['id'=>1])->value('dict_name');
        $value = SysDictModel::order('sort desc')->value('dict_name');
//        echo $value;

        $value = SysDictModel::where(['id'=>1])->column('dict_name','id');
        chromephp::info($value);
        $value = SysDictModel::column('dict_name');
        chromephp::info($value);

    }

    function testCache(){
        Cache::tag('a')->set('one',true);
//        chromephp::info(Cache::get('b.one'));
        chromephp::info(Cache::get('one'));
//        chromephp::info(Cache::tag('a')->get('one'));
    }

    function clearSession(){
        Session::clear();
    }
    function login(){
//        Hook::listen('smsSend',135);
        return json(['code'=>1,'msg'=>'ok,sucess']);
    }

    public function decryptData()
    {

        $encryptedData = 'LNqeK2Hw19saUbJ6stgEaSxinQ63lRAyHyI1vH69JGAMjPjb6/gtF2FkFkEsFnfBzXa54IzgXDcfJFfVXt9+fZ/39b5rN28n60fuG38hGE8x+YshsbYfAsFPYXI/yJW+oKm2VmkpV630FlJz5oWNsZaBmxDUajpIgVwt8S+JaPHPZMfQfGoKc1dlSWv6gRxOt5OknsKoa6hCRmvJvKZGbUSZX5OpXb5zlkyZ5ArUtEQOyz8DZs7cCyO1YI9aiRvx';
        $key = 'XeSVAIzEEevEUPrT8+Mn2A==';
        $iv = 0;
        $aesKey=base64_decode($key);

        $aesIV=base64_decode($iv);

        $aesCipher=base64_decode($encryptedData);

        $result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);
        var_dump($result);
//        return $result;
    }
}