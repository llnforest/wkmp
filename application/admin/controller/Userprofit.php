<?php
/**
 * 菜单管理控制器
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\UserModel;
use app\admin\model\UserProfitModel;
use think\App;

class Userprofit extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,UserProfitModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            if(isset($this->param['user_id'])){
                $userInfo = UserModel::get($this->param['user_id']);
                $this->data['name'] = $userInfo->name;
                $this->data['phone'] = $userInfo->phone;
            }
            $this->page->setHeader('ID,会员姓名,手机号码,会员等级,奖励类型,奖励金额,奖励来源,来源手机,来源团队,来源团队手机,备注说明,奖励时间');
            $this->pageUtil->setColsWidthArr([1=>120,2=>120,3=>100,4=>120,5=>100,6=>180,8=>180,11=>160]);
            $this->pageUtil->setColsMinWidthArr([10=>300]);
            $this->pageUtil->setColTemplet(6,"#combineTpl");
            $this->pageUtil->setColTemplet(8,"#combineTpl2");
            $this->pageUtil->setColsHideArr([7,9]);
            $this->pageUtil->setToolBar(false);

        }else{
            $this->pageUtil->setDataDictArr([3=>'userLevel',4=>'profitType']);
            $where  = getWhereParam(['b.name'=>'like','b.phone'=>'like','a.type','a.create_time'=>['create_start','create_end']],$this->post);
            $pageData = $this->model::alias('a')
                ->join('pin_user b','a.user_id = b.id','left')
                ->join('pin_user c','a.from_id = c.id','left')
                ->join('pin_user d','a.child_id = d.id','left')
                ->field('a.id,b.name,b.phone,b.level,a.type,a.money,c.name as from_name,c.phone as from_phone,d.name as child_name,d.phone as child_phone,a.remark,a.create_time')
                ->where($where)
                ->order('a.create_time desc')
                ->paginate($this->param['limit']?:"");
            $this->page->setData($pageData);
        }

    }
}