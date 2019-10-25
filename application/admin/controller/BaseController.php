<?php
/**
 * User: Lynn
 * Date: 2019/4/4
 * Time: 16:04
 */

namespace app\admin\controller;


use chromephp\chromephp;
use common\auth\AuthUtil;
use common\page\Page;
use common\page\PageDataTrans;
use common\page\PageUtil;
use think\App;
use think\facade\Session;

class BaseController extends  AuthController
{
    protected $pageUtil;
    protected $page;
    protected $model;

    public function __construct(App $app = null,$model)
    {
        parent::__construct($app);
        $this->model = $model;
    }

    /**
     * 渲染分页工具类
     */
    protected function initPage(){
        $this->page = new Page();
        $this->pageUtil = new PageUtil();
        if(method_exists($this,"renderPage")) $this->renderPage();
    }


    public function index(){
        $this->initPage();
        if($this->request->isGet()){
            if(method_exists($this,"pageData")) $this->pageData();
            $this->data['page'] = PageDataTrans::transPageCols($this->page,$this->pageUtil);
            $this->data['listButs'] = AuthUtil::getAuthChildMenu(Session::get('auth'),$this->data['auth']['url'],'B',1);
            $this->data['barButs'] = AuthUtil::getAuthChildMenu(Session::get('auth'),$this->data['auth']['url'],'B',2);
            $this->data['listTabs'] = AuthUtil::getAuthChildMenu(Session::get('auth'),$this->data['auth']['url'],'T');
            return view('index',$this->data);
        }else{
            if(method_exists($this,"pageData")) $pageData = $this->pageData();
            $this->page->setData(isset($pageData)?$pageData:[]);
            return PageDataTrans::transData($this->page,$this->pageUtil);
        }

    }

    /**
     * 详情页面
     * @return \think\response\View
     */
    public function detail(){
        if($this->request->isGet()) {
            isset($this->param['id']) && $this->data['info'] = $this->model::get($this->id);
            if (method_exists($this,"beforeDetail")) $this->beforeDetail($this->data['info']);
            return view('detail', $this->data);
        }
    }

    /**
     * 添加接口和页面
     */
    public function add(){
        if(method_exists($this,"commonOperate")) $this->commonOperate();
        if($this->request->isPost()){
            if(method_exists($this,"beforeAdd")) $this->beforeAdd();
            return operateResult($this->model::create($this->param),'add');
        }else{
            if(method_exists($this,"beforeAdd")) $this->beforeAdd();
            return view('detail',$this->data);
        }
    }

    /**
     * 修改接口和页面
     */
    public function edit(){
        if(method_exists($this,"commonOperate")) $this->commonOperate();
        if($this->request->isPost()){
            if(!isset($this->param['id']) || empty($info = $this->model::get($this->id))) return paramRes();
            if(method_exists($this,"beforeEdit")) $this->beforeEdit($info);
            return operateResult($info->save($this->param),'edit');
        }else{
            isset($this->param['id']) && $this->data['info'] = $this->model::get($this->id);
            if(method_exists($this,"beforeEdit")) $this->beforeEdit($this->data['info']);
            return view('detail',$this->data);
        }
    }

    /**
     * 删除接口
     */
    public function del(){
        if($this->request->isPost()){
            if(!isset($this->param['id']) || empty($info = $this->model::get($this->id))) return paramRes();
            if(method_exists($this,"beforeDel")) $this->beforeDel($info);
            return operateResult($info->delete(),'del');
        }
    }

    /**
     * 批量删除接口
     */
    public function delBatch(){
        if($this->request->isPost()){
            if(!isset($this->param['ids'])) return paramRes();
            if(method_exists($this,"beforeDelBatch")) $this->beforeDelBatch();
            return operateResult($this->model::where('id','in',$this->param['ids'])->delete(),'del');
        }
    }
}