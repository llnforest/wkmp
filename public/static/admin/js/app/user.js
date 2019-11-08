layui.define(['element','colorpicker'],function(exports){
	 var $ = layui.jquery,
	 layer = parent.layer === undefined ? layui.layer : parent.layer,
	 element = layui.element,
	 colorpicker = layui.colorpicker,
	 User = function (){
		  this.config = { //初始化配置
		  	  userId:null,
			  path:null,
	      }
	 };
  	 
	/**
	 * 配置User 合并that.config和options对象
	 * @author wangzhen
	 */
	 User.prototype.set = function (options) {
        var that = this;
        $.extend(true, that.config, options);
        return that;
    };
 	
	/**
	 * 修改密码前端弹层
	 * type:0 正常修改密码  1强制修改密码
	 * @author wangzhen
	 */
    User.prototype.changePassword = function(type){
    	var that = this;
		var passwordHtml = '';
		var type = type || 0;
 	    passwordHtml+='<blockquote class="layui-elem-quote layui-text">';
 	    passwordHtml+='注：1.密码长度为8位英文字符；';
 	    passwordHtml+='2.密码必须包含字母、数字和特殊符号；';
 	    passwordHtml+='</blockquote>';
 	    passwordHtml+='';
 	    
 		passwordHtml += '<div class="layui-form-item">';
 		passwordHtml += '<div class="layui-inline">';
 		passwordHtml += '<label class="layui-form-label">新&nbsp;&nbsp;密&nbsp;&nbsp;码：</label>';
 		passwordHtml += '<div class="layui-input-inline">';
 		passwordHtml += '<input type="password" id="newPass" name="newPass"  class="layui-input">';
 		passwordHtml += '</div>';
 		passwordHtml += '</div>';
 		passwordHtml += '</div>';
 		
 		passwordHtml += '<div class="layui-form-item">';
 		passwordHtml += '<div class="layui-inline">';
 		passwordHtml += '<label class="layui-form-label">确认密码：</label>';
 		passwordHtml += '<div class="layui-input-inline">';
 		passwordHtml += '<input type="password" id="affirm" name="affirm"  class="layui-input">';
 		passwordHtml += '</div>';
 		passwordHtml += '</div>';
 		
 		passwordHtml += '</div>';
 		if(type == 0){
 			layer.open({
 				title:'修改密码',
 				type: 1,
 				btn:["保存","关闭"],
 				btnAlign:'l',
 				btn1:function(){
 					that.submitPassword(that.config.userId,that.config.path);
 				},
 				btn2:function(){
 					layer.closeAll();
 				},
 				area: ['500px', '300px'],
 				shade: 0.5,
 				content: passwordHtml
 			});
 		}else{
 			layer.open({
 				title:'修改密码',
 				type: 1,
 				closeBtn: 0,
 				btn:["保存"],
 				btnAlign:'l',
 				btn1:function(){
 					that.submitPassword(that.config.userId,that.config.path);
 				},
 				area: ['500px', '300px'],
 				shade: 0.5,
 				content: passwordHtml
 			});

 		}
		 
	 }
    
    /**
	 * 验证密码并修改密码
	 * @author wangzhen
	 * @param userId
	 */
    User.prototype.submitPassword = function(userId,path){
    	var newPass = $("#newPass").val();
    	var affirm = $("#affirm").val();
    	
    	if(newPass==null||newPass==''){
    		layer.tips('新密码不能为空！', '#newPass', {
    			  tips: [2, '#3595CC'],
    			  time: 5000
    		});
    		return;
    	}
    	
    	if(affirm==null||affirm==''){
    		layer.tips('确认密码不能为空！', '#affirm', {
    			  tips: [2, '#3595CC'],
    			  time: 5000
    		});
    		return;
    	}
    	
    	if(newPass!=affirm){
    		layer.tips('两次密码输入不一致！', '#affirm', {
    			  tips: [2, '#3595CC'],
    			  time: 5000
    		});
    		return;
    	}
    	
    	if(newPass.length!=8){
    		layer.tips('密码位数不能少于8位！', '#newPass', {
    			  tips: [2, '#3595CC'],
    			  time: 5000
    		});
    		return;
    	}
    	
    	var reg = new RegExp(/(?=.*[A-z])(?=.*\d)(?=.*[#@!~%^&*\+\-\(\)_?.><\|\\=\[\]{}:;\"\'])[A-z\d#@!~%^&*\+\-\(\)_?.><\|\\=\[\]{}:;\"\']{8}/);
        if (!reg.test(newPass)) {
        	layer.tips('密码必须同时包含数字、字母和特殊字符！', '#newPass', {
    			  tips: [2, '#3595CC'],
    			  time: 5000
    		});
        	return;
        } 
        $.ajax({
            url: path+'admin/index/changePassword',
            type: 'POST',
            data: {"password":hex_md5(hex_md5(newPass))},
            dataType: "json",
            success:function (data){
            	 //保存成果
            	 if(data.code=='0'){
            		 layer.closeAll();
            		 layer.msg("密码修改成功");
            	 }else if(data.code == '2'){
            		 layer.tips(data.desc, '#newPass', {
           			  tips: [2, '#3595CC'],
           			  time: 5000
            		 });
            	 }else{
            		 layer.msg("密码修改失败，请联系管理员进行修改！"); 
            	 }
            }
         });
    }

    /**
     * 设置个人基本资料
     * @author wangzhen
     */
    User.prototype.selfInfo = function(){
    	var that = this;
		layer.open({
	    	title:'个人基本信息',
	    	type: 2,
	    	area: ['900px', '600px'],
	        shade: 0.5,
	        content:that.config.path+'admin/index/selfInfo?readonly=true&id='+that.config.userId
	    });
    }
	
    
    User.prototype.lockScreen = function(){
    	var that = this;
    	var passwordHtml = '';
 	    passwordHtml+='<blockquote class="layui-elem-quote layui-text">';
 	    passwordHtml+='注：输入密码进行解锁';
 	    passwordHtml+='</blockquote>';
 		passwordHtml += '<div class="layui-form-item" style="padding:25px 25px 25px 50px">';
 		passwordHtml += '<div class="layui-input-inline">';
 		passwordHtml += '<input type="text" id="password" name="password" placeholder="请输入密码" class="layui-input">';
 		passwordHtml += '</div>';
 		passwordHtml += '<div class="layui-input-inline" style="width:60px;">';
 		passwordHtml += '<button class="layui-btn" id="unlock"><i class="fa fa-unlock-alt" aria-hidden="true"></i>&nbsp;解锁</button>';
 		passwordHtml += '</div>';
 		passwordHtml += '</div>';

		layer.open({
			title: false,
	    	type: 1,
	    	closeBtn: 0,
	    	area: ['400px', '200px'],
	    	shade: [0.9, '#393D49'],
	        content: passwordHtml,
	        success: function(layero, lockIndex){
	        	//将锁屏标志放到本地sessionStorage中。但是新建的窗口取不到，后面可以放到cookie中
	        	window.sessionStorage.setItem("lockScreen",true);
	            $("#unlock").click(function(){
            	   var pwd = $("#password").val()
	                if (pwd==null||pwd.trim()=='') {
	                    layer.msg('请输入密码!', {icon: 2,time: 1000 });
	                    return;
	                }
            	   var md5pwd = hex_md5(hex_md5(pwd));
            	   if(md5pwd==that.config.loginPwd){
            		   layer.close(lockIndex);
            		   window.sessionStorage.setItem("lockScreen",false);
            	   }else{
            		   layer.msg('密码错误！', { icon: 2, time: 1000 });
            	   }
            	   
	            });
	     
	          }
	    });
		 
    }
    
    
    
	/**
	 * 设置主题前端弹层
	 * @author wangzhen
	 */
    User.prototype.setTheme = function(){
    	var that = this;
		var setThemeHtml = '';
	 
		 setThemeHtml += '<input name="topColor" value="" id="topColor" type="hidden">';
		 setThemeHtml += '<input name="leftColor" value="" id="leftColor" type="hidden">';
		 setThemeHtml += '<fieldset class="layui-elem-field layui-field-title"><legend>主题设置 - 纯色主题</legend></fieldset>';
		 setThemeHtml += '<div class="layui-card-body plat-setTheme">';
		 setThemeHtml += '<ul>';
		 setThemeHtml += that.creatThemeDiv('#393D49','#393D49','默认');
		 setThemeHtml += that.creatThemeDiv('#009688','#009688','墨绿');
		 setThemeHtml += that.creatThemeDiv('#1b8fe6','#1b8fe6','蓝色');
		 setThemeHtml += that.creatThemeDiv('#F39C34','#F39C34','橙色');
		 var zi = '<div style="margin-left: -10px;margin-top: -5px;"><div id="colorpickerAll"></div></div>';
		 setThemeHtml += that.creatThemeDiv('red','red',zi);
		 setThemeHtml += '</ul>'; 
		 setThemeHtml += '</div>';
		
		 setThemeHtml += '<fieldset class="layui-elem-field layui-field-title"><legend>主题设置 - 混色主题</legend></fieldset>';
		 setThemeHtml += '<div class="layui-card-body plat-setTheme">';
		 setThemeHtml += '<ul>';
		 setThemeHtml += that.creatThemeDiv('#009688','#393D49','墨绿');
		 setThemeHtml += that.creatThemeDiv('#1b8fe6','#393D49','蓝色');
		 setThemeHtml += that.creatThemeDiv('#F39C34','#393D49','橙色');
		 setThemeHtml += that.creatThemeDiv('#F86738','#393D49','臧红');
		 var zix = '<div style="margin-left: 20px;margin-top: -15px;"><div id="colorpickerTop"></div></div>';
		 	 zix += '<div style="margin-left: -20px;margin-top: -20px;"><div id="colorpickerLeft"></div></div>';
		 setThemeHtml += that.creatThemeDiv('red','green',zix);
		 setThemeHtml += '</ul>';
		 setThemeHtml += '</div>';
		
		layer.open({
	    	title:false,
	    	type: 1,
	    	closeBtn: 0,
	    	btn:["应用","关闭"],
	    	btn1:function(){
	    		that.saveUserTheme(that.config.userId,that.config.path);
	        },
	        btn2:function(){
	           layer.closeAll();
	        },
	    	area: ['630px', '400px'],
	        shade: 0,
	        content: setThemeHtml,
            zIndex: layer.zIndex,
	        success: function(layero, lockIndex){
	        	$(".layui-card-body li").click(function(e){
	        		var topColor = $(this).find(".plat-theme-top").css("background-color");
	        		var leftColor = $(this).find(".plat-theme-left").css("background-color");
	        		//点击自定义li时不响应式设置颜色
	        		if(topColor == 'rgb(255, 0, 0)'){
	        			return ;
	        		}
	        		//设置到隐藏域中
	        		$("#topColor").val(topColor);
	        		$("#leftColor").val(leftColor);
	        		that.changeTopColor(topColor);
	        		that.changeLeftColor(leftColor);
	        	});
	        }
	    });
		
		  //选择颜色（顶部、左侧同色）
		  colorpicker.render({
			     elem: '#colorpickerAll'
			     ,format: 'rgb'
			    ,predefine: true
			    ,alpha: true
			    ,done: function(color){
			    //设置到隐藏域中
			  	 $("#topColor").val(color);
        		 $("#leftColor").val(color);
			      color || this.change(color); //清空时执行 change
			    }
			    ,change: function(color){
			    	that.changeTopColor(color);
		        	that.changeLeftColor(color);
			    }
			 });
		  
		  //选择左侧颜色
		  colorpicker.render({
			     elem: '#colorpickerLeft'
			     ,format: 'rgb'
			    ,predefine: true
			    ,alpha: true
			    ,done: function(color){
        		 $("#leftColor").val(color);
			      color || this.change(color); //清空时执行 change
			    }
			    ,change: function(color){
		        	 that.changeLeftColor(color);
			    }
			  });
		  
		  //选择顶部颜色
		  colorpicker.render({
			     elem: '#colorpickerTop'
			    ,format: 'rgb'
			    ,predefine: true
			    ,alpha: true
			    ,done: function(color){
			    	alert(color);
			   	 $("#topColor").val(color);
			      color || this.change(color); //清空时执行 change
			    }
			    ,change: function(color){
			    	 that.changeTopColor(color);
			    }
			  });
	 }
    
    
    /**
     * 改变顶部颜色
     */
    User.prototype.changeTopColor = function(color){
    	$(".layui-header").css("background-color",color)
    }
    
    /**
     * 改变左侧颜色
     */
    User.prototype.changeLeftColor = function(color){
    	$(".layui-side-plat").css("background-color",color)
    	$("#leftNav").css("background-color",color)
    }

    /**
     * 保存用户自定义皮肤
     */
    User.prototype.saveUserTheme = function(userId,path){
    	var topColor = $("#topColor").val();
		var leftColor = $("#leftColor").val();
		if((topColor==null||topColor.trim()=='')&&(leftColor==null||leftColor.trim()=='')) {
			 layer.msg("请选择主题！"); 
			 return ;
		}
		
        $.ajax({
            url: path+'admin/index/setSkin',
            type: 'POST',
            data: {"top_color":topColor,"left_color":leftColor},
            dataType: "json",
            success:function (data){
            	 //保存成果
            	 if(data.code=='0'){
            		 layer.closeAll();
            		 layer.msg("主题设置成功！"); 
            	 }else{
            		 layer.msg("主题设置失败！"); 
            	 }
            }
         });
		
    }
    
    /**
     * 生成主题设置div
     * @param topColor
     * @param leftColor
     * @param title
     * @returns {String}
     * @author wangzhen
     */
    User.prototype.creatThemeDiv = function(topColor,leftColor,title){
    	var that = this;
    	var div = '';
    	div += '<li>';
    	div += '<div class="layui-row plat-theme-top" style="background-color: '+topColor+'" ></div>';
    	div += '<div class="layui-row">';
    	div += '<div class="layui-col-xs2 plat-theme-left"  style="background-color: '+leftColor+';"></div>';
    	div += '<div class="layui-col-xs10 plat-theme-title">'+title+'</div>';
    	div += '</div>';
    	div += '</li>';
    	return div;
    	
    }
    
	 
  var user = new User();
  exports('user', function(options){
	  //options构造参数
	  return user.set(options);
  });
}); 

	
   