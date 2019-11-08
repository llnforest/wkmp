<?php
/**
 * 配置管理控制器
 * User: Lynn
 * Date: 2019/4/26
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\ConfigModel;
use app\admin\model\DictValueModel;
use think\App;
use think\facade\Cache;

class Config extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,ConfigModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            $this->page->setHeader('ID,排序,配置编码,配置名称,配置数值,单位,备注说明');
            $this->pageUtil->setColsMinWidthArr([2=>180,3=>180,4=>180]);
            $this->pageUtil->setColsWidthArr([1=>100,5=>70,7=>150]);
            $this->pageUtil->setColsEditArr([1=>'text',4=>'text']);
            $this->pageUtil->setShowNumbers(false);
        }else{
            $where  = getWhereParam(['config_name'=>'like','config_code'=>'like'],$this->param);
            $pageData = $this->model::field('id,sort,config_code,config_name,config_value,units,remark')
                ->where($where)
                ->order('sort asc')
                ->paginate($this->param['limit']?:"");
            $this->page->setData($pageData);
        }
    }

    //添加前判断
    function beforeAdd(){
        if($this->request->isPost()){
            $dict = $this->model::where(['config_code'=>$this->param['config_code']])->find();
            if(!empty($dict)){
                $result = operateResult(false);
                $result['msg'] .= '：该配置编码已存在';
                die(json_encode($result,JSON_UNESCAPED_UNICODE));
            };
        }
    }

    //添加前判断
    function beforeEdit($data){
        if($this->request->isPost() && isset($this->param['dict_code'])){
            $dict = $this->model::where([['id','neq',$this->id]])->where(['config_code'=>$this->param['config_code']])->find();
            if(!empty($dict)){
                $result = operateResult(false,'edit');
                $result['msg'] .= '：该配置编码已存在';
                die(json_encode($result,JSON_UNESCAPED_UNICODE));
            };
        }
    }

    //清除缓存
    public function clearCache(){
        Cache::clear();
        return operateResult(true,'cache_clear');
    }

}