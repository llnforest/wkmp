<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/8
 * Time: 14:04
 */

namespace app\admin\model;


use think\Model;

class UserCartModel extends Model
{
    protected $table = "pin_user_cart";
    protected $autoWriteTimestamp = 'datetime';
}