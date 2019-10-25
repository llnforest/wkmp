<?php
/**
 * 菜单管理控制器
 * User: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\MenuModel;
use think\App;
use think\facade\Cache;

class Menu extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,MenuModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        $this->pageUtil->setShowNumbers(false);
        $this->pageUtil->setDataDictArr([4=>'menuType',5=>'btnType',6=>'logLevel',8=>'status']);
        $this->pageUtil->setColEdit(1);
        $this->pageUtil->setColsMinWidthArr([1=>80,2=>60,3=>120,4=>95,5=>95,6=>95,7=>180,8=>70]);
        $this->pageUtil->setColsWidthArr([9=>240]);


    }

    //显示分页列表页面
    public function pageData(){
        if($this->request->isGet()){
            $this->page->setHeader('ID,排序,图标,菜单名称,菜单类型,按钮类型,日志级别,菜单地址,状态');
        }else{
            $where  = getWhereParam(['menu_name'=>'like','menu_type','log_level','btn_type','parent_id'],$this->param);
            $whereOr = isset($this->param['parent_id']) ? ['id'=>$this->param['parent_id']]:[];
            $pageData = $this->model::field('id,sort,menu_icon,menu_name,menu_type,btn_type,log_level,menu_url,status')
                ->where($where)
                ->whereOr($whereOr)
                ->order('sort asc')
                ->paginate($this->param['limit']?:"");
            return $pageData;
        }

    }

    /**
     * 获取菜单树
     * @return Json
     */
    public function treeData(){
        $this->data = $this->model::getMenuTree(0);
        return json(sucRes($this->data));
    }

    //添加前操作
    public function beforeAdd(){
        if($this->request->isGet()){
            $this->data['info']['parent_id'] = isset($this->param['parent_id'])?$this->param['parent_id']:0;
        }
    }

    //删除前判断
    function beforeDel($data){
        if($this->request->isPost()){
            $dict = $this->model::where(['parent_id'=>$this->id])->find();
            if(!empty($dict)){
                $result = operateResult(false,'del');
                $result['msg'] .= '：该菜单下存在子菜单，请先删除！';
                die(json_encode($result,JSON_UNESCAPED_UNICODE));
            };
        }
    }

}