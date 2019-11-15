<?php
/**
 * 菜单管理控制器
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\SiteBannerModel;
use think\App;

class Sitebanner extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,SiteBannerModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            $this->page->setHeader('ID,排序,状态,广告位,广告图,广告标题,链接地址,创建时间,最后操作时间');
            $this->pageUtil->setColEdit(1);
            $this->pageUtil->setColsWidthArr([1=>100,2=>100,4=>100,7=>160,8=>160,9=>150]);
            $this->pageUtil->setColsMinWidthArr([3=>150,5=>150,6=>200]);
            $this->pageUtil->setColTemplet(4,"#imgTpl");
            $this->pageUtil->setColTemplet(2,"#statusTpl");
        }else{
            $where  = getWhereParam(['a.title'=>'like','b.position_id'],$this->post);
            $pageData = $this->model::alias('a')
                ->join('pin_site_banner_position b','a.position_id = b.id','left')
                ->field('a.id,a.sort,a.status,b.position_name,a.img,a.title,a.url,a.create_time,a.update_time')
                ->where($where)
                ->order('b.sort asc,a.sort asc,a.create_time desc')
                ->paginate($this->param['limit']?:"");
            $this->page->setData($pageData);
        }

    }



}