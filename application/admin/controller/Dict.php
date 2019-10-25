<?php
/**
 * 字典管理控制器
 * User: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\DictModel;
use app\admin\model\DictValueModel;
use common\dict\DictUtil;
use think\App;

class Dict extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,DictModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        $this->pageUtil->setColsMinWidthArr([2=>200,3=>200]);
        $this->pageUtil->setColsWidthArr([1=>100,5=>250]);
        $this->pageUtil->setColEdit(1);
    }

    //显示分页列表页面
    public function pageData(){
        if($this->request->isGet()){
            $this->page->setHeader('ID,排序,字典名称,字典编码,备注说明');
        }else{
            $where  = getWhereParam(['dict_name'=>'like','dict_code'=>'like'],$this->param);
            $pageData = $this->model::field('id,sort,dict_name,dict_code,remark')
                ->where($where)
                ->order('sort asc')
                ->paginate($this->param['limit']?:"");
            return $pageData;
        }
    }

    //公用操作方法
    function commonOperate(){
        if($this->request->isPost()){
            DictUtil::clearDict();
        }
    }

    //添加前判断
    function beforeAdd(){
        if($this->request->isPost()){
            $dict = $this->model::where(['dict_code'=>$this->param['dict_code']])->find();
            if(!empty($dict)){
                $result = operateResult(false);
                $result['msg'] .= '：该字典编码已存在';
                die(json_encode($result,JSON_UNESCAPED_UNICODE));
            };
        }
    }

    //添加前判断
    function beforeEdit($data){
        if($this->request->isPost() && isset($this->param['dict_code'])){
            $dict = $this->model::where([['id','neq',$this->id]])->where(['dict_code'=>$this->param['dict_code']])->find();
            if(!empty($dict)){
                $result = operateResult(false,'edit');
                $result['msg'] .= '：该字典编码已存在';
                die(json_encode($result,JSON_UNESCAPED_UNICODE));
            };
        }
    }

    //删除前判断
    function beforeDel($data){
        if($this->request->isPost()){
            $dict = DictValueModel::where(['dict_id'=>$this->id])->find();
            if(!empty($dict)){
                $result = operateResult(false,'del');
                $result['msg'] .= '：该字典下存在字典参数，请先删除！';
                die(json_encode($result,JSON_UNESCAPED_UNICODE));
            };
        }
    }


}