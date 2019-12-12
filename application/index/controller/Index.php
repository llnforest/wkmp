<?php
/**
 * User: Lynn
 * Date: 2019/11/18
 * Time: 11:55
 */

namespace app\index\controller;


use app\index\model\SiteBannerModel;
use app\index\model\SiteInfoModel;
use app\index\model\SiteSearchHotModel;
use app\index\model\UserCartModel;
use app\index\model\UserSerachModel;
use app\index\model\WineBrandModel;
use app\index\model\WineImgsModel;
use app\index\model\WineModel;
use common\dict\DictUtil;
use think\App;
use think\facade\Config;

class Index extends BaseController
{
    protected $data;
    function __construct(App $app = null)
    {
        parent::__construct($app);
    }

    /**
     * 首页
     * @return \think\response\Json
     */
    public function index(){
        //banner图
        $bannerList = SiteBannerModel::where('status',1)->where('position_id','in',[1,2,3])->order('sort asc')->select();
        $this->data['bannerList'][] = [];
        $this->data['labelList'][] = [];
        $this->data['centerBanner'] = [];
        foreach($bannerList as $v){
            $v['img'] = Config::get('app.upload.img_url').str_replace('\\','/',$v['img']);
            if($v['position_id'] == 1) $this->data['bannerList'][] = $v;
            elseif($v['position_id'] == 2) $this->data['labelList'][] = $v;
            elseif($v['position_id'] == 3) $this->data['centerBanner'][] = $v;
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

    /**
     * 酒品详情
     * @return \think\response\Json
     */
    public function detail(){
        //商品图和详情图
        $imgList = WineImgsModel::where('wine_id',$this->id)->order('sort asc')->select();
        $this->data['imgList'] = [];
        $this->data['detailList'] = [];
        foreach($imgList as $v){
            $v['img'] = Config::get('app.upload.img_url').str_replace('\\','/',$v['img']);
            if($v['type'] == 1) $this->data['imgList'][] = $v;
            elseif($v['type'] == 2) $this->data['detailList'][] = $v;
        }
        //酒详情
        $this->data['wineInfo'] = WineModel::alias('a')
            ->join('pin_wine_brand b',['a.brand_id' => 'b.id'],'left')
            ->where(['a.id'=>$this->id])
            ->field('a.*,b.brand_name')
            ->find();
        $this->data['wineInfo']['wine_size'] = DictUtil::getDictName('wineSize',$this->data['wineInfo']['wine_size']);
        $this->data['wineInfo']['wine_cate'] = DictUtil::getDictName('wineCate',$this->data['wineInfo']['wine_cate']);
        return json(sucRes($this->data));
    }

    /**
     * 酒品搜索列表
     * @return \think\response\Json
     */
    public function searchList(){
        $where[] = ['status','=',1];
        if(!empty($this->param['keywords'])) $where[] = ['wine_name','like','%'.$this->param['wine_name'].'%'];
        if(isset($this->param['brand_id'])) $where[] = ['brand_id','=',$this->param['brand_id']];
        $page = !empty($this->param['page'])?$this->param['page']:1;
        $this->data['wineList'] = WineModel::where($where)->order('sort asc')->page($page,Config::get('paginate.list_rows'))->select();
        foreach($this->data['wineList'] as &$v){
            $v['img'] = Config::get('app.upload.img_url').str_replace('\\','/',$v['img']);
            $v['wine_size'] = DictUtil::getDictName('wineSize',$v['wine_size']);
        }
        return json(sucRes($this->data));
    }

    /**
     * 酒品搜索页面
     * @return \think\response\Json
     */
    public function search(){
        //最近搜索
        $this->data['keywordsList'] = UserSerachModel::where(['user_id' => $this->user_id])->order('create_time desc')->limit(10)->select();
        //热门搜索
        $this->data['hotList'] = SiteSearchHotModel::order('sort asc')->select();

        return json(sucRes($this->data));
    }

    //---------------------------------操作API---------------------------------
    /**
     * 详情页面：加入购入车
     * @return \think\response\Json
     */
    public function cartAdd(){
        $cartInfo = UserCartModel::where(['user_id' => $this->user_id,'wine_id' => $this->param['wine_id']])->find();
        if(empty($cartInfo)){
            $this->data['num'] = 1;
            UserCartModel::create(['user_id' => $this->user_id,'wine_id' => $this->param['wine_id']]);
        }else{
            $this->data['num'] = 0;
            UserCartModel::where(['user_id' => $this->user_id,'wine_id' => $this->param['wine_id']])->setInc('quantity',1);
        }
        return json(sucRes($this->data));
    }

    /**
     * 搜索页面：搜索操作
     * @return \think\response\Json
     */
    public function searchOperate(){
        //最近搜索
        $info = UserSerachModel::get(['user_id' => $this->user_id,'keywords' => $this->param['keywords']]);
        if(empty($info)){
            UserSerachModel::create(['user_id' => $this->user_id,'keywords' => $this->param['keywords']]);
        }else{
            $info->save(['create_time' => date('Y-m-d H:i:s',time())]);
        }
        return json(sucRes($this->data));
    }

    /**
     * 搜索页面：关键词删除
     * @return \think\response\Json
     */
    public function searchDel(){
        //最近搜索
        UserSerachModel::where(['user_id' => $this->user_id])->delete();
        return json(sucRes($this->data));
    }

}

