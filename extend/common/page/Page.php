<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 17:12
 */

namespace common\page;


class Page
{

	/**
	 * 列表查询数据总行数
	 */
	protected $rowSize = 0;

	/**
	 * 列表查询数据总页数
	 */
	protected $allPage = 0;

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