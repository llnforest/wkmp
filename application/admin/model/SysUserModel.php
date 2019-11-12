<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/8
 * Time: 14:04
 */

namespace app\admin\model;


use think\Model;
use think\model\concern\SoftDelete;

class SysUserModel extends Model
{
    protected $table = "sys_user";
    protected $autoWriteTimestamp = 'datetime';
    use SoftDelete;
    protected $deleteTime = 'delete_time';
}