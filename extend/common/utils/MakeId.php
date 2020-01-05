<?php
namespace common\utils;


class MakeId{
    //创建订单id
    private static function makeDefaultId($date = ''){
        //订购日期
        $order_date = date('Ymd');
        if(!empty($date)){
            $order_date = $date;
        }
        //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）
        $order_id_main = time(). rand(1000,9999);
        //订单号码主体长度
        $order_id_len = strlen($order_id_main);
        $order_id_sum = 0;
        for($i=0; $i<$order_id_len; $i++){
            $order_id_sum += (int)(substr($order_id_main,$i,1));
        }
        //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）str_shuffle

        $order_id = str_pad((100 - $order_id_sum % 100) % 100,2,'0',STR_PAD_LEFT).str_shuffle($order_id_main) ;

        $order_id = trim(strval($order_id));  
        if (preg_match('#^-?\d+?\.0+$#', $order_id)) {  
            return preg_replace('#^(-?\d+?)\.0+$#','$1',$order_id);  
        }   
        if (preg_match('#^-?\d+?\.[0-9]+?0+$#', $order_id)) {  
            return preg_replace('#^(-?\d+\.[0-9]+?)0+$#','$1',$order_id);  
        }
        $order_id = $order_date.mb_substr($order_id,0,7);
        return $order_id;
    }

    // 订单ID
    public static function makeOrder(){
        return self::makeDefaultId();
    }

    public static function makeOnceStr($length){
        //生成一个包含 大写英文字母, 小写英文字母, 数字 的数组
        $arr = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
     
        $str = '';
        $arr_len = count($arr);
        for ($i = 0; $i < $length; $i++)
        {
            $rand = mt_rand(0, $arr_len-1);
            $str.=$arr[$rand];
        }
     
        return $str;
    }
    public static function makeExpressId(){
        $id = array();
        for($i=0;$i<12;$i++){
            $a = rand(1,9);
            $id[$i] = $a;
        }
        return implode('', $id);
    }
}