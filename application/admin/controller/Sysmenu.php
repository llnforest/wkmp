<?php
/**
 * 菜单管理控制器
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\SysMenuModel;
use think\App;
use think\facade\Cache;

class Sysmenu extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,SysMenuModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            $this->page->setHeader('ID,排序,图标,菜单名称,菜单类型,按钮类型,日志级别,菜单地址,状态');
            $this->pageUtil->setShowNumbers(false);
            $this->pageUtil->setColEdit(1);
            $this->pageUtil->setColsMinWidthArr([1=>80,2=>70,3=>120,4=>95,5=>95,6=>95,7=>180,8=>70]);
            $this->pageUtil->setColsWidthArr([9=>240]);
        }else{
            $this->pageUtil->setDataDictArr([4=>'menuType',5=>'btnType',6=>'logLevel',8=>'status']);
            $where  = getWhereParam(['menu_name'=>'like','menu_type','log_level','btn_type','parent_id'],$this->param);
            $whereOr = isset($this->param['parent_id']) ? ['id'=>$this->param['parent_id']]:[];
            $pageData = $this->model::field('id,sort,menu_icon,menu_name,menu_type,btn_type,log_level,menu_url,status')
                ->where($where)
                ->whereOr($whereOr)
                ->order('sort asc,id asc')
                ->paginate($this->param['limit']?:"");
            $this->page->setData($pageData);
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

    //添加修改前操作
    public function commonOperate(){
        if($this->request->isPost()){
            if(isset($this->param['menu_type']) && $this->param['menu_type'] != 'B') $this->param['btn_type'] = '';
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

    //自动创建菜单
    function createMenu(){
        $controller_name = $this->param['controller'];
        $name = $this->param['name'];
        $sort = $this->param['sort'];
        $parent_id = $this->param['parent_id'];
        $pre_url = 'admin/'.$controller_name.'/';
        //菜单
        $menuData = ['parent_id'=>$parent_id,'menu_url'=>$pre_url.'index','menu_name'=>$name,'menu_type'=>'M','sort'=>$sort.'00','btn_type'=>1,'status'=>1];
        if(!empty($this->model::where($menuData)->find())) die('already have this menu');
        $parent = $this->model::create($menuData);
        //新增
        $menuData = ['parent_id'=>$parent->id,'menu_url'=>$pre_url.'add','menu_name'=>'新增','menu_type'=>'B','sort'=>$sort.'09','btn_func'=>'add','btn_type'=>1,'menu_icon'=>"<i class='layui-icon layui-icon-add-circle-fine'></i>",'status'=>1];
        $this->model::create($menuData);
        //编辑
        $menuData = ['parent_id'=>$parent->id,'menu_url'=>$pre_url.'edit','menu_name'=>'编辑','menu_type'=>'B','sort'=>$sort.'02','btn_func'=>'edit','btn_type'=>2,'menu_icon'=>"<i class='layui-icon layui-icon-edit'></i>",'status'=>1];
        $this->model::create($menuData);
        //删除
        $menuData = ['parent_id'=>$parent->id,'menu_url'=>$pre_url.'del','menu_name'=>'删除','menu_type'=>'B','sort'=>$sort.'01','btn_css'=>'#FF5722','btn_func'=>'del','btn_type'=>2,'menu_icon'=>"<i class='layui-icon layui-icon-delete'></i>",'status'=>1];
        $this->model::create($menuData);
        echo 'create success';
    }

}