<?php
/**
 * 菜单管理控制器
 * User: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\MenuModel;
use app\admin\model\RoleMenuModel;
use app\admin\model\RoleModel;
use app\admin\model\UserRoleModel;
use think\App;

class Role extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,RoleModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        $this->pageUtil->setToolbarId("listBarTool");
        $this->pageUtil->setDataDictArr([3=>'status']);
        $this->pageUtil->setColEdit(1);
        $this->pageUtil->setColsWidthArr([1=>100,3=>95,5=>210]);
        $this->pageUtil->setColsMinWidthArr([2=>160]);


    }

    //显示分页列表页面
    public function pageData(){
        if($this->request->isGet()){
            $this->page->setHeader('ID,排序,角色名称,角色状态,备注说明');
        }else{
            $where  = getWhereParam(['name'=>'like'],$this->param);
            $pageData = $this->model::field('id,sort,name,status,remark')
                ->where($where)
                ->order('sort asc')
                ->paginate($this->param['limit']?:"");
            return $pageData;
        }

    }

    //添加前操作
    public function beforeAdd(){
        if($this->request->isPost()) {
            $role = $this->model::where(['name' => $this->param['name']])->find();
            if (!empty($role)) {
                $result = operateResult(false);
                $result['msg'] .= '：该角色名称已存在';
                die(json_encode($result, JSON_UNESCAPED_UNICODE));
            };
        }
    }

    //修改前判断
    function beforeEdit($data){
        if($this->request->isPost()){
            if($this->id == 1){
                $result = operateResult(false,'edit');
                $result['msg'] .= '：超管不能编辑';
                die(json_encode($result,JSON_UNESCAPED_UNICODE));
            }
            if(isset($this->param['name'])){
                $role = $this->model::where([['id','neq',$this->id]])->where(['name'=>$this->param['name']])->find();
                if(!empty($role)){
                    $result = operateResult(false,'edit');
                    $result['msg'] .= '：该角色名称已存在';
                    die(json_encode($result,JSON_UNESCAPED_UNICODE));
                };
            }
        }
    }

    //删除前判断
    function beforeDel($data){
        if($this->request->isPost()){
            $dict = UserRoleModel::where(['role_id'=>$this->id])->find();
            if(!empty($dict)){
                $result = operateResult(false,'del');
                $result['msg'] .= '：该角色已被用户绑定，请先解绑！';
                die(json_encode($result,JSON_UNESCAPED_UNICODE));
            };
        }
    }

    //权限操作和页面
    function auth(){
        if($this->request->isPost()){
            RoleMenuModel::where(['role_id'=>$this->id])->delete();
            if(!empty($this->param['new_menus'])){
                $new_menus = explode(',',$this->param['new_menus']);
                $role_menu = [];
                foreach($new_menus as $v){
                    $role_menu[] = ['role_id' => $this->id,'menu_id' => $v];
                }
                $roleMenu = new RoleMenuModel();
                $roleMenu->saveAll($role_menu);
            }
            return operateResult(true,'do');
        }else{
            $this->data['info'] = RoleModel::get($this->id);
            return view('auth',$this->data);
        }
    }

    //获取表单树
    function getAuth(){
        $menu_arr = RoleMenuModel::where(['role_id'=>$this->id])->column('menu_id');
        $menuList = MenuModel::getMenuTreeByChecked(0,$menu_arr);
        return sucRes($menuList);
    }

    //角色列表根据用户id显示选中
    function getRoleListByUser(){
        $roleList = $this->model::field('id,name')->where(['status'=>1])->select();
        if(!empty($this->param['user_id'])){
            $roleArr = UserRoleModel::where(['user_id'=>$this->param['user_id']])->column('role_id');
            foreach($roleList as &$v){
                if(in_array($v['id'],$roleArr)) $v['selected'] = 1;
            }
        }
        return sucRes($roleList);
    }

}