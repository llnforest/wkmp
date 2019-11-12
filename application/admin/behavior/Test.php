<?php
/**
 * Sysuser: Lynn
 * Date: 2019/11/8
 * Time: 16:58
 */

namespace app\admin\behavior;



use think\Request;

class Test
{
    public function run(Request $request,$param){
        echo $request->url().PHP_EOL;
        echo $param.PHP_EOL;
    }

    public function appInit($param)
    {
        echo $param.'_init'.PHP_EOL;
    }
//
//    public function appEnd($param)
//    {
//        echo $param.'_end'.PHP_EOL;
//    }
}