<?php
/**
 * User: Lynn
 * Date: 2019/11/18
 * Time: 11:55
 */

namespace app\index\controller;


use app\index\model\SysDictModel;
use app\index\model\UserModel;
use app\index\model\UserProfitModel;
use app\index\model\UserTakeModel;
use common\dict\DictUtil;
use think\App;
use think\facade\Config;

class Prize extends BaseController
{
    protected $data;
    function __construct(App $app = null)
    {
        parent::__construct($app);
    }

    /**
     * 奖励中心
     * @return \think\response\Json
     */
    public function prize(){
        $this->data['userInfo'] = UserModel::where('id',$this->user_id)->find();
        $this->data['userInfo']['user_type'] = DictUtil::getDictName('userType',$this->data['userInfo']['type']);
        return json(sucRes($this->data));
    }

    /**
     * 提现记录
     * @return \think\response\Json
     */
    public function takelist(){
        $this->data['userInfo'] = UserModel::where('id',$this->user_id)->find();
        $page = !empty($this->param['page'])?$this->param['page']:1;
        $this->data['takeList'] = UserTakeModel::where(['user_id' => $this->user_id])->page($page,Config::get('paginate.list_rows'))->select();
        foreach($this->data['takeList'] as &$v){
            $v['take_status'] = DictUtil::getDictName('takeStatus',$v['status']);
        }
        return json(sucRes($this->data));
    }

    /**
     * 我的收益
     * @return \think\response\Json
     */
    public function profit(){
        $this->data['userInfo'] = UserModel::where('id',$this->user_id)->find();
        $page = !empty($this->param['page'])?$this->param['page']:1;
        $this->data['profitList'] = UserProfitModel::where(['a.user_id' => $this->user_id])
            ->join('pin_user b','a.child_id = b.id','left')
            ->join('pin_user c','c.from_id = b.id','left')
            ->field('a.*,b.name as team_name,b.phone as team_phone,c.name as from_name,c.phone as from_phone')
            ->page($page,Config::get('paginate.list_rows'))->select();
        foreach($this->data['takeList'] as &$v){
            $v['profit_type'] = DictUtil::getDictName('profitType',$v['type']);
        }
        return json(sucRes($this->data));
    }

    /**
     * 我的团队
     * @return \think\response\Json
     */
    public function team(){
        $this->data['userInfo'] = UserModel::where('id',$this->user_id)->find();
        $where = ['parent_id' => $this->id];
        $page = !empty($this->param['page'])?$this->param['page']:1;
        $where['level'] = isset($this->param['level']) ? $this->param['level'] : 1;
        $this->data['teamList'] = UserModel::where($where)->page($page,Config::get('paginate.list_rows'))->select();
        return json(sucRes($this->data));
    }

    /**
     * 礼包页面
     * @return \think\response\Json
     */
    public function gift(){
        $this->data['giftList'] = SysDictModel::alias('a')
                                ->join('sys_dict_value b','a.id = b.dict_id','left')
                                ->where(['a.dict_code' => 'giftType'])
                                ->field('b.*')
                                ->order('b.sort asc')
                                ->select();
        foreach($this->data['giftList'] as &$v){
            $v['remark'] = Config::get('app.upload.img_url').str_replace('\\','/',$v['remark']);
        }
        return json(sucRes($this->data));
    }



    //---------------------------------操作API---------------------------------


}

