<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/8
 * Time: 14:04
 */

namespace model;


use think\Model;

class OrderWineModel extends Model
{
    protected $table = "pin_wine_order";
    protected $autoWriteTimestamp = 'datetime';
}