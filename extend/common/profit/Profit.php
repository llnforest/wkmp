<?php
/**
 * User: Lynn
 * Date: 2020/3/17
 * Time: 18:58
 */
namespace common\profit;

use common\utils\ConfigCache;
use model\OrderGiftModel;
use model\UserModel;
use model\UserProfitModel;

class Profit
{
    /**
     * 礼包支付后分佣
     * @param $order_id
     */
    public static function giftProfit($order_id){
        $orderInfo = OrderGiftModel::where(['id'=>$order_id,'status'=>1])->find();
        if(empty($orderInfo)) return errRes([],'订单号错误或订单状态错误');
        $firInfo = UserModel::where(['id' => $orderInfo['from_id'],'status' => 1])->find();
        $type = 1;
        if(!empty($firInfo)){
            if($firInfo['level'] == 1){//vip用户 ConfigCache::get('')
                self::addProfit($firInfo['id'],ConfigCache::get('vipGiftMoney'),$type,$orderInfo['user_id'],$orderInfo['user_id']);
                if($firInfo['parent_id'] != 0){
                    $secInfo = self::getUpParentByGift($firInfo,1);
                    if(!empty($secInfo) && $secInfo['level'] == 2){//推广用户
                        self::addProfit($secInfo['id'],ConfigCache::get('tgToVipGiftMoney'),$type,$firInfo['id'],$orderInfo['user_id']);

                        if($firInfo['parent_id'] != 0){
                            $thrInfo = self::getUpParentByGift($secInfo,2);
                            if(!empty($thrInfo) && $thrInfo['level'] == 3){//高级用户
                                self::addProfit($thrInfo['id'],ConfigCache::get('gjToTgGiftMoney'),$type,$secInfo['id'],$orderInfo['user_id']);
                                $forInfo = self::getUpParentByGift($thrInfo,3);
                                if(!empty($forInfo)) self::addProfit($forInfo['id'],ConfigCache::get('gjToGjGiftMoney'),$type,$thrInfo['id'],$orderInfo['user_id']);
                            }
                        }

                    }elseif(!empty($secInfo) && $secInfo['level'] == 3){//高级用户
                        self::addProfit($secInfo['id'],ConfigCache::get('gjToVipGiftMoney'),$type,$firInfo['id'],$orderInfo['user_id']);
                        $forInfo = self::getUpParentByGift($secInfo,3);
                        if(!empty($forInfo)) self::addProfit($forInfo['id'],ConfigCache::get('gjToGjGiftMoney'),$type,$secInfo['id'],$orderInfo['user_id']);
                    }
                }

            }elseif($firInfo['level'] == 2){//推广用户
                self::addProfit($firInfo['id'],ConfigCache::get('tgToVipGiftMoney'),$type,$orderInfo['user_id'],$orderInfo['user_id']);
                if($firInfo['parent_id'] != 0){
                    $secInfo = self::getUpParentByGift($firInfo,2);
                    if(!empty($secInfo) && $secInfo['level'] == 3){//高级用户
                        self::addProfit($secInfo['id'],ConfigCache::get('gjToTgGiftMoney'),$type,$firInfo['id'],$orderInfo['user_id']);
                        $forInfo = self::getUpParentByGift($secInfo,3);
                        if(!empty($forInfo)) self::addProfit($forInfo['id'],ConfigCache::get('gjToGjGiftMoney'),$type,$secInfo['id'],$orderInfo['user_id']);
                    }
                }
            }elseif($firInfo['level'] == 3){//高级用户
                self::addProfit($firInfo['id'],ConfigCache::get('gjToVipGiftMoney'),$type,$orderInfo['user_id'],$orderInfo['user_id']);
                $forInfo = self::getUpParentByGift($firInfo,3);
                if(!empty($forInfo)) self::addProfit($forInfo['id'],ConfigCache::get('gjToGjGiftMoney'),$type,$firInfo['id'],$orderInfo['user_id']);
            }
        }else{
            return errRes([],'上级用户不存在或用户状态禁用');
        }
    }

