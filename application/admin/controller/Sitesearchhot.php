<?php
/**
 * 菜单管理控制器
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\SiteSearchHotModel;
use think\App;

class Sitesearchhot extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,SiteSearchHotModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            $this->page->setHeader('ID,排序,热搜关键词,创建时间');
            $this->pageUtil->setColEdit(1);
            $this->pageUtil->setColsWidthArr([1=>100,3=>160,4=>150]);
            $this->pageUtil->setColsMinWidthArr([2=>200]);
        }else{
            $where  = getWhereParam(['keywords'=>'like'],$this->post);
            $pageData = $this->model::field('id,sort,keywords,create_time')
                ->where($where)
                ->order('sort asc,create_time desc')
                ->paginate($this->param['limit']?:"");
            $this->page->setData($pageData);
        }

    }



}