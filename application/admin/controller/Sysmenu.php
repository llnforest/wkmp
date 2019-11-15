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
use think\facade\Session;

class Sysmenu extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,SysMenuModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            $this->page->setHeader('ID,排序,图标,菜单名称,菜单状态,菜单类型,按钮类型,日志级别,菜单地址');
            $this->pageUtil->setShowNumbers(false);
            $this->pageUtil->setColsEditArr([1,3,8]);
            $this->pageUtil->setColsMinWidthArr([8=>200]);
            $this->pageUtil->setColsWidthArr([1=>80,2=>70,3=>150,4=>100,5=>100,6=>100,7=>100,9=>240]);
            $this->pageUtil->setColTemplet(4,"#statusTpl");
        }else{


            $this->pageUtil->setDataDictArr([5=>'menuType',6=>'btnType',7=>'logLevel']);
            $where  = getWhereParam(['menu_name'=>'like','menu_type','log_level','btn_type','parent_id'],$this->post);
            $whereOr = isset($this->param['parent_id']) ? ['id'=>$this->param['parent_id']]:[];

            if($this->userSession['id'] != 1) $where[] = ['id','in',Session::get('auth')['menuArr']];

            $pageData = $this->model::field('id,sort,menu_icon,menu_name,status,menu_type,btn_type,log_level,menu_url')
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
        //判断是否存在
        if(!empty($this->model::where(['menu_name'=>$name,'menu_type'=>'M'])->where('parent_id','<>',0)->find())) die('already have this menu');
        //菜单
        $menuData = ['parent_id'=>$parent_id,'menu_url'=>$pre_url.'index','menu_name'=>$name,'menu_type'=>'M','sort'=>$sort.'00','status'=>1];
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
        //批量删除
        $menuData = ['parent_id'=>$parent->id,'menu_url'=>$pre_url.'delBatch','menu_name'=>'批量删除','menu_type'=>'B','sort'=>$sort.'09','btn_css'=>'#FF5722','btn_func'=>'delBatch','btn_type'=>1,'menu_icon'=>"<i class='layui-icon layui-icon-delete'></i>",'status'=>1];
        $this->model::create($menuData);
        //修改字段接口
        $menuData = ['parent_id'=>$parent->id,'menu_url'=>$pre_url.'editField','menu_name'=>'修改字段接口','menu_type'=>'G','sort'=>$sort.'09','status'=>1];
        $this->model::create($menuData);

        echo 'create success';
    }

}