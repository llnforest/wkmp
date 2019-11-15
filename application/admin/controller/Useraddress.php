<?php
/**
 * 菜单管理控制器
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\UserAddressModel;
use app\admin\model\UserModel;
use think\App;

class Useraddress extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,UserAddressModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            if(isset($this->param['user_id'])){
                $userInfo = UserModel::get($this->param['user_id']);
                $this->data['name'] = $userInfo->name;
                $this->data['phone'] = $userInfo->phone;
                $this->data['user_id'] = $userInfo->id;
            }
            $this->page->setHeader('ID,用户ID,会员姓名,手机号码,会员等级,联系人名,联系电话,收货地址,创建时间');
            $this->pageUtil->setColsWidthArr([1=>80,2=>120,3=>120,4=>100,5=>120,6=>120,8=>160,9=>150]);
            $this->pageUtil->setColsMinWidthArr([7=>300]);

        }else{
            $this->pageUtil->setDataDictArr([4=>'userLevel']);
            $where  = getWhereParam(['a.user_id','b.name'=>'like','b.phone'=>'like','a.contact_name'=>'like','a.contact_phone'=>'like','a.address'=>'like','a.create_time'=>['create_start','create_end']],$this->post);
            $pageData = $this->model::alias('a')
                ->join('pin_user b','a.user_id = b.id','left')
                ->field('a.id,a.user_id,b.name,b.phone,b.level,a.contact_name,a.contact_phone,a.address,a.create_time')
                ->where($where)
                ->order('a.create_time desc')
                ->paginate($this->param['limit']?:"");
            $this->page->setData($pageData);
        }

    }

    //添加前操作
    public function beforeAdd(){
        if($this->request->isPost()){
            if(!isset($this->param['user_id']) || empty(UserModel::get($this->param['user_id']))){
                $result = operateResult(false,'add');
                $result['msg'] .= '：用户ID填写错误，没找到该用户！';
                die(json_encode($result,JSON_UNESCAPED_UNICODE));
            };
        }
    }
}