<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/8
 * Time: 12:01
 */

namespace common\dict;


use app\admin\model\SysDictModel;
use \think\facade\Cache;

class DictUtil
{
    protected static $dictCache = 1;

    /**
     * 如果dictCode没有记录到缓存中，则去数据库中加载并将dictCode记录到缓存表中
     * 不管是否加载到，只要记录到缓存表中，则直接从缓存中获取编码，获取不到则返回空
     */
    public static function loadDict($dictCode){
        $dictList = SysDictModel::alias('a')
                ->join('sys_dict_value b','a.id = b.dict_id','left')
                ->where(['a.dict_code'=>$dictCode])
                ->order('b.sort asc')
                ->field('a.dict_code,b.val_code,b.val_name')
                ->select();
        if(count($dictList) > 0){
            foreach($dictList as $v){
                Cache::tag('sysdict')->set($v['dict_code'].'-'.$v['val_code'],$v['val_name']);
            }
        }
        Cache::tag('sysdict')->set($dictCode,true);
        Cache::tag('sysdict')->set($dictCode.'-value',$dictList);
    }

    /**
     * 如果dictCode没有记录到缓存中，则去数据库中加载并将dictCode记录到缓存表中(附加颜色)
     * 不管是否加载到，只要记录到缓存表中，则直接从缓存中获取编码，获取不到则返回空
     */
    public static function loadDictColor($dictCode){
        $dictList = SysDictModel::alias('a')
            ->join('sys_dict_value b','a.id = b.dict_id','left')
            ->where(['a.dict_code'=>$dictCode])
            ->select();
        if(count($dictList) > 0){
            foreach($dictList as $v){
                if($v['val_color']){
                    Cache::tag('dictColor')->set($v['dict_code'].'-'.$v['val_code'],'<span style="color:'.$v['val_color'].'">'.$v['val_name'].'</span>');
                }else{
                    Cache::tag('dictColor')->set($v['dict_code'].'-'.$v['val_code'],$v['val_name']);
                }
            }
        }
        Cache::tag('dictColor')->set($dictCode.'-color',true);
    }

    /**
     * 该方法是根据传入的字典编码和字典值获取当前字典值对应的字典名称
     * @param $dictCode
     * @param $valCode
     * @return String
     */
    public static function getDictName($dictCode,$valCode){
        if(empty(Cache::tag('sysdict')->get($dictCode))){
            self::loadDict($dictCode);
        }
        $dictName = Cache::tag('sysdict')->get($dictCode.'-'.$valCode);
        if(!empty($dictName)) return $dictName;
        else return $valCode;
    }

    /**
     * 该方法是根据传入的字典编码和字典值获取当前字典值对应的字典名称(附加名称颜色)
     * @param $dictCode
     * @param $valCode
     * @return String
     */
    public static function getDictNameColor($dictCode,$valCode){
        if(empty(Cache::tag('dictColor')->get($dictCode.'-color'))){
            self::loadDictColor($dictCode);
        }
        $dictName = Cache::tag('dictColor')->get($dictCode.'-'.$valCode);
        if(!empty($dictName)) return $dictName;
        else return $valCode;
    }

    //获取字典编码对应的参数值
    public static function getDictValue($dictCode){
        if(empty(Cache::tag('sysdict')->get($dictCode))){
            self::loadDict($dictCode);
        }
        $valueList = Cache::tag('sysdict')->get($dictCode.'-value');
        return $valueList;
    }

    /**
     * 清除字典缓存
     */
    public static function clearDict(){
        Cache::clear('sysdict');
        Cache::clear('dictColor');
    }

}