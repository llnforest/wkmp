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

class Index extends AuthController
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
        $this->data['bannerList'] = [];
        $this->data['labelList'] = [];
        $this->data['centerBanner'] = [];
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
        foreach($this->data['brandList'] as &$v){
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
        //酒详情
        $this->data['wineInfo'] = WineModel::alias('a')
            ->join('pin_wine_brand b',['a.brand_id' => 'b.id'],'left')
            ->where(['a.id'=>$this->id,'a.status' => 1,'b.status' => 1])
            ->field('a.*,b.brand_name')
            ->find();
        if(empty($this->data['wineInfo'])) return json(errRes([],'酒品已下架或不存在'));
        $this->data['wineInfo']['img'] = Config::get('app.upload.img_url').str_replace('\\','/',$this->data['wineInfo']['img']);
        $this->data['wineInfo']['wine_size_text'] = DictUtil::getDictName('wineSize',$this->data['wineInfo']['wine_size']);
        $this->data['wineInfo']['wine_cate_text'] = DictUtil::getDictName('wineCate',$this->data['wineInfo']['wine_cate']);

        //商品图和详情图
        $imgList = WineImgsModel::where('wine_id',$this->id)->order('sort asc')->select();
        $this->data['jptList'] = [];
        $this->data['xqtList'] = [];
        foreach($imgList as $v){
            $v['img'] = Config::get('app.upload.img_url').str_replace('\\','/',$v['img']);
            if($v['type'] == 1) $this->data['jptList'][] = $v;
            elseif($v['type'] == 2) $this->data['xqtList'][] = $v;
        }
        $this->data['cart_num'] = UserCartModel::where('user_id',$this->user_id)->count();


        return json(sucRes($this->data));
    }

    /**
     * 酒品搜索列表
     * @return \think\response\Json
     */
    public function searchList(){
        $where[] = ['a.status','=',1];
        $where[] = ['b.status','=',1];
        if(!empty($this->param['keywords'])) $where[] = ['a.wine_name|b.brand_name','like','%'.$this->param['keywords'].'%'];
        $page = !empty($this->param['page'])?$this->param['page']:1;
        $this->data['wineList'] = WineModel::alias('a')
            ->join('pin_wine_brand b','a.brand_id = b.id','left')
            ->field('a.*')
            ->where($where)->order('b.sort asc,a.sort asc')
            ->page($page,Config::get('paginate.list_rows'))->select();
        foreach($this->data['wineList'] as &$v){
            $v['img'] = Config::get('app.upload.img_url').str_replace('\\','/',$v['img']);
            $v['wine_size_text'] = DictUtil::getDictName('wineSize',$v['wine_size']);
        }
        return json(sucRes($this->data));
    }

    /**
     * 酒品搜索页面
     * @return \think\response\Json
     */
    public function search(){
        //最近搜索
        $this->data['searchList'] = UserSerachModel::where(['user_id' => $this->user_id])->order('create_time desc')->limit(10)->select();
        //热门搜索
        $this->data['hotList'] = SiteSearchHotModel::order('sort asc')->limit(10)->select();

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
            $result = UserCartModel::create(['user_id' => $this->user_id,'wine_id' => $this->param['wine_id']]);
        }else{
            $this->data['num'] = 0;
            $result = UserCartModel::where(['user_id' => $this->user_id,'wine_id' => $this->param['wine_id']])->where('quantity','<',100)->setInc('quantity',1);
        }
        return json(sucRes($this->data,'加入购物车成功'));
    }

    /**
     * 搜索页面：增加搜索
     * @return \think\response\Json
     */
    public function searchAdd(){
        //最近搜索
        $info = UserSerachModel::get(['user_id' => $this->user_id,'keywords' => $this->param['keywords']]);
        if(empty($info)){
            $this->data['result'] = UserSerachModel::create(['user_id' => $this->user_id,'keywords' => $this->param['keywords']]);
        }else{
            $this->data['result'] = $info->save(['create_time' => date('Y-m-d H:i:s',time())]);
        }
        return json(sucRes($this->data));
    }

    /**
     * 搜索页面：关键词删除
     * @return \think\response\Json
     */
    public function searchDel(){
        //最近搜索
        $result = UserSerachModel::where(['user_id' => $this->user_id])->delete();
        return json(operateResult($result,'最近搜索清空'));
    }

}

