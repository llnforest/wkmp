<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/8
 * Time: 14:04
 */

namespace app\admin\model;


use think\Model;

class OrderWineGoodsModel extends Model
{
    protected $table = "pin_wine_order_wines";
    protected $autoWriteTimestamp = 'datetime';
}