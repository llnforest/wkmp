layui.define(['element','tab'],function(exports){
	 var $ = layui.jquery,
	 layer = parent.layer === undefined ? layui.layer : parent.layer,
	 element = layui.element,
	 Navbar = function (){
		  this.config = {
		  	  openNav: true, //默认展开二级菜单
			  path:null
	      }
	 };
  	 var tab = layui.tab();
  	
  	 
	/**
	 * 配置Navbar
	 * @author Lynn
	 */
    Navbar.prototype.set = function (options) {
        var that = this;
        //that.config.data = undefined;
        $.extend(true, that.config, options);
        return that;
    };
 	
	/**
	 * 根据获取的topMenu数据生成top菜单html
	 * @author Lynn
	 */
	  Navbar.prototype.loadNav = function(path){
		 var that = this;
		 $.get(path+"admin/index/topMenu", function(data) {
			$.each(data.data,function(index,obj){
				var ulHtml = '';
				ulHtml += '<li name="topNav" id="menuTop'+obj.id+'" class="layui-nav-item">'
				+'<a href="javascript:;">'
				+ obj.menu_icon
				+ '&nbsp;&nbsp;'+obj.menu_name
				+'</a>'
				+'</li>';
				//将topNav追加到html
				$("#topNav").append(ulHtml);
				//渲染左侧菜单
				that.renderLeftNav(obj.id,obj.sub);
				//绑定当前topNav点击事件
				$("#menuTop"+obj.id).click(function(){
					that.loadLeftNav(obj.id);
				});
			});
			element.init();
			that.loadLeftNav(data.data[0].id);
		});
	 }

    /**
     * 根据top菜单的id加载左侧二三级菜单
     * @author Lynn
     */
    Navbar.prototype.renderLeftNav = function (topId,leftMenu){
		var ulHtml = '';
		$.each(leftMenu,function(index,obj){
			ulHtml += '<div class="menuSec'+topId+' plat-leftMenu"><li class="layui-nav-item " id = '+obj.id+' lay-tips='+obj.menu_name+'>';
			ulHtml += '<a href="javascript:;"  data-url="'+obj.menu_url+'"  data-name="form" >';
			if (obj.menu_icon.indexOf('fa-') !== -1) {
				ulHtml += '<i class="fa ' + obj.menu_icon + '" aria-hidden="true" data-icon="' + obj.menu_icon + '"></i>';
			} else {
				ulHtml += obj.menu_icon;
			}
			ulHtml += '<span>&nbsp;&nbsp;'+obj.menu_name+'</span>'
			ulHtml += '</a>'
			//判断是否有三级菜单
			if(obj.sub != undefined && obj.sub != null && obj.sub.length > 0){
				//三级菜单
				ulHtml += '<dl class="layui-nav-child">';
				for(var j=0;j<obj.sub.length;j++){
					ulHtml += '<dd><li class="layui-nav-item" lay-tips='+obj.menu_name+' id='+obj.sub[j].id+'><a style="padding-left:15%;" href="javascript:;" data-url="'+obj.sub[j].menu_url+'">';
					if (obj.sub[j].menu_icon !== undefined && obj.sub[j].menu_icon !== '') {
						ulHtml += obj.sub[j].menu_icon;
					}
					ulHtml += '<span>&nbsp;&nbsp;'+obj.sub[j].menu_name+'</span></a><li></dd>';
				}
				ulHtml += "</dl>"
			}
			ulHtml += '</li></div>';
		});
		$("#leftNav").append(ulHtml);
		element.init();
    }
	  
	  /**
	   * 根据top菜单的id加载左侧二三级菜单
	   * @author Lynn
	   */
	  Navbar.prototype.loadLeftNav = function (id){
			 var that = this;
			// 1.更改样式
			$("[name=topNav]").removeClass("layui-this");
			$("#menuTop"+id).addClass("layui-this");
	  		//2、显示
		  	$(".plat-leftMenu").hide();
		  	$(".menuSec"+id).show();
		  	// 3、点击
	  	    that.showNav(that.config.openNav);
	  	    that.clickNav();
	  }
	  
		
	  /**
	   * 展开或收缩二级菜单
	   * @author Lynn
	   */
	  Navbar.prototype.showNav = function(openNav){
		  	var that = this;
			if(openNav){
				//0.设置折叠区域宽度
				$(".layui-side-fold").animate({width:'200px'});
				//1.设置 layui-side-plat左侧菜单div宽度
				$(".layui-side-plat").animate({width:'200px'});
				//2.设置layui-nav-item宽度
				$("#leftNav .layui-nav-item").animate({width:'200px'});
				//3.菜单名称显示
				$("#leftNav .layui-nav-item span").show();
				//4.设置body内容宽度样式
				$('#container').animate({ left:'200'});
				//5.接触layui-nav-item的hover事件
				$("#leftNav .layui-nav-item").unbind('mouseenter').unbind('mouseleave');
			}else{
				//0.设置折叠区域宽度
				$(".layui-side-fold").animate({width:'50px'});
				//1.设置 layui-side-plat左侧菜单div宽度
				$(".layui-side-plat").animate({width:'50px'});
				//2.设置layui-nav-item宽度
				$("#leftNav .layui-nav-item").animate({width:'50px'});
				//3.菜单名称隐藏
				$("#leftNav .layui-nav-item span").hide();
				//4.设置body内容宽度样式
				$('#container').animate({ left:'50'});
				//5.给layui-nav-item添加hover事件
			    $("#leftNav .layui-nav-item").hover(function(){
			     tipsi = layer.tips($(this).attr("lay-tips"),this,{anim: 5});
			   },function(){
					layer.close(tipsi);
			   });
			}
			
	  }
	 
	  /**
	   * 绑定左侧菜单事件定事件
	   * @author Lynn
	   */
	 
	  Navbar.prototype.clickNav = function (){
          var that = this;
		  $("#leftNav .layui-nav-item a").bind("click",function(){
	    		var href   = $(this).data('url');
	    		if(href == "") return false;
			    var menuId = $(this).parent().attr("id");
				var title  = $(this).children('span').text();

	    		var icon   = $(this).children('i:first').data('icon');
	    		var data   = {href: href,icon: icon,title: title,menuId:menuId};
	    		tab.addTab(data,false,that.config.path);
		  });
	  }

  var navbar = new Navbar();
  exports('navbar', function(options){
	  return navbar.set(options);
  });
}); 

	
   