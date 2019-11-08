<?php
/**
 * User: Lynn
 * Date: 2019/4/4
 * Time: 17:12
 */

namespace common\page;


class Page
{

	/**
	 * 当前页码，默认为1
	 */
//	protected $page = 1;

	/**
	 * 每页显示数据条数，默认为10
	 */
//	protected $limit = 10;

	/**
	 * 列表查询数据总行数
	 */
	protected $rowSize = 0;

	/**
	 * 列表查询数据总页数
	 */
	protected $allPage = 0;

	/**
	 * sql/hql查询返回的列表集合
	 */
//	protected <!-- data = Collections.emptyList();-->

	/**
	 * sql/hql查询返回的表头数组
	 */
	public $header = [];

	/**
	 * 表头转成json格式字符串
	 */
	protected $headerJson;

	/**
	 * 数据列表其它参数json格式字符串
	 */
	protected $options;

	/**
	 * 是否显示查询重置按钮
	 */
	protected $showQueryBut = true;

	/**
	 * 是否显示导出按钮
	 */
	protected $showExportBut = true;


	protected $data = [];

//	public function Page($page = 1,$limit = 10){
//		$this->setPage($page);
//		$this->setLimit($limit);
//	}

	public function setData($list){
	    $this->data = $list->items();
	    $this->rowSize = $list->total();
    }

    public function getData(){
	    return $this->data;
    }

    public function getRowSize(){
	    return $this->rowSize;
    }

	/**
	 * 设置当前页码，小于1时自动调整为1，大于最大页码时自动调整为最大页
	 * 2017年6月21日
	 * @return
	 * author:wangzhen
	 */
//	public function getPage() {
//		if ($this->page == 0)
//            $this->page = 1;
//		if ($this->page > $this->getRowSize())
//            $this->page = $this->getRowSize();
//		return $this->page;
//	}
//
//	public function setPage($page) {
//        $this->page = $page;
//	}

//	public function getLimit() {
//		return $this->limit;
//	}
//
//	public function setLimit($limit) {
//		$this->limit = $limit;
//	}




	public function getHeader() {
		return $this->header;
	}

	public function setHeader($header) {
		$this->header = explode(',',$header);
	}


	public function getHeaderJson() {
		return $this->headerJson;
	}

	public function setHeaderJson($headerJson) {
		$this->headerJson = $headerJson;
	}

	public function getOptions() {
		return $this->options;
	}

	public function setOptions($options) {
		$this->options = $options;
	}

	public function isShowQueryBut() {
		return $this->showQueryBut;
	}

	public function setShowQueryBut($showQueryBut) {
		$this->showQueryBut = $showQueryBut;
	}

	public function isShowExportBut() {
		return $this->showExportBut;
	}

	public function setShowExportBut($showExportBut) {
		$this->showExportBut = $showExportBut;
	}



}