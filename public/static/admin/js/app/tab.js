layui.define('element',function(exports){
	 var $ = layui.jquery,
	 layer = parent.layer === undefined ? layui.layer : parent.layer,
	 element = parent.layui.element,//默认获取父级（对首页框架无影响，便于iframe中页面向顶层添加tab）
	 
	 
	 Tab = function (){
		  this.config = {
			elem:".layui-tab",//选项卡容器
			closed: true, //是否包含删除按钮
			contextMenu:true,//右键菜单
			document:document //顶层窗口，如果是框架内的页面addTab 需要将window.top.document作为参数传入
	      }

	 };
	 
	 var ELEM = {};
	 
	 
		/**
		 * 配置Navbar
		 * @author wangzhen
		 */
	 Tab.prototype.set = function (options) {
	        var that = this;
	        $.extend(true, that.config, options);
	        return that;
	    };
	 
		/**
		 * 初始化
		 */
	    Tab.prototype.init = function () {
	        var that = this;
	        var _config = that.config;
	      
	    	var  $container = $('' + _config.elem + '',_config.document);
	        ELEM.titleBox = $container.children('ul.layui-tab-title');
	        ELEM.contentBox = $container.children('div.layui-tab-content');
	        ELEM.tabFilter =  $container.attr('lay-filter');
	        ELEM.document = _config.document;
	     
	     
	        return that;
	    };
	 
	 

	  /**
	   * 添加tab
	   * @author wangzhen
	   * @param data
	   */
	 Tab.prototype.addTab = function(data,refresh,path){
		  var that = ELEM.titleBox === undefined ? this.init() : this;
	      var _config = that.config;
	      
	      //判断标签是否打开
	      var tabIndex = that.exists(data.menuId);
	      if (tabIndex === -1) {
	    	  var content = '<iframe  src="' + path+'/'+data.href + '" data-id="' + data.menuId + '"></iframe>';
			  var titleStr = '';
	          if (data.icon !== undefined) {
	              titleStr +=  data.icon ;
	          }
	          titleStr += '<cite>' + data.title + '</cite>';
	          titleStr += '<i class="layui-icon layui-unselect layui-tab-close" data-id="' + data.menuId + '">&#x1006;</i>';
	  		
	  		//新增一个Tab项
	  	      element.tabAdd(ELEM.tabFilter, {
	  	        title: titleStr 
	  	        ,content: content
	  	        ,id: data.menuId //菜单的id
	  	      })
	  	      
	  	    //iframe 自适应
            ELEM.contentBox.find('iframe[data-id=' + data.menuId + ']').each(function () {
                $(this).height(ELEM.contentBox.height());
            });
	  	      
	  		 //监听关闭事件
	  	      if(_config.closed){
	  	    	  ELEM.titleBox.find('li').children('i.layui-tab-close[data-id=' + data.menuId + ']').on('click', function () {
	  	    	  element.tabDelete(ELEM.tabFilter, $(this).parent('li').attr('lay-id')).init();
	  	    	});
	  	      }
	  	       //切换到当前打开的选项卡
	           element.tabChange(ELEM.tabFilter, data.menuId);
	  	      
	      }else{
	    	  //切换到当前打开的选项卡
	            element.tabChange(ELEM.tabFilter, data.menuId);
	            if(refresh){
	            	ELEM.contentBox.find('iframe[data-id=' + data.menuId + ']')[0].src = path+'/'+data.href;
	            }
	    	  
	      }
	      
	      
	      if (_config.contextMenu) {
	    	  
	    	  element.on('tab(' + ELEM.tabFilter + ')', function (d) {
	    		  $('div.plat-tabmenu',ELEM.document).remove();
	          });
	    	  
	    	  ELEM.titleBox.find('li').on('contextmenu', function (e) {
	                var $that = $(e.target);
	                e.preventDefault();
	                e.stopPropagation();
	                var $target = e.target.nodeName === 'LI' ? e.target : e.target.parentElement;
	                //判断，如果存在右键菜单的div，则移除，保存页面上只存在一个
	                if ($('div.plat-tabmenu',ELEM.document).length > 0) {
	                	$('div.plat-tabmenu',ELEM.document).remove();
	                }
	                //创建一个div
	                var div = ELEM.document.createElement('div');
	                //设置一些属性
	                div.className = 'plat-tabmenu';
	                div.style.width = '130px';
	                div.style.backgroundColor = 'white';
	                
	                var ul = '<ul>';
	                ul += '<li data-target="refresh" title="刷新当前选项卡"><i class="fa fa-refresh" aria-hidden="true"></i> 刷新</li>';
	                ul += '<li data-target="closeCurrent" title="关闭当前选项卡"><i class="fa fa-close" aria-hidden="true"></i> 关闭当前</li>';
	                ul += '<li data-target="closeOther" title="关闭其他选项卡"><i class="fa fa-window-close-o" aria-hidden="true"></i> 关闭其他</li>';
	                ul += '<li data-target="closeAll" title="关闭全部选项卡"><i class="fa fa-window-close-o" aria-hidden="true"></i> 全部关闭</li>';
	                ul += '</ul>';
	                div.innerHTML = ul;
	                div.style.top = e.pageY + 'px';
	                div.style.left = e.pageX + 'px';
	                //将dom添加到body的末尾
	                ELEM.document.getElementsByTagName('body')[0].appendChild(div);
	                
	                //获取当前点击选项卡的id值
	                var id = $($target).find('i.layui-tab-close').data('id');
	                //获取当前点击选项卡的索引值
	                var clickIndex = $($target).attr('lay-id');
	                
	                var $context = $('div.plat-tabmenu',ELEM.document);
	                
	                if ($context.length > 0) {
	                    $context.eq(0).children('ul').children('li').each(function () {
	                        var $that = $(this);
	                        //绑定菜单的点击事件
	                        $that.on('click', function () {
	                            //获取点击的target值
	                            var target = $that.data('target');
	                            //
	                            switch (target) {
	                                case 'refresh': //刷新当前,刷新前先定位到需要刷新的tab
	                                	element.tabChange(ELEM.tabFilter, id);
	                                	var src = ELEM.contentBox.find('iframe[data-id=' + id + ']')[0].src;
	                                    ELEM.contentBox.find('iframe[data-id=' + id + ']')[0].src = src;
	                                    break;
	                                case 'closeCurrent': //关闭当前
	                                    if (clickIndex !== 'index') {
	                                        element.tabDelete(ELEM.tabFilter, clickIndex);
	                                    }
	                                    break;
	                                case 'closeOther': //关闭其他
	                                    ELEM.titleBox.children('li').each(function () {
	                                        var $t = $(this);
	                                        var id1 = $t.find('i.layui-tab-close').data('id');
	                                        if (id1 != id && id1 !== undefined) {
	                                            element.tabDelete(ELEM.tabFilter, $t.attr('lay-id'));
	                                        }
	                                    });
	                                    break;
	                                case 'closeAll': //全部关闭
	                                    ELEM.titleBox.children('li').each(function () {
	                                        var $t = $(this);
	                                        if ($t.attr('lay-id') !== 'index') {
	                                            element.tabDelete(ELEM.tabFilter, $t.attr('lay-id'));
	                                        }
	                                    });
	                                    break;
	                            }
	                            //处理完后移除右键菜单的dom
	                            $context.remove();
	                        });
	                    });

	                    $(document).on('click', function () {
	                    	//处理完后移除右键菜单的dom
	                        $context.remove();
	                    });
	                }
	                return false;
	    	  });
	      }
	 }
	 
	 
	/**
	 * 参数设置，引用该模块时通过构造方法调用
	 * @author wangzhen
	 * @param {Object} options
	 */
    Tab.prototype.set = function (options) {
        var that = this;
        $.extend(true, that.config, options);
        return that;
    }

	/**
	 * 查询tab是否存在，如果存在则返回索引值，不存在返回-1
	 * @author wangzhen
	 * @param {String} id
	 */
    Tab.prototype.exists = function (id) {
        var that = ELEM.titleBox === undefined ? this.init() : this,
         tabIndex = -1;
        ELEM.titleBox.find('li').each(function (i, e) {
            var tabId = $(this).attr('lay-id')
            if (tabId === id) {
                tabIndex = i;
            };
        });
        return tabIndex;
    };

	

	  var tab = new Tab();
	  exports('tab', function(options){
		  return tab.set(options);
	  });
}); 



   