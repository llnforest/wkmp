<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/8
 * Time: 14:04
 */

namespace app\admin\model;


use think\Model;

class SysLogModel extends Model
{
    protected $table = "sys_log";
    protected $autoWriteTimestamp = 'datetime';
}