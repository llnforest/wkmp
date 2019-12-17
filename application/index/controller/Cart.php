<?php
/**
 * User: Lynn
 * Date: 2019/11/18
 * Time: 11:55
 */

namespace app\index\controller;


use app\index\model\OrderWineGoodsModel;
use app\index\model\OrderWineModel;
use app\index\model\SiteBannerModel;
use app\index\model\SiteInfoModel;
use app\index\model\SiteSearchHotModel;
use app\index\model\SysDictModel;
use app\index\model\SysDictValueModel;
use app\index\model\UserAddressModel;
use app\index\model\UserCartModel;
use app\index\model\UserModel;
use app\index\model\UserProfitModel;
use app\index\model\UserSerachModel;
use app\index\model\WineModel;
use common\dict\DictUtil;
use think\App;
use think\facade\Config;

class Cart extends BaseController
{
    protected $data;
    function __construct(App $app = null)
    {
        parent::__construct($app);
    }


    /**
     * 购物车
     * @return \think\response\Json
     */
    public function cart(){
        $this->data['cartList'] = UserCartModel::alias('a')
            ->join('pin_wine b','a.wine_id = b.id','left')
            ->where(['a.user_id' => $this->user_id,'b.status' => 1])
            ->field('a.*,b.wine_name,b.img,b.wine_style,b.wine_cate,b.brand_id,b.wine_size,b.mall_price,b.vip_price')
            ->order('a.create_time desc')
            ->select();
        $this->data['total_money'] = 0;
        foreach($this->data['cartList'] as $v){
            $this->data['total_money'] += $v['mall_price'];
            $v['img'] = Config::get('app.upload.img_url').str_replace('\\','/',$v['img']);
            $v['wine_size_text'] = DictUtil::getDictName('wineSize',$v['wine_size']);
        }
        return json(sucRes($this->data));
    }

    /**
     * 门店列表页面
     * @return \think\response\Json
     */
    public function shop(){
        $this->data['shopList'] = WineModel::order('create_time desc')->select();
        foreach($this->data['shopList'] as $v){
            $v['img'] = Config::get('app.upload.img_url').str_replace('\\','/',$v['img']);
        }
        return json(sucRes($this->data));
    }

    /**
     * 提交订单页面
     * @return \think\response\Json
     */
    public function order(){
        if(!$this->request->has('ids')) return json(errRes([],'参数错误'));
        $this->data['wineList'] = WineModel::where([['status','=',1],['id','in',$this->param['ids']]])->order('id asc')->select();
        if(count($this->data['wineList']) == 0) return json(errRes([],'未知商品'));
        foreach($this->data['wineList'] as $v){
            $v['img'] = Config::get('app.upload.img_url').str_replace('\\','/',$v['img']);
            $v['wine_size_text'] = DictUtil::getDictName('wineSize',$v['wine_size']);
        }
        $this->data['addressInfo'] = UserAddressModel::where('user_id',$this->user_id)->order('create_time desc')->find();
        return json(sucRes($this->data));
    }

    /**
     * 确认付款页面
     * @return \think\response\Json
     */
    public function pay(){
        if(!$this->request->has('id')) return json(errRes([],'参数错误'));
        $this->data['orderInfo'] = OrderWineModel::where(['id' => $this->id,'user_id' => $this->user_id])->find();
        if(empty($this->data['orderInfo'])) return json(errRes([],'未知订单'));
        $this->data['wineList'] = OrderWineGoodsModel::where('order_id',$this->id)->order('id asc')->select();
        foreach($this->data['wineList'] as $v){
            $v['img'] = Config::get('app.upload.img_url').str_replace('\\','/',$v['img']);
            $v['wine_size_text'] = DictUtil::getDictName('wineSize',$v['wine_size']);
        }
        return json(sucRes($this->data));
    }

    /**
     * 地址列表
     * @return \think\response\Json
     */
    public function address(){
        $this->data['addressList'] = UserAddressModel::where('user_id',$this->user_id)->order('create_time desc')->select();
        return json(sucRes($this->data));
    }



    //---------------------------------操作API---------------------------------
    /**
     * 删除购物车
     * @return \think\response\Json
     */
    public function delCart(){
        if(empty($this->param['ids'])) return json(errRes([],'参数错误'));
        $result = UserCartModel::where([['id','in',$this->param['ids']],['user_id','=',$this->user_id]])->delete();
        return operateResult($result,'del');
    }

    /**
     * 修改购物车
     * @return \think\response\Json
     */
    public function editCart(){
        //type 1增 2减
        if(empty($this->param['id']) || empty($this->param['type'])) return json(errRes([],'参数错误'));
        if($this->param['type'] == 1){
            $result = UserCartModel::where(['id'=>$this->param['id'],'user_id' => $this->user_id])->where('quantity','<',100)->setInc('quantity');
        }else{
            $result = UserCartModel::where(['id'=>$this->param['id'],'user_id' => $this->user_id])->where('quantity','>',0)->setDec('quantity');
        }
        return operateResult($result,'edit');
    }

    /**
     * 添加地址
     * @return \think\response\Json
     */
    public function addAddress(){
        //type 1增 2减
        if(!$this->request->has('contact_name','contact_phone','address')) return json(errRes([],'参数错误'));
        $result = UserAddressModel::create(['contact_name' => $this->param['contact_name'],'contact_phone' => $this->param['contact_phone'],'address' => $this->param['address'],'user_id' => $this->user_id]);
        return operateResult($result,'add');
    }

    /**
     * 删除地址
     * @return \think\response\Json
     */
    public function delAddress(){
        if(empty($this->param['ids'])) return json(errRes([],'参数错误'));
        $result = UserAddressModel::where([['id','in',$this->param['ids']],['user_id','=',$this->user_id]])->delete();
        return operateResult($result,'del');
    }
}

