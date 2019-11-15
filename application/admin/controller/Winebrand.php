<?php
/**
 * 菜单管理控制器
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\WineBrandModel;
use app\admin\model\WineModel;
use think\App;

class Winebrand extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,WineBrandModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            $this->page->setHeader('ID,排序,品牌图片,品牌名称,状态,创建时间');
            $this->pageUtil->setColEdit(1);
            $this->pageUtil->setColsWidthArr([1=>100,2=>100,4=>150,5=>160,6=>150]);
            $this->pageUtil->setColsMinWidthArr([3=>200]);
            $this->pageUtil->setColTemplet(4,"#statusTpl");
            $this->pageUtil->setColTemplet(2,"#imgTpl");
        }else{
            $where  = getWhereParam(['brand_name'=>'like'],$this->post);
            $pageData = $this->model::field('id,sort,img,brand_name,status,create_time')
                ->where($where)
                ->order('sort asc,create_time desc')
                ->paginate($this->param['limit']?:"");
            $this->page->setData($pageData);
        }

    }

    //删除前判断
    function beforeDel($data){
        if($this->request->isPost()){
            $dict = WineModel::where(['brand_id'=>$this->id])->find();
            if(!empty($dict)){
                $result = operateResult(false,'del');
                $result['msg'] .= '：该品牌已被酒品绑定，请先解绑！';
                die(json_encode($result,JSON_UNESCAPED_UNICODE));
            };
        }
    }

}