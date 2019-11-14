<?php
/**
 * 菜单管理控制器
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\UserCartModel;
use app\admin\model\UserModel;
use think\App;

class Usercart extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,UserCartModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            if(isset($this->param['user_id'])){
                $userInfo = UserModel::get($this->param['user_id']);
                $this->data['name'] = $userInfo->name;
                $this->data['phone'] = $userInfo->phone;
                $this->data['user_id'] = $userInfo->id;
            }
            $this->page->setHeader('ID,用户ID,会员姓名,手机号码,会员等级,酒品名称,上下架,会员价,vip价,购买数量,加入时间');
            $this->pageUtil->setColsWidthArr([1=>80,2=>100,3=>120,4=>100,6=>80,7=>80,8=>80,9=>100,10=>160,11=>90]);
            $this->pageUtil->setColsMinWidthArr([5=>180]);
            $this->pageUtil->setShowNumbers(false);

        }else{
            $this->pageUtil->setDataDictArr([4=>'userLevel',6=>'upDown']);
            $where  = getWhereParam(['a.user_id','b.name'=>'like','b.phone'=>'like','c.status','c.wine_name'=>'like','a.create_time'=>['create_start','create_end']],$this->param);
            $pageData = $this->model::alias('a')
                ->join('pin_user b','a.user_id = b.id','left')
                ->join('pin_wine c','a.wine_id = c.id','left')
                ->field('a.id,a.user_id,b.name,b.phone,b.level,c.wine_name,c.status,c.mall_price,c.vip_price,a.quantity,a.create_time')
                ->where($where)
                ->order('a.create_time desc')
                ->paginate($this->param['limit']?:"");
            $this->page->setData($pageData);
        }

    }

}