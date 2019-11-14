<?php
/**
 * 菜单管理控制器
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\OrderGiftModel;
use think\App;

class Ordergift extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,OrderGiftModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            $this->page->setHeader('ID,订单ID,用户姓名,手机号码,邀请人员,邀请人手机号码,邀请人会员等级,订单状态,礼品类型,订单金额,配送地址,创建时间,最后操作时间,订单状态');
            $this->pageUtil->setColsWidthArr([1=>160,2=>100,3=>120,4=>240,7=>100,8=>200,9=>100,11=>160,12=>160,14=>200]);
            $this->pageUtil->setColsMinWidthArr([10=>300]);
            $this->pageUtil->setColTemplet(4,"#combineTpl");
            $this->pageUtil->setColsHideArr([5,6,13]);
            $this->pageUtil->setShowNumbers(false);
            $this->pageUtil->setToolbarId("listBarTool");
        }else{
            $this->pageUtil->setDataDictArr([6=>'userLevel',7=>'orderStatus',8=>'giftType']);
            $where  = getWhereParam(['a.contact_name'=>'like','a.contact_phone'=>'like','b.name'=>'like','b.phone'=>'like','a.status','a.create_time'=>['create_start','create_end'],'a.update_time'=>['update_start','update_end']],$this->param);
            $pageData = $this->model::alias('a')
                ->join('pin_user b','a.from_id = b.id','left')
                ->field('a.id,a.id as order_id,a.contact_name,a.contact_phone,b.name,b.phone,b.level,a.status,a.gift_type,a.total_money,a.address_info,a.create_time,a.update_time,a.status as order_status')
                ->where($where)
                ->order('a.create_time desc')
                ->paginate($this->param['limit']?:"");
            $this->page->setData($pageData);
        }

    }
}