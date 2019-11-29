<?php
/**
 * User: Lynn
 * Date: 2019/11/18
 * Time: 11:55
 */

namespace app\index\controller;


use app\index\model\SiteBannerModel;
use app\index\model\SiteInfoModel;
use app\index\model\WineBrandModel;
use app\index\model\WineModel;
use think\App;
use think\facade\Config;

class Index extends BaseController
{
    protected $data;
    function __construct(App $app = null)
    {
        parent::__construct($app);
    }

    //首页
    public function index(){
        //banner图
        $bannerList = SiteBannerModel::where('status',1)->where('position_id','in',[1,2,3])->order('sort asc')->select();
        foreach($bannerList as $v){
            $v['img'] = Config::get('app.upload.img_url').str_replace('\\','/',$v['img']);
            if($v['position_id'] == 1) $this->data['bannerList'][] = $v;
            elseif($v['position_id'] == 2) $this->data['labelList'][] = $v;
            elseif($v['position_id'] == 3) $this->data['centerBanner'] = $v;
        }
        //推荐酒
        $this->data['wineList'] = WineModel::where(['status'=>1,'is_recommend'=>1])->order('sort asc')->limit(6)->select();
        foreach($this->data['wineList'] as &$v){
            $v['img'] = Config::get('app.upload.img_url').str_replace('\\','/',$v['img']);
        }
        //推荐品牌
        $this->data['brandList'] = WineBrandModel::where('status',1)->order('sort asc')->select();
        foreach($this->data['bannerList'] as &$v){
            $v['img'] = Config::get('app.upload.img_url').str_replace('\\','/',$v['img']);
        }
        //官网
        $this->data['siteInfo'] = SiteInfoModel::where('id',1)->find();
        $this->data['siteInfo']['img'] = Config::get('app.upload.img_url').str_replace('\\','/',$this->data['siteInfo']['img']);
        $this->data['siteInfo']['fir_img'] = Config::get('app.upload.img_url').str_replace('\\','/',$this->data['siteInfo']['fir_img']);
        $this->data['siteInfo']['sec_img'] = Config::get('app.upload.img_url').str_replace('\\','/',$this->data['siteInfo']['sec_img']);
        $this->data['siteInfo']['thr_img'] = Config::get('app.upload.img_url').str_replace('\\','/',$this->data['siteInfo']['thr_img']);
        return json(sucRes($this->data));
    }

}