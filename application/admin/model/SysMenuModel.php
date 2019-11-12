<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/3
 * Time: 10:48
 */

namespace app\admin\model;


use think\Model;

class SysMenuModel extends Model
{
    protected $table = 'sys_menu';

    /**
     * 获取菜单树
     * @param int $parent_id
     * @param $data
     */
    public static function getMenuTree($parent_id=0,$menu_type=''){
        $where = ['status'=>1,'parent_id'=>$parent_id];
        if($menu_type) $where['menu_type'] = $menu_type;
        $data = self::where($where)->order('sort asc')->select();
        foreach($data as $item){
            $item['sub'] = self::getMenuTree($item['id'],$menu_type);
        }
        return $data;
    }

    /**
     * 获取菜单树（权限）
     * @param int $parent_id
     * @param $data
     */
    public static function getMenuTreeByAuth($parent_id=0,$menuArr,$menu_type=''){
        $where = [['status','=',1],['parent_id','=',$parent_id],['id','in',$menuArr]];
        if($menu_type) $where[] = ['menu_type','=',$menu_type];
        $data = self::where($where)->select();
        foreach($data as $item){
            $item['sub'] = self::getMenuTreeByAuth($item['id'],$menuArr,$menu_type);
        }
        return $data;
    }

    /**
     * 获取菜单树(是否选中状态)
     * @param int $parent_id
     * @param $data
     */
    public static function getMenuTreeByChecked($parent_id=0,$menuArr){
        $where = ['status'=>1,'parent_id'=>$parent_id];
        $data = self::where($where)->select();
        foreach($data as $item){
            $item['checked'] = in_array($item['id'],$menuArr);
            $item['sub'] = self::getMenuTreeByChecked($item['id'],$menuArr);
        }
        return $data;
    }
}