<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

if(!function_exists('sucRes')){
    /**
     * 操作成功
     * @param array $data 数据
     * @param string $msg 提示
     * @return array
     */
    function sucRes($data = [],$msg = 'success'){
        return ['code' => lang('success_code'),'msg' => $msg,'data' => $data];
    }
}

if(!function_exists('errRes')){
    /**
     * 操作失败
     * @param array $data 数据
     * @param string $msg 提示
     * @return array
     */
    function errRes($data = [],$msg = 'error'){
        return ['code' => lang('error_code'),'msg' => $msg,'data' => $data];
    }
}

if(!function_exists('paramRes')){
    /**
     * 参数异常
     * @param string $msg 提示
     * @return array
     */
    function paramRes($msg = 'param'){
        return ['code' => lang('error_code'),'msg' => lang('sys_'.$msg.'_error')];
    }
}

if(!function_exists('operateResult')){
    /**
     * 操作结果
     * @param boolean $default
     * @param string $operate
     * @param string $url
     * @return array
     */
    function operateResult($default,$operate = 'add',$url = null){
        if ($default) {
            if($url) return ['code' => lang('success_code'), 'msg' => lang('sys_'.$operate.'_success'), 'url' => url($url)];
            return ['code' => lang('success_code'), 'msg' => lang('sys_'.$operate.'_success')];
        } else {
            return ['code' => lang('error_code'), 'msg' => lang('sys_'.$operate.'_error')];
        }
    }
}

if(!function_exists('inputResult')){
    /**
     * 输入框输入结果
     * @param boolean $default
     * @param string $operate
     * @return array
     */
    function inputResult($default,$operate = 'sort'){
        if ($default) {
            return ['code' => lang('success_code'), 'msg' => lang('sys_'.$operate.'_success')];
        } else {
            return ['code' => lang('error_code'), 'msg' => lang('sys_'.$operate.'_error'),'text'=>$default[$operate]];
        }
    }
}

if(!function_exists('switchResult')){
    /**
     * switch操作结果
     * @param boolean $default
     * @param string $operate
     * @return array
     */
    function switchResult($default,$operate = 'status'){
        if ($default) {
            return ['code' => lang('success_code'), 'msg' => lang('sys_'.$operate.'_success')];
        } else {
            return ['code' => lang('error_code'), 'msg' => lang('sys_'.$operate.'_error')];
        }
    }
}

if(!function_exists('getYearNum')){
    /**
     * 获取使用年数
     * @param $start_date 2017-12-23 00:00:00
     * @return string 2017-12-23
     */
    function getYearNum($start_date){
        if(!$start_date) return '';
        $end_date = date('Y-m-d',time());
        $startArr = explode('-',$start_date);
        $endArr = explode('-',$end_date);
        if($endArr[2] - $startArr[2] <= 0) $startArr[1] ++;
        if($endArr[1] - $startArr[1] <= 0) $endArr[0] ++;
        $year = $endArr[0] - $startArr[0];
        return $year;
    }
}

if(!function_exists('excelTime')){
    /**
     * 转换excel时间
     * @param $date 2017/03/09
     * @return string 2017-03-09
     */
    function excelTime($date) {
        if (function_exists('GregorianToJD')) {
            if (is_numeric($date)) {
                $jd = GregorianToJD(1, 1, 1970);
                $gregorian = JDToGregorian($jd + intval($date) - 25569);
                $date = explode('/', $gregorian);
                $date_str = str_pad($date[2], 4, '0', STR_PAD_LEFT) . "-" . str_pad($date[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($date[1], 2, '0', STR_PAD_LEFT);
                return $date_str;
            }
        } else {
            $date = $date > 25568 ? $date + 1 : 25569; /*There was a bug if Converting date before 1-1-1970 (tstamp 0)*/
            $ofs = (70 * 365 + 17 + 2) * 86400;
            $date = date("Y-m-d", ($date * 86400) - $ofs);
        }
        return $date;
    }
}

if(!function_exists('getWhereParam')){
    /**
     * 搜索时的条件
     * @param $search
     * @param $param
     * @param int $type
     * @return array
     */
    function getWhereParam($search,$param){
        $where = [];
        foreach($search as $k => $v){
            if(is_numeric($k)){
                $true_name = getTrueName($v);
                if(!isset($param[$true_name]) || $param[$true_name] === '') continue;
                $where[] = [$v,'=',$param[$true_name]];
            }else{
                if(is_array($v)){//是数组：比较两者之间的大小
                    $start = getTrueName($v[0]);
                    $end = getTrueName($v[1]);
                    $is_time = strpos($k,'time');//判断是否是带有分秒的时间
                    if(!empty($param[$start])){
                        if(!empty($param[$end])){
                            if($is_time !== false) $end = date('Y-m-d H:i:s',strtotime($param[$end])+(24*3600)-1);
                            else $end = $param['end'];
                            $where[]  = [$k,'between time',array($param[$start],$end)];
                        }else{
                            $where[]  = [$k,'>=',$param[$start]];
                        }
                    }else{
                        if(!empty($param[$end])){
                            if($is_time !== false) $end = date('Y-m-d H:i:s',strtotime($param[$end])+(24*3600)-1);
                            $where[$k]  = [$k,'<=',$end];
                        }
                    }
                }else{//字符串
                    $true_name = getTrueName($k);
                    if(!isset($param[$true_name]) || $param[$true_name] === '') continue;
                    if(in_array($v,['like','NOT LIKE'])) $where[] = [$k,$v,"%{$param[$true_name]}%"];
                    elseif(in_array($v,['in','not in'])) $where[] = [$k,$v,$param[$true_name]];
                }
            }
        }
        return $where;
    }
}

if(!function_exists('getTrueName')){
    /**
     * 取实际字段名称
     * @param $name
     * @return mixed
     */
    function getTrueName($name){
        if(strpos($name,'.') !== false){
            $name = explode('.',$name)[1];
        }
        return $name;
    }
}


?>