<?php
/**
 * User: Lynn
 * Date: 2019/4/8
 * Time: 14:04
 */

namespace app\admin\model;


use think\Model;

class ConfigModel extends Model
{
    protected $table = "sys_config";
    protected $autoWriteTimestamp = 'datetime';

    /**
     * 获取编码对应的数值
     * @param $config_code
     * @return string
     */
    public static function getValue($config_code){
        return self::where(['config_code'=>$config_code])->value('config_value');
    }
}