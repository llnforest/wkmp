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
use app\index\model\SiteShopModel;
use app\index\model\SysConfigModel;
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
        $this->data['total_money'] = $this->data['vip_money'] = 0;
        foreach($this->data['cartList'] as $v){
            $this->data['total_money'] += $v['mall_price']*$v['quantity'];
            $this->data['vip_money'] += $v['vip_price']*$v['quantity'];
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
        $this->data['shopList'] = SiteShopModel::order('sort asc,create_time desc')->select();
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
        if(!$this->request->has('ids') || !$this->request->has('type')) return json(errRes([],'参数错误'));
        if($this->param['type'] == 0){
            $this->data['wineList'] = WineModel::alias('a')
                ->leftJoin('pin_wine_brand b','a.brand_id = b.id')
                ->field('a.*')
                ->where([['a.status','=',1],['b.status','=',1],['a.id','in',$this->param['ids']]])->order('a.sort asc')->select();

        }else{
            $this->data['wineList'] = WineModel::alias('a')
                ->leftJoin('pin_wine_brand b','a.brand_id = b.id')
                ->leftJoin('pin_user_cart c','c.user_id = '.$this->user_id.' and a.id = c.wine_id')
                ->field('a.*,b.quantity')
                ->where([['a.status','=',1],['b.status','=',1],['a.id','in',$this->param['ids']]])->order('a.sort asc')->select();
        }
        $this->data['count'] = 0;
        $this->data['total_money'] = 0;
        $this->data['vip_money'] = 0;
        foreach($this->data['wineList'] as $v){
            if(!isset($v['quantity'])) $v['quantity'] = 1;
            $v['img'] = Config::get('app.upload.img_url').str_replace('\\','/',$v['img']);
            $v['wine_size_text'] = DictUtil::getDictName('wineSize',$v['wine_size']);
            $this->data['count'] += $v['quantity'];
            $this->data['total_money'] += $v['quantity']*$v['mall_price'];
            $this->data['vip_money'] += $v['quantity']*$v['vip_price'];
        }
        $this->data['perExpress'] = SysConfigModel::where(['config_code' => 'winePerExpressPrice'])->value('config_value');
        $this->data['baseExpress'] = SysConfigModel::where(['config_code' => 'wineStartExpreePrice'])->value('config_value');
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
        $this->data['orderInfo']['express_type_text'] = DictUtil::getDictName('expressType',$this->data['orderInfo']['express_type']);
        if($this->data['orderInfo']['express_type'] == 1){
            $addressArr = explode('-',$this->data['orderInfo']['address_info']);
        }else{
            $addressArr = explode('-',$this->data['orderInfo']['shop_info']);
        }
        $this->data['orderInfo']['address_name'] = $addressArr[0];
        $this->data['orderInfo']['address_phone'] = isset($addressArr[1]) ? $addressArr[1] : '';
        unset($addressArr[0]);
        if(isset($addressArr[1])) unset($addressArr[1]);
        $this->data['orderInfo']['address_address'] = implode('',$addressArr);
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

    /**
     * 获取默认地址
     * @return \think\response\Json
     */
    public function getDefaultAddress(){
        $this->data['addressInfo'] = UserAddressModel::where(['user_id' => $this->user_id])->order('is_default desc,create_time desc')->find();
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
        return json(operateResult($result,'del'));
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
        return json(operateResult($result,'edit'));
    }

    /**
     * 添加地址
     * @return \think\response\Json
     */
    public function addAddress(){
        if(!$this->request->has('contact_name') || !$this->request->has('contact_phone') || !$this->request->has('address')) return json(errRes([],'参数错误'));
        UserAddressModel::where(['user_id' => $this->user_id])->update(['is_default' => 0]);
        $result = UserAddressModel::create(['contact_name' => $this->param['contact_name'],'contact_phone' => $this->param['contact_phone'],'address' => $this->param['address'],'user_id' => $this->user_id]);
        return json(operateResult($result,'add'));
    }

    /**
     * 删除地址
     * @return \think\response\Json
     */
    public function delAddress(){
        if(empty($this->param['id'])) return json(errRes([],'参数错误'));
        $result = UserAddressModel::where([['id','=',$this->param['id']],['user_id','=',$this->user_id]])->delete();
        $isExistsDefault = UserAddressModel::get(['user_id' => $this->user_id,'is_default' => 1]);
        if(empty($isExistsDefault)){
            $isExists = UserAddressModel::get(['user_id' => $this->user_id]);
            if(!empty($isExists)) $isExists->save(['is_default' => 1]);
        }
        return json(operateResult($result,'del'));
    }
    /**
     * 设置默认项
     * @return \think\response\Json
     */
    public function setAddressDefault(){
        if(empty($this->param['id'])) return json(errRes([],'参数错误'));
        UserAddressModel::where(['user_id' => $this->user_id])->update(['is_default' => 0]);
        $result = UserAddressModel::where([['id','=',$this->param['id']],['user_id','=',$this->user_id]])->update(['is_default' => 1]);

        return json(operateResult($result,'默认地址修改'));
    }
    /**
     * 下单
     * @return \think\response\Json
     */
    public function makeOrder(){
        if(!$this->request->has('wineList') || !$this->request->has('shop_id') || !$this->request->has('express_type') || !$this->request->has('user_remark') || !$this->request->has('address_id')) return json(errRes([],'参数错误'));



        return json(operateResult(['id' => '2019090112320923'],'下单'));
    }
}

