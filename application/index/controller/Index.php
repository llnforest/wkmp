<?php
/**
 * User: Lynn
 * Date: 2019/11/18
 * Time: 11:55
 */

namespace app\index\controller;


use app\index\model\SiteBannerModel;
use think\App;
use think\facade\Config;

class Index extends BaseController
{
    protected $data;
    function __construct(App $app = null)
    {
        parent::__construct($app);
    }

    public function index(){
        $bannerList = SiteBannerModel::where('status',1)->where('position_id','in',[1,2,3])->order('sort asc')->select();
        foreach($bannerList as $v){
            $v['img'] = Config::get('app.upload.img_url').str_replace('\\','/',$v['img']);
            if($v['position_id'] == 1) $this->data['bannerList'][] = $v;
            elseif($v['position_id'] == 2) $this->data['labelList'][] = $v;
            elseif($v['position_id'] == 3) $this->data['centerBanner'] = $v;
        }


        return json(sucRes($this->data));
    }

}