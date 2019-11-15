<?php
/**
 * 菜单管理控制器
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\SiteBannerModel;
use app\admin\model\SiteBannerPositionModel;
use think\App;

class Sitebannerposition extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,SiteBannerPositionModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            $this->page->setHeader('ID,排序,广告位名称,备注说明,创建时间,最后操作时间');
            $this->pageUtil->setColEdit(1);
            $this->pageUtil->setColsWidthArr([1=>100,4=>180,5=>160,6=>150]);
            $this->pageUtil->setColsMinWidthArr([2=>200,3=>300]);
        }else{
            $where  = getWhereParam(['position_name'=>'like'],$this->post);
            $pageData = $this->model::field('id,sort,position_name,remark,create_time,update_time')
                ->where($where)
                ->order('sort asc')
                ->paginate($this->param['limit']?:"");
            $this->page->setData($pageData);
        }

    }

    //删除前判断
    function beforeDel($data){
        if($this->request->isPost()){
            $dict = SiteBannerModel::where(['position_id'=>$this->id])->find();
            if(!empty($dict)){
                $result = operateResult(false,'del');
                $result['msg'] .= '：该广告位已被广告绑定，请先解绑！';
                die(json_encode($result,JSON_UNESCAPED_UNICODE));
            };
        }
    }


}