    /**
     * 找出上级礼包销售数据
     * @param $userInfo
     * @param $level
     * @param $orderInfo
     * @return bool|mixed
     */
    private static function getUpParentByGift($userInfo,$level){
        $info = UserModel::get(['id' => $userInfo['parent_id'],'status' => 1]);
        if(!empty($info) && in_array($level,[1,2])){
            if($info['level'] > $level){
                return $info;
            }else{
                return self::getUpParentByGift($info,$level);
            }
        }elseif(!empty($info) && $level == 3){
            return $info;
        }else{
            return false;
        }
    }

    /**
     * 添加收益
     * @param $user_id int
     * @param $money int
     * @param $type int 奖励类型 1礼包奖励 2销售额奖励 3流通酒奖励
     * @param $child_id int 来源下级团队
     * @param $from_id int 来源的个人
     * @param $remark string 收益备注
     */
    private static function addProfit($user_id,$money,$type,$child_id,$from_id,$remark = ''){
        //维护余额、总收益、收益纪录
        UserModel::where('id',$user_id)->setInc('balance',$money);
        UserModel::where('id',$user_id)->setInc('total_profit',$money);
        UserProfitModel::create(['user_id' => $user_id,'money' => $money,'child_id' => $child_id,'from_id' => $from_id,'type' => $type,'remark' => $remark]);
        if($type == 1){
            //维护团队总人数
            UserModel::where('id',$user_id)->setInc('total_person_num',1);
            //维护vip人数
            UserModel::where('id',$user_id)->setInc('vip_team_num',1);

        }
    }

    /**
     * 订单结束后分佣
     * @param $order_id
     */
    public static function orderSuccessProfit($orderInfo){
        $firInfo = UserModel::get(['id' => $orderInfo['user_id'],'status' => 1]);
        self::updateSelfSale($firInfo,$orderInfo);//维护自身销售数据
        if(!empty($firInfo) && $firInfo['level'] == 0){//普通用户
            $secInfo = UserModel::get(['id' => $orderInfo['user_id'],'status' => 1]);
            self::addOrderProfit($secInfo,$orderInfo,$firInfo['id'],$firInfo['id'],1);
        }elseif(!empty($firInfo) && $firInfo['level'] == 1) {//vip用户
            self::addOrderProfit($firInfo,$orderInfo,$firInfo['id'],$firInfo['id']);
            $levelInfo = self::getAndSetParentSale($firInfo,1,$orderInfo,$firInfo['id']);
            if($levelInfo && $levelInfo['level'] == 2){//推广顾问
                self::addOrderProfit($levelInfo,$orderInfo,$levelInfo['child_id'],$firInfo['id']);
                $levelInfo = self::getAndSetParentSale($levelInfo,2,$orderInfo,$firInfo['id']);
                if($levelInfo && $levelInfo['level'] == 3) {//高级用户
                    self::addOrderProfit($levelInfo,$orderInfo,$levelInfo['child_id'],$firInfo['id']);
                }
            }elseif($levelInfo && $levelInfo['level'] == 3){//高级用户
                self::addOrderProfit($levelInfo,$orderInfo,$levelInfo['child_id'],$firInfo['id']);
                self::getAndSetParentSale($levelInfo,3,$orderInfo,$firInfo['id']);
            }
        }elseif(!empty($firInfo) && $firInfo['level'] == 2) {//推广用户
            self::addOrderProfit($firInfo,$orderInfo,$firInfo['child_id'],$firInfo['id']);
            $levelInfo = self::getAndSetParentSale($firInfo,2,$orderInfo,$firInfo['id']);
            if($levelInfo && $levelInfo['level'] == 3) {//高级用户
                self::addOrderProfit($levelInfo,$orderInfo,$levelInfo['child_id'],$firInfo['id']);
                self::getAndSetParentSale($levelInfo,3,$orderInfo,$firInfo['id']);

            }
        }elseif(!empty($firInfo) && $firInfo['level'] == 3) {//高级用户
            self::addOrderProfit($firInfo,$orderInfo,$firInfo['child_id'],$firInfo['id']);
            self::getAndSetParentSale($firInfo,3,$orderInfo,$firInfo['id']);
        }
    }

