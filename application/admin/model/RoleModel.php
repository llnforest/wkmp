<?php
/**
 * User: Lynn
 * Date: 2019/4/8
 * Time: 14:04
 */

namespace app\admin\model;


use think\Model;

class RoleModel extends Model
{
    protected $table = "sys_role";
    protected $autoWriteTimestamp = 'datetime';
}