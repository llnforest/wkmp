<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/8
 * Time: 14:04
 */

namespace model;


use think\Model;

class OrderGiftModel extends Model
{
    protected $table = "pin_user_order_gift";
    protected $autoWriteTimestamp = 'datetime';
}