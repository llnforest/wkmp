<?php
/**
 * 日志管理控制器
 * User: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\LogModel;
use chromephp\chromephp;
use think\App;

class Log extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,LogModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            $this->page->setHeader('ID,ID,用户名称,操作菜单,操作名称,IP地址,访问URL,日志备注,操作时间');
            $this->pageUtil->setColsMinWidthArr([6=>200,7=>250]);
            $this->pageUtil->setColsWidthArr([1=>70,2=>130,3=>130,4=>140,5=>145,8=>170]);
            $this->pageUtil->setShowNumbers(false);
            $this->pageUtil->setToolBar(false);
        }else{
            $where  = getWhereParam(['nickname'=>'like','operate_menu'=>'like','operate_name'=>'like','log'=>'like','create_time'=>['start','end']],$this->param);
            $pageData = $this->model::field('id as id_num,id,nickname,operate_menu,operate_name,ip,url,log,create_time')
            ->where($where)
            ->order('create_time asc')
            ->paginate($this->param['limit']?:"");
            $this->page->setData($pageData);
        }
    }


}