<?php
/**
 * User: Lynn
 * Date: 2019/4/9
 * Time: 10:27
 */

namespace common\auth;


use app\admin\model\LogModel;
use app\admin\model\MenuModel;
use app\admin\model\RoleMenuModel;
use app\admin\model\RoleModel;
use app\admin\model\UserRoleModel;
use chromephp\chromephp;

class AuthUtil
{
    /**
     *  获取菜单的子按钮、tab等菜单
     */
    /**
     * 获取菜单的子按钮、tab等菜单
     * @param $auth 权限信息 ['roleArr','menuArr']
     * @param $url
     * @param string $menu_type
     * @param null $btn_type
     * @return string (json)
     */
    public static function getAuthChildMenu($auth,$url,$menu_type = 'B',$btn_type = null){
        if($menu_type == 'T'){
            $parent_id = MenuModel::where(['menu_url'=>$url,'menu_type'=>'T'])->value('parent_id');
        }else{
            $parent_id = MenuModel::where(['menu_url'=>$url,'menu_type'=>'T'])->value('id');
            if(empty($parent_id)) $parent_id = MenuModel::where(['menu_url'=>$url,'menu_type'=>'M'])->value('id');
        }
        $where = ['parent_id'=>$parent_id,'menu_type'=>$menu_type,'status'=>1];
        if($btn_type) $where['btn_type'] = $btn_type;
        $btnList = MenuModel::where($where)->order('sort asc')->select();
        //判断权限
        foreach($btnList as $k=>$v){
            if(!self::checkAuth($v,$auth)) unset($btnList[$k]);
        }
        return json_encode($btnList);
    }

    /**
     * 获取权限url和名称
     * @param $url
     * @return array|boolean
     */
    public static function getUrlAuth($auth,$url,$userInfo,$request){
        $menu = MenuModel::where(['menu_url'=>$url])->find();
        if(self::checkAuth($menu,$auth,$userInfo,$request)) return ['name'=>$menu['menu_name'],'url'=>$url];
        else return false;
    }

    /**
     * 获取用户权限
     * @param $user_id
     * @return array
     */
    public static function getAuth($user_id){
        $menuArr = [];
        $roleArr = UserRoleModel::alias('a')
            ->join('sys_role b','a.role_id = b.id','left')
            ->where(['a.user_id'=>$user_id,'b.status'=>1])
            ->column('a.role_id');
        $roleArr &&  $menuArr = RoleMenuModel::where('role_id','in',$roleArr)->column('menu_id');
        return ['roleArr'=>$roleArr,'menuArr'=>$menuArr];
    }

    /**
     * 检查权限
     * @param $menuInfo 菜单信息
     * @param $auth 权限信息 ['roleArr','menuArr']
     * @param string $userInfo  个人信息
     * @param string $request 请求信息
     * @return bool
     */
    private static function checkAuth($menuInfo,$auth,$userInfo = '',$request = ''){
        if(empty($menuInfo)) return true;
        if(in_array($menuInfo['id'],$auth['menuArr']) || in_array(1,$auth['roleArr'])){//有权限
            if($request && $userInfo && $menuInfo['log_level']){//纪录到日志中
                $parentMenuName = MenuModel::where(['id'=>$menuInfo['parent_id']])->value('menu_name');
                $logData = ['user_id'=>$userInfo['id'],'nickname'=>$userInfo['nickname'],'operate_menu'=>$parentMenuName,'operate_name'=>$menuInfo['menu_name'],'ip'=>$request->ip(),'url'=>$request->path()];
                if($request->isPost()){
                    $param = $request->param();
                    $command = preg_replace('/\{(\w*?)\}/', '{$param[\'\\1\']}', $menuInfo['log_rule']);
                    @(eval( '$logData[\'log\'] ="'.$command.'";' ));
//                    @(eval('$condition=("' . $command . '");'));;
                }
                LogModel::create($logData);
            }

            return true;
        }else{//无权限
            return false;
        }
    }

}