window.onload = function () {
	var message = document.getElementsByName('message');//发消息
	for (var i=0;i<message.length;i++) {
		message[i].onclick = function () {
			window.open('sender.php?id='+this.title,'sender');
		};
	}
	var home = document.getElementsByName('home');//访问用户的主页
	for (var i=0;i<home.length;i++) {
		home[i].onclick = function () {
			location.href='?action=home&id='+this.title;
		};
	}
	var deletefriend = document.getElementsByName('deletefriend');//删除好友
	for (var i=0;i<deletefriend.length;i++) {
		deletefriend[i].onclick = function () {
			if(confirm('您确定不再关注此人了吗？')){				
				location.href='?action=delete&id='+this.title;
			}
		};
	}
};
