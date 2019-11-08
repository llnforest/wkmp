<?php
/**
 * 用户管理控制器
 * User: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\ConfigModel;
use app\admin\model\UserModel;
use app\admin\model\UserRoleModel;
use think\App;

class User extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,UserModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            $this->data['id'] = 1;
            $this->page->setHeader('ID,用户名称,登录账号,状态,所属角色,手机号码,电子邮箱,最近登录IP,最近登录时间,注册时间');
            $this->pageUtil->setColsMinWidthArr([1=>120,2=>120,4=>120]);
            $this->pageUtil->setColsWidthArr([3=>95,5=>100,6=>120,7=>120,8=>140,9=>140,10=>240]);
            $this->pageUtil->setColTemplet(3,"#statusTpl");
        }else{
            $where  = getWhereParam(['a.nickname'=>'like','a.name'=>'like','a.phone','a.status'],$this->param);
            $pageData = $this->model::alias('a')
                ->where($where)
                ->field('a.id,a.nickname,a.name,a.status,"" as role_name,a.phone,a.email,a.last_login_ip,a.last_login_time,a.create_time')
                ->order('a.create_time desc')
                ->paginate($this->param['limit']?:"")
                ->each(function($item,$key){
                    $nameArr = UserRoleModel::alias('a')
                        ->join('sys_role b','a.role_id = b.id','left')
                        ->where('a.user_id',$item->id)
                        ->column('b.name');
                    if(!empty($nameArr)) $item->role_name = implode(',',$nameArr);
                });
            $this->page->setData($pageData);
        }
    }

    //重置密码
    public function resetPassword(){
        if($this->request->isPost()){
            if(!isset($this->param['id']) || empty($info = $this->model::get($this->id))) return paramRes();
            $this->param['password'] = md5(md5(ConfigModel::getValue('resertPassword')));
            return operateResult($info->save($this->param),'reset_password');
        }
    }


    //公用操作方法
    public function commonOperate(){
        if($this->request->isGet()){
            if(isset($this->param['status']) && empty($this->param['status'])) $this->param['status'] = 0;
        }else{
            $this->addUserRole($this->id);
        }
    }

    //添加前判断
    function beforeAdd(){
        if($this->request->isPost()){
            $this->param['password'] = md5(md5($this->param['password']));
            $user = $this->model::where(['name'=>$this->param['name']])->find();
            if(!empty($user)){
                $result = operateResult(false);
                $result['msg'] .= '：该用户名已存在';
                die(json_encode($result,JSON_UNESCAPED_UNICODE));
            };
        }
    }

    //添加前判断
    function beforeEdit($data){
        if($this->request->isPost() && isset($this->param['name'])){
            $user = $this->model::where([['id','neq',$this->id]])->where(['name'=>$this->param['name']])->find();
            if(!empty($user)){
                $result = operateResult(false,'edit');
                $result['msg'] .= '：该用户名已存在';
                die(json_encode($result,JSON_UNESCAPED_UNICODE));
            };
        }
    }

    //删除前判断
    function beforeDel($data){
        if($this->request->isPost()){
            UserRoleModel::where(['user_id' => $this->param['id']])->delete();
        }
    }

    /**
     * 添加接口和页面
     */
    public function add(){
        if(method_exists($this,"commonOperate")) $this->commonOperate();
        if($this->request->isPost()){
            if(method_exists($this,"beforeAdd")) $this->beforeAdd();
            $user = $this->model::create($this->param);
            if($user) $this->addUserRole($user->id);
            return operateResult($user,'add');
        }else{
            if(method_exists($this,"beforeAdd")) $this->beforeAdd();
            return view('detail',$this->data);
        }
    }

    //添加到user_role 表中纪录
    private function addUserRole($user_id){
        if($user_id) UserRoleModel::where(['user_id'=>$user_id])->delete(); //删除

        if(!empty($this->param['roleIds']) && $user_id){ //新增
            $roleArr = explode(',',$this->param['roleIds']);
            $roleList = [];
            foreach($roleArr as $v){
                $roleList[] = ['user_id'=>$user_id,'role_id'=>$v];
            }
            $userRole = new UserRoleModel();
            $userRole->saveAll($roleList);
        }
    }
}