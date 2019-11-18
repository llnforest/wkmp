<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/8
 * Time: 14:04
 */

namespace app\index\model;


use think\Model;

class SysUserConfigModel extends Model
{
    protected $table = "sys_user_config";
    protected $autoWriteTimestamp = 'datetime';
}