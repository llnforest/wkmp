<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/8
 * Time: 14:04
 */

namespace app\admin\model;


use think\Model;

class SiteBannerModel extends Model
{
    protected $table = "pin_site_banner";
    protected $autoWriteTimestamp = 'datetime';
}