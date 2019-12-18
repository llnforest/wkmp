<?php
/**
 * 菜单管理控制器
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\OrderWineGoodsModel;
use app\admin\model\OrderWineModel;
use app\admin\model\SiteExressModel;
use app\admin\model\UserModel;
use common\dict\DictUtil;
use think\App;

class Orderwine extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,OrderWineModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            $this->page->setHeader('ID,订单编号,用户信息,订单状态,订单状态,订单金额,酒品总额,酒品返佣,快递费用,配送类型,地址说明,配送快递,用户备注,后台备注,下单时间,最后操作时间');
            $this->pageUtil->setColsWidthArr([1=>160,2=>240,3=>100,5=>100,6=>100,7=>100,8=>100,9=>100,11=>160,14=>160,15=>160,16=>270]);
            $this->pageUtil->setColsMinWidthArr([10=>300,12=>300,13=>300]);
            $this->pageUtil->setColsHideArr([4]);
            $this->pageUtil->setColsEditArr([10,13]);
            $this->pageUtil->setShowNumbers(false);
            $this->pageUtil->setToolbarId("listBarTool");
        }else{
            $this->pageUtil->setDataDictArr([3=>'orderStatus',9=>'expressType']);
            $where  = getWhereParam(['a.id','a.express_type','a.express'=>'like','b.name'=>'like','b.phone'=>'like','a.status','a.create_time'=>['create_start','create_end'],'a.update_time'=>['update_start','update_end']],$this->post);
            $pageData = $this->model::alias('a')
                ->join('pin_user b','a.user_id = b.id','left')
                ->join('pin_site_express c','a.express_id = c.id','left')
                ->field('a.id,a.id as order_id,b.name,b.phone,b.level,a.status,a.status as order_status,a.total_money,mall_wine_money,vip_wine_money,express_price,express_type,a.address_info,shop_info,c.express as express_name,a.express,user_remark,a.remark,a.create_time,a.update_time')
                ->where($where)
                ->order('a.create_time desc')
                ->paginate($this->param['limit']?:"")
                ->each(function($item,$key){
                    if($item['level'] > 0){
                        $item['vip_wine_money'] = $item['mall_wine_money'] - $item['vip_wine_money'];
                    }else{
                        $item['vip_wine_money'] = '';
                    }
                    $item['name'] = $item['name'].'-'.$item['phone'].'-'.DictUtil::getDictNameColor('userLevel',$item['level']);
                    $item['address_info'] = $item['express_type'] == 1 ? '收件地址：'.$item['address_info'] : '自提门店：'.$item['shop_info'];
                    if(!empty($item['express_name'])) $item['express_name'] .= '('.$item['express'].')';

                    unset($item['express']);
                    unset($item['shop_info']);
                    unset($item['phone']);
                    unset($item['level']);
                    return $item;
                });
            $this->page->setData($pageData);
        }
    }

    /**
     * 支付接口
     */
    public function setPay(){
        if($this->request->isPost()){
            $result = false;
            if(!isset($this->param['id']) || empty($info = $this->model::get($this->id))) return paramRes();
            if($info->status == 0) $result = $info->save(['status' => 1]);
            return handleResult($result,'支付');
        }
    }

    /**
     * 发货接口
     */
    public function setSend(){
        if($this->request->isPost()){
            $result = false;
            if(!isset($this->param['id']) || empty($info = $this->model::get($this->id))) return paramRes();
            if($info->status == 1) $result = $info->save(['status' => 2]);
            return handleResult($result,'发货');
        }
    }

    /**
     * 完成接口
     */
    public function setSuccess(){
        if($this->request->isPost()){
            $result = false;
            if(!isset($this->param['id']) || empty($info = $this->model::get($this->id))) return paramRes();
            if($info->status == 2) $result = $info->save(['status' => 4]);
            return handleResult($result,'完成交易');
        }
    }

    /**
     * 取消接口
     */
    public function setCancel(){
        if($this->request->isPost()){
            $result = false;
            if(!isset($this->param['id']) || empty($info = $this->model::get($this->id))) return paramRes();
            if(!in_array($info->status,[3,4])) $result = $info->save(['status' => 3]);
            return handleResult($result,'取消交易');
        }
    }

    //详情
    public function beforeDetail(){
        $this->data['info']['status_text'] = DictUtil::getDictNameColor('orderStatus',$this->data['info']['status']);
        $this->data['info']['express_type_text'] = DictUtil::getDictNameColor('expressType',$this->data['info']['express_type']);
        $this->data['user'] = UserModel::get($this->data['info']['user_id']);
        $this->data['user']['level_text'] = DictUtil::getDictNameColor('userLevel',$this->data['user']['level']);
        $this->data['express'] = SiteExressModel::get($this->data['info']['user_id']);

        $this->data['goodsList'] = OrderWineGoodsModel::where(['order_id' => $this->data['info']['id']])->order('create_time asc')->select();
        foreach($this->data['goodsList'] as &$v){
            $v['wine_style'] = DictUtil::getDictNameColor('wineStyle',$v['wine_style']);
            $v['wine_size'] = DictUtil::getDictNameColor('wineSize',$v['wine_size']);
        }

    }


}