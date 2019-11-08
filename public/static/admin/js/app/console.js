layui.config({
    base: '/static/js/app/'
}).use(['user'], function () {
	var user = layui.user({userId:userId});
	user.changePassword(1);
	console.log(userId);
});


