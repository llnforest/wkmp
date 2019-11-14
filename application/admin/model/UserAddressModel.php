<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/8
 * Time: 14:04
 */

namespace app\admin\model;


use think\Model;

class UserAddressModel extends Model
{
    protected $table = "pin_user_address";
    protected $autoWriteTimestamp = 'datetime';
}