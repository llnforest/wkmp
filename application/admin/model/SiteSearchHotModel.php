<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/8
 * Time: 14:04
 */

namespace app\admin\model;


use think\Model;

class SiteSearchHotModel extends Model
{
    protected $table = "pin_site_search_hot";
    protected $autoWriteTimestamp = 'datetime';
}