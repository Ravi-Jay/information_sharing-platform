window.onload = function () {
	var message = document.getElementsByName('message');//发消息
	for (var i=0;i<message.length;i++) {
		message[i].onclick = function () {
			window.open('sender.php?id='+this.title,'sender');
		};
	}
	
	var friend = document.getElementsByName('friend');//加关注
	for (var i=0;i<friend.length;i++) {
		friend[i].onclick = function () {
			if(confirm('您确定要关注该用户吗？')){
				location.href='?action=addfriend&id='+this.title;
			}
		};
	}
	var home = document.getElementsByName('home');//访问用户的主页
	for (var i=0;i<home.length;i++) {
		home[i].onclick = function () {
			location.href='?action=home&id='+this.title;
		};
	}
		
};
