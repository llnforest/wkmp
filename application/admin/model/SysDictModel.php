<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/8
 * Time: 14:04
 */

namespace app\admin\model;


use think\Model;

class SysDictModel extends Model
{
    protected $table = "sys_dict";
    protected $autoWriteTimestamp = 'datetime';
}