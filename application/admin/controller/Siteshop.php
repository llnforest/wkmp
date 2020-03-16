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
            $this->page->setHeader('ID,排序,商家封面,商家名称,联系方式,商家地址,门店编号,创建时间');
            $this->pageUtil->setColEdit(1);
            $this->pageUtil->setColsWidthArr([1=>100,2=>100,4=>120,6=>150,7=>160]);
            $this->pageUtil->setColsMinWidthArr([3=>200,5=>300]);
            $this->pageUtil->setColTemplet(2,"#imgTpl");
        }else{
            $where  = getWhereParam(['shop_name'=>'like','phone'=>'like'],$this->post);
            $pageData = $this->model::field('id,sort,img,shop_name,phone,address,shop_no,create_time')
                ->where($where)
                ->order('sort asc,create_time desc')
                ->paginate($this->param['limit']?:"");
            $this->page->setData($pageData);
        }

    }



}