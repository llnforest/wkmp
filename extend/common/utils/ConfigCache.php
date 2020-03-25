<?php
/**
 * User: Lynn
 * Date: 2020/3/24
 * Time: 15:16
 */

namespace common\utils;


use think\facade\Cache;

class ConfigCache
{
    /**
     * 获取系统配置
     * @param $para
     * @return bool
     */
    public static function get($para){
        $sysConfig = Cache::get('sys_config');
        return isset($sysConfig[$para]) ? $sysConfig[$para] : false;
    }

    //重新缓存配置数据
    public static function setConfigCache($sysConfig){
        Cache::set('sys_config',$sysConfig);
    }
}