<?php
/**
 * 字典参数管理控制器
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\SysDictValueModel;
use common\dict\DictUtil;
use think\App;

class Sysdictvalue extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,SysDictValueModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            $this->data['id'] = 1;
            $this->page->setHeader('ID,排序,字典名称,参数名称,参数编码,字体颜色,备注说明');
            $this->pageUtil->setShowCheckbox(true);
            $this->pageUtil->setColsMinWidthArr([2=>120,3=>120,4=>90,5=>90]);
            $this->pageUtil->setColsWidthArr([1=>100,7=>150]);
            $this->pageUtil->setColEdit(1);
        }else{
            $where  = getWhereParam(['a.dict_name'=>'like','a.dict_id'],$this->param);
            $pageData = $this->model::alias('a')
                ->join('sys_dict b','a.dict_id = b.id','left')
                ->where($where)
                ->field('a.id,a.sort,b.dict_name,a.val_name,a.val_code,a.val_color,a.remark')
                ->order('b.sort asc,a.sort asc')
                ->paginate($this->param['limit']?:"")
                ->each(function($item,$key){
                    if(!empty($item->val_color)) $item->val_color = '<span style="color:'.$item->val_color.'">'.$item->val_name.'</span>';
                });
            $this->page->setData($pageData);
        }
    }

    //公用操作方法
    function commonOperate(){
        if($this->request->isPost()){
            DictUtil::clearDict();
        }
    }

    //详情公用方法
    public function beforeAdd(){
        if($this->request->isGet()){
            if(!empty($this->param['dict_id'])) $this->data['info']['dict_id'] = $this->param['dict_id'];
        }
    }

}