    /**
     * 添加订单分佣
     * @param $userInfo
     * @param $orderInfo
     * @param $child_id
     * @param $from_id
     * @param int $type 1:自身或分享购买  2：下级购买 3:平级伯乐奖励
     * @return bool
     */
    private static function addOrderProfit($userInfo,$orderInfo,$child_id,$from_id,$type = 2){
        if($userInfo['level'] == 0) return false;
        if(in_array($type,[1,2])){
            $percentArr = [1=>ConfigCache::get('vipWineMoney'),2=>ConfigCache::get('tgWineMoney'),3=>ConfigCache::get('gjWineMoney')];
            $percent = $percentArr[$userInfo['level']];
            $common_profit = intval(($orderInfo['common_money'] + $orderInfo['xilie_money']) * $percent/100);
            self::addProfit($userInfo['id'],$common_profit,2,$child_id,$from_id);
        }

        if(in_array($type,[2,3])){//下级购买
            $xilie_percent = $back_money = 0;
            $childInfo = UserModel::get($child_id);
            $fromInfo = UserModel::get($from_id);
            if($userInfo['level'] == 2){//推广
                if($childInfo['level'] == 1){//直接下级vip
                    $xilie_percent = ConfigCache::get('tgToVipXlMoney');
                    $back_money = ConfigCache::get('tgToVipBackMoney');
                }elseif($childInfo['level'] == 2){//平级推广顾问
                    $xilie_percent = ConfigCache::get('tgToTgXlMoney');
                    $back_money = ConfigCache::get('tgToTgBackMoney');
                }
            }elseif($userInfo['level'] == 3){//高级
                if($childInfo['level'] == 1){//直接下级vip
                    $xilie_percent = ConfigCache::get('gjToVipXlMoney');
                    $back_money = ConfigCache::get('gjToVipBackMoney');
                }elseif($childInfo['level'] == 2){//直接下级推广顾问
                    $xilie_percent = ConfigCache::get('gjToTgXlMoney');
                    $back_money = ConfigCache::get('gjToTgBackMoney');
                }elseif($childInfo['level'] == 3) {//平级顾问
                    $xilie_percent = ConfigCache::get('gjToGjXlMoney');
//                    $back_money = ConfigCache::get('gjToGjBackMoney');
                }
            }
            if($fromInfo['total_sale_user'] > ConfigCache::get('backMoneyToAll') && $fromInfo['is_back'] == 0 && $back_money > 0){//一次性奖励
                $fromInfo->save(['is_back' => 1]);
                self::addProfit($userInfo['id'],$back_money,2,$child_id,$from_id,'销售额满'.ConfigCache::get('backMoneyToAll').'元一次性奖励'.$back_money.'元');
            }
            $xilie_profit = intval($orderInfo['xilie_money'] * $xilie_percent / 100);
            self::addProfit($userInfo['id'],$xilie_profit,3,$child_id,$from_id);
        }
    }

    /**
     * 维护上级销售数据并找出高一级用户
     * @param $userInfo
     * @param $level
     * @param $orderInfo
     * @return bool|mixed
     */
    private static function getAndSetParentSale($userInfo,$level,$orderInfo,$from_id){
        $info = UserModel::get(['id' => $userInfo['parent_id'],'status' => 1]);
        if(!empty($info)){
            //维护团队销售总额和系列酒销售总额
            $info->save([
                'total_sale_team' => $info['total_sale_team'] + $orderInfo['common_money'] + $orderInfo['xilie_money'],
                'xl_sale_team' => $info['xl_sale_team'] + $orderInfo['xilie_money']
            ]);
        }
        if(!empty($info) && $info['level'] == $level){
            if(in_array($level,[2,3])) self::addOrderProfit($info,$orderInfo,$userInfo['id'],$from_id,3);//伯乐奖励
            return self::getAndSetParentSale($info,$level,$orderInfo,$from_id);
        }elseif(!empty($info) && $info['level'] > $level){
            $info['child_id'] = $userInfo['id'];
            return $info;
        }else{
            return false;
        }
    }

    /**
     * 维护自身销售数据
     * @param $userInfo
     * @param $orderInfo
     */
    private static function updateSelfSale($userInfo,$orderInfo){
        if($userInfo){
            $userInfo->save([
                'total_sale_team' => $userInfo['total_sale_team'] + $orderInfo['common_money'] + $orderInfo['xilie_money'],
                'total_sale_user' => $userInfo['total_sale_user'] + $orderInfo['common_money'] + $orderInfo['xilie_money'],
                'xl_sale_team' => $userInfo['xl_sale_team'] + $orderInfo['xilie_money'],
                'xl_sale_user' => $userInfo['xl_sale_user'] + $orderInfo['xilie_money'],
                ]);
        }
    }

    /**
     * 用户等级每日维护
     */
    public static function updateLevelEveryDay(){
        $userList = UserModel::where([['status','=','1'],['level','in',[1,2]]])->order('level asc')->select();
        foreach($userList as $item){
            self::isCanUpdate($item);
        }
    }

    /**
     * 是否可以升级
     * @param $userInfo
     */
    private static function isCanUpdate($userInfo){
        if($userInfo['level'] == 1){//vip用户
            //1.团队总人数大于21人
            if($userInfo['total_person_num'] < ConfigCache::get('tgUpByTeamNum')) return errRes([],'团队人数少于'.ConfigCache::get('tgUpByTeamNum').'人');
            //2.直接人数大于6人，并辅助6人销售额大于200元

            $userList = UserModel::where([['parent_id','=',$userInfo['id']],['status','=',1],['level','=', 1]])->select();
            if(count($userList) < ConfigCache::get('tgUpBySaleNum') || self::getFirListBySaleNum($userList) < ConfigCache::get('tgUpBySaleNum'))  return errRes([],'直接团队销售额大于200少于'.ConfigCache::get('tgUpBySaleNum').'人');
            //3.辅导团队20位vip并完成200销售额
            $num = 0;
            self::getChildListBySaleNum($userList,$num);
            if($num < ConfigCache::get('tgUpByTeamSaleNum')) return errRes([],'团队少于'.ConfigCache::get('tgUpByTeamSaleNum').'人销售金额大于200元');
            //成功升级
            self::updateLevel($userInfo,'vip','tg',2);
        }else{//推广用户
            //1.团队总人数大于121人
            if($userInfo['total_person_num'] < ConfigCache::get('gjUpByTeamNum')) return errRes([],'团队人数少于'.ConfigCache::get('gjUpByTeamNum').'人');
            //2.4个直接推广顾问
            $userList = UserModel::where([['parent_id','=',$userInfo['id']],['status','=',1],['level','=', 2]])->select();
            if(count($userList) < ConfigCache::get('gjUpByTgNum'))  return errRes([],'直接推广团队少于'.ConfigCache::get('gjUpByTgNum').'个');
            //成功升级
            self::updateLevel($userInfo,'tg','gj',3);
        }
    }

    /**
     * 修改等级
     * @param $userInfo
     * @param $old_level
     * @param $new_level
     * @param int $level
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    private static function updateLevel($userInfo,$old_level,$new_level,$level = 0){
        $data = [
            $old_level.'_team_num' => $userInfo[$old_level.'_team_num']-1,
            $new_level.'_team_num' => $userInfo[$new_level.'_team_num']+1,
            ];
        if($level > 0){
            $data['level'] = $level;
        }
        UserModel::where(['id' => $userInfo['id']])->update($data);
        $userInfo = UserModel::where(['id' => $userInfo['parent_id'],'status' => 1])->find();
        self::updateLevel($userInfo,$old_level,$new_level,0);

    }
    /**
     * 获取以及团队大于200元销售额人数
     * @param $userList
     * @return int
     */
    private static function getFirListBySaleNum($userList){
        $fir_num = 0;
        foreach($userList as $item){
            if($item['total_total_sale_user'] >= 200) $fir_num ++;
        }
        return $fir_num;
    }

    /**
     * 获取以及团队大于200元销售额人数
     * @param $userList
     * @return int
     */
    private static function getChildListBySaleNum($userList,&$num){
        foreach($userList as $item){
            if($item['total_total_sale_user'] >= 200) $num ++;
            if($num >= 20) break;
            $userList = UserModel::where([['parent_id','=',$item['id']],['status','=',1],['level','=',1]])->select();
            if(count($userList) > 0) $num += self::getChildListBySaleNum($userList,$num);
        }
    }

}