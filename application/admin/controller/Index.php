<?php
namespace app\admin\controller;

use app\admin\model\SysLogModel;
use app\admin\model\SysMenuModel;
use app\admin\model\SysUserConfigModel;
use app\admin\model\SysUserModel;
use app\admin\model\SysUserRoleModel;
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
        $userConfig = SysUserConfigModel::get(['user_id' => Session::get('userInfo.id')]);
        if(empty($userConfig)){
            $result = SysUserConfigModel::create($this->param);
        }else{
            $result = $userConfig->save($this->param);
        }
        return json(sucRes($result));
    }
    //修改密码
    public function changePassword(){
        $userResult = SysUserModel::get(Session::get('userInfo.id'));
        $result = false;
        if(!empty($userResult)){
            $result = $userResult->save(['password'=>$this->param['password']]);
        }
        return json(sucRes($result));
    }

    //个人信息
    public function selfInfo(){
        $this->data['info'] = SysUserModel::get(Session::get('userInfo.id'));
        $roleArr = SysUserRoleModel::alias('a')
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
            $this->data = SysMenuModel::getMenuTree(0,'M');
        }else{
            $this->data = SysMenuModel::getMenuTreeByAuth(0,$auth['menuArr'],'M');
        }
        return json(sucRes($this->data));
    }

    //控制台
    public function console(){
        $loginList = SysLogModel::where(['user_id'=>Session::get('userInfo.id'),'operate_name'=>'登录'])->order('create_time desc')->limit(2)->select();
        $this->data['now_login'] = $loginList[0]['create_time'];
        if(count($loginList) == 2){
            $this->data['last_login'] = $loginList[1]['create_time'];
            $this->data['last_logout'] = SysLogModel::where([['user_id','=',Session::get('userInfo.id')],['operate_name','=','退出'],['create_time','>=',$this->data['last_login']]])->value('create_time');
        }
        return view('console',$this->data);
    }

    //退出
    public function logout(){
        SysLogModel::create(['user_id'=>Session::get('userInfo.id'),'nickname'=>Session::get('userInfo.nickname'),'operate_menu'=>'系统注销','operate_name'=>'注销','ip'=>$this->request->ip(),'url'=>$this->request->path()]);
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
            $userInfo = SysUserModel::where(['name'=>$this->param['name'],'password'=>md5(md5($this->param['password'])),'status'=>1])->find();
            if(!empty($userInfo)){
                Session::set('userInfo',$userInfo->toArray());
                SysLogModel::create(['user_id'=>$userInfo['id'],'nickname'=>$userInfo['nickname'],'operate_menu'=>'系统登录','operate_name'=>'登录','ip'=>$this->request->ip(),'url'=>$this->request->path()]);
                Session::set('auth',AuthUtil::getAuth($userInfo['id']));
                $userInfo->last_login_time = date('Y-m-d H:i:s',time());
                $userInfo->last_login_ip = $this->request->ip();
                $userInfo->save();
                return sucRes();
            }else{
                return errRes();
            }
        }
    }



}
