<?php
/**
 * 菜单管理控制器
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\UserModel;
use app\admin\model\UserSerachModel;
use think\App;

class Usersearch extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,UserSerachModel::class);
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
            $this->page->setHeader('ID,用户Id,用户姓名,手机号码,会员等级,搜索关键词,搜索时间');
            $this->pageUtil->setColsWidthArr([1=>80,2=>120,3=>120,4=>100,6=>160,7=>90]);
            $this->pageUtil->setColsMinWidthArr([5=>150]);

        }else{
            $this->pageUtil->setDataDictArr([4=>'userLevel']);
            $where  = getWhereParam(['a.user_id','b.name'=>'like','b.phone'=>'like','a.keywords'=>'like','a.create_time'=>['create_start','create_end']],$this->param);
            $pageData = $this->model::alias('a')
                ->join('pin_user b','a.user_id = b.id','left')
                ->field('a.id,a.user_id,b.name,b.phone,b.level,a.keywords,a.create_time')
                ->where($where)
                ->order('a.create_time desc')
                ->paginate($this->param['limit']?:"");
            $this->page->setData($pageData);
        }

    }
}