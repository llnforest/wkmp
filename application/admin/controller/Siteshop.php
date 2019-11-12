<?php
/**
 * 菜单管理控制器
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\SiteShopModel;
use think\App;

class Siteshop extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,SiteShopModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            $this->page->setHeader('ID,排序,商家名称,联系方式,商家地址,添加时间');
            $this->pageUtil->setColEdit(1);
            $this->pageUtil->setColsWidthArr([1=>100,7=>150,8=>150]);
            $this->pageUtil->setColsMinWidthArr([2=>200,3=>150,4=>300]);
        }else{
            $where  = getWhereParam(['shop_name'=>'like','phone'=>'like'],$this->param);
            $pageData = $this->model::field('id,sort,shop_name,phone,address,create_time')
                ->where($where)
                ->order('sort asc')
                ->paginate($this->param['limit']?:"");
            $this->page->setData($pageData);
        }

    }



}