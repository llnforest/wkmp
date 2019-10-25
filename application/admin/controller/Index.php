<?php
namespace app\admin\controller;

use app\admin\model\LogModel;
use app\admin\model\MenuModel;
use app\admin\model\UserConfigModel;
use app\admin\model\UserModel;
use app\admin\model\UserRoleModel;
use common\auth\AuthUtil;
use think\facade\Cache;
use \think\facade\Session;

class Index extends AuthController
{

    //首页
    public function admin(){
        return view("/index");
    }


    //设置主题
    public function setSkin(){
        $userConfig = UserConfigModel::get(['user_id' => Session::get('userInfo.id')]);
        if(empty($userConfig)){
            $result = UserConfigModel::create($this->param);
        }else{
            $result = $userConfig->save($this->param);
        }
        return json(sucRes($result));
    }
    //修改密码
    public function changePassword(){
        $userResult = UserModel::get(Session::get('userInfo.id'));
        $result = false;
        if(!empty($userResult)){
            $result = $userResult->save(['password'=>$this->param['password']]);
        }
        return json(sucRes($result));
    }

    //个人信息
    public function selfInfo(){
        $this->data['info'] = UserModel::get(Session::get('userInfo.id'));
        $roleArr = UserRoleModel::alias('a')
                ->join('sys_role b','a.role_id = b.id','left')
                ->where(['a.user_id' => Session::get('userInfo.id')])
                ->column('b.name');
        if(!empty($roleArr)) $roleArr = implode(',',$roleArr);
        $this->data['info']['role_name'] = $roleArr;
        return view('selfInfo',$this->data);
    }

    //获取顶部菜单
    public function topMenu(){
        $auth = Session::get('auth');
        if(in_array(1,$auth['roleArr'])){
            $this->data = MenuModel::getMenuTree(0,'M');
        }else{
            $this->data = MenuModel::getMenuTreeByAuth(0,$auth['menuArr'],'M');
        }
        return json(sucRes($this->data));
    }

    //控制台
    public function console(){
        $loginList = LogModel::where(['user_id'=>Session::get('userInfo.id'),'operate_name'=>'登录'])->order('create_time desc')->limit(2)->select();
        $this->data['now_login'] = $loginList[0]['create_time'];
        if(count($loginList) == 2){
            $this->data['last_login'] = $loginList[1]['create_time'];
            $this->data['last_logout'] = LogModel::where([['user_id','=',Session::get('userInfo.id')],['operate_name','=','退出'],['create_time','>=',$this->data['last_login']]])->value('create_time');
        }
        return view('console',$this->data);
    }

    //退出
    public function logout(){
        LogModel::create(['user_id'=>Session::get('userInfo.id'),'nickname'=>Session::get('userInfo.nickname'),'operate_menu'=>'系统注销','operate_name'=>'注销','ip'=>$this->request->ip(),'url'=>$this->request->path()]);
        Session::clear();
        return view('/login');
    }

    //登录
    public function login(){
        if($this->request->isGet()){
            if(empty(Session::get('userInfo'))){
                return view('/login');
            }else{
                return view('/index');
            }
        }else{
            $userInfo = UserModel::where(['name'=>$this->param['name'],'password'=>md5(md5($this->param['password'])),'status'=>1])->find();
            if(!empty($userInfo)){
                Session::set('userInfo',$userInfo);
                LogModel::create(['user_id'=>$userInfo['id'],'nickname'=>$userInfo['nickname'],'operate_menu'=>'系统登录','operate_name'=>'登录','ip'=>$this->request->ip(),'url'=>$this->request->path()]);
                Session::set('auth',AuthUtil::getAuth($userInfo['id']));
                return sucRes();
            }else{
                return errRes();
            }
        }
    }



}
