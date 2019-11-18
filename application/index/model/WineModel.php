<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/8
 * Time: 14:04
 */

namespace app\index\model;


use think\Model;

class WineModel extends Model
{
    protected $table = "pin_wine";
    protected $autoWriteTimestamp = 'datetime';
}