<?php
/**
 * 配置管理控制器
 * Sysuser: Lynn
 * Date: 2019/4/26
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\SysConfigModel;
use app\admin\model\SysDictValueModel;
use common\utils\ConfigCache;
use think\App;
use think\facade\Cache;

class Sysconfig extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,SysConfigModel::class);
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
            $where  = getWhereParam(['config_name'=>'like','config_code'=>'like'],$this->post);
            $pageData = $this->model::field('id,sort,config_code,config_name,config_value,units,remark')
                ->where($where)
                ->order('sort asc')
                ->paginate($this->param['limit']?:"");
            $this->page->setData($pageData);
        }
    }

    //添加
    function add($template = null){
        if($this->request->isPost()){
            $dict = $this->model::where(['config_code'=>$this->param['config_code']])->find();
            if(!empty($dict)){
                $result = operateResult(false);
                $result['msg'] .= '：该配置编码已存在';
                die(json_encode($result,JSON_UNESCAPED_UNICODE));
            };
            $result = $this->model::create($this->param);
            if($result) ConfigCache::setConfigCache($this->model::column('config_value','config_code'));
            return operateResult($result,'add');
        }else{
            return view($template?:'detail',$this->data);
        }
    }

    //修改
    function edit($template = null){
        if($this->request->isPost() && isset($this->param['dict_code'])){
            $dict = $this->model::where([['id','neq',$this->id]])->where(['config_code'=>$this->param['config_code']])->find();
            if(!empty($dict)){
                $result = operateResult(false,'edit');
                $result['msg'] .= '：该配置编码已存在';
                die(json_encode($result,JSON_UNESCAPED_UNICODE));
            };
            if(!isset($this->param['id']) || empty($info = $this->model::get($this->id))) return paramRes();
            $result = $info->save($this->param);
            if($result) ConfigCache::setConfigCache($this->model::column('config_value','config_code'));
            return operateResult($result,'edit');
        }else{
            isset($this->param['id']) && $this->data['info'] = $this->model::get($this->id);
            return view($template?:'detail',$this->data);
        }
    }

    //修改字段接口
    public function editField($template = null){
        if($this->request->isPost()){
            if(!isset($this->param['id']) || empty($info = $this->model::get($this->id))) return paramRes();
            $result = $info->save($this->param);
            if($result && $this->request->has('config_code')) ConfigCache::setConfigCache($this->model::column('config_value','config_code'));
            return operateResult($result,'edit');
        }
    }

    //删除接口
    public function del(){
        if($this->request->isPost()){
            if(!isset($this->param['id']) || empty($info = $this->model::get($this->id))) return paramRes();
            $result = $info->delete();
            if($result) ConfigCache::setConfigCache($this->model::column('config_value','config_code'));
            return operateResult($result,'del');
        }
    }

    //批量删除接口
    public function delBatch(){
        if($this->request->isPost()){
            if(!isset($this->param['ids'])) return paramRes();
            $result = $this->model::where('id','in',$this->param['ids'])->delete();
            if($result) ConfigCache::setConfigCache($this->model::column('config_value','config_code'));
            return operateResult($result,'del');
        }
    }

    //清除缓存
    public function clearCache(){
        Cache::clear();
        ConfigCache::setConfigCache($this->model::column('config_value','config_code'));
        return operateResult(true,'cache_clear');
    }



}