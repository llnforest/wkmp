var tab ;
var staticPath = document.getElementById("static").value;
var path = document.getElementById("path").value;
layui.config({
    base: staticPath + '/js/app/'
}).use(['element','layer','navbar','user'], function () {
	var $ = layui.jquery,
        element = layui.element,
        layer = layui.layer,
        navbar = layui.navbar({
 		    openNav: true, //展开收缩左侧菜单
			path:path
	    });
	// var path = $("#path").val();

        //加载菜单
        navbar.loadNav(path);
        
        //展开/收缩leftNav菜单 根据leftNav宽度判断
	  	 $("#shrink").click(function(){
	  	  navbar.showNav($(".layui-side-plat").css("width")=='50px');
	  	  $(this).find("i").toggleClass("fa-rotate-180");
	  	 });

	
	  	 //iframe自适应
	     $(window).on('resize', function () {
	    	 //tab下的内容区域
	         var $content = $('.layui-tab-content');
	         $content.height($(this).height() - 111);
	         $content.find('iframe').each(function () {
	             $(this).height($content.height());
	         });
	     }).resize();
	  	 
	     //修改密码
	     $("#changePass").click(function(){
	    	 var userId = $(this).attr("data-id");
	    	 var user = layui.user({userId:userId,path:path});
	    	 user.changePassword(0);
		  });
	     //个人信息
	     $("#selfInfo").click(function(){
	    	 var userId = $(this).attr("data-id");
	    	 var user = layui.user({userId:userId,path:path});
	    	 user.selfInfo();
		 });
	     
	     //系统全屏展示
	     $("#fullscreen").click(function () {
	    	 console.log(this);
	    	 $(this).removeClass("layui-this");
	    	 console.log($(this).attr("class"));
	    
	         var docElm = document.documentElement;
	         //W3C  
	         if (docElm.requestFullscreen) {
	             docElm.requestFullscreen();
	         }
	         //FireFox  
	         else if (docElm.mozRequestFullScreen) {
	             docElm.mozRequestFullScreen();
	         }
	         //Chrome等  
	         else if (docElm.webkitRequestFullScreen) {
	             docElm.webkitRequestFullScreen();
	         }
	         //IE11
	         else if (elem.msRequestFullscreen) {
	             elem.msRequestFullscreen();
	         }
	         layer.msg('按Esc即可退出全屏');
	     });

	     
	     //判断是否显示锁屏
	 	 if(window.sessionStorage.getItem("lockScreen") == "true"){
	 		 lockScreen();
		 }
	     //点击锁屏按钮执行锁屏操作
	     $("#lockScreen").click(function(){
	    	 lockScreen();
		 });
	  	 //快捷键锁屏
	     document.onkeydown=function(event){
	         var e = event || window.event || arguments.callee.caller.arguments[0];
	         if (e.keyCode === 76 && e.altKey) {
	        	 lockScreen();
	         }
	     }

	     //调用锁屏界面
	     function lockScreen(){
	    	 var loginPwd = $("#lockScreen").attr("data-id");
	 		 var user = layui.user({loginPwd:loginPwd});
	    	 user.lockScreen();
	     }
      
	     //设置主题
	     $("#theme").click(function(){
	    	 var userId = $(this).attr("data-id");
	    	 var user = layui.user({userId:userId,path:path});
	    	 user.setTheme();
		 });
        
       
        
        
        
        
        
});


