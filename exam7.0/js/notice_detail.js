window.onload = function () {

	var ubb = document.getElementById('ubb');
	var fm = document.getElementById('form1');
	var font = document.getElementById('font');
	var color = document.getElementById('color');
	var html = document.getElementsByTagName('html')[0];

	
	if (fm != undefined) {
		fm.onsubmit = function () {
			if (fm.title.value.length < 2 || fm.title.value.length > 40) {
				alert('标题不得小于2位或者大于40位');
				fm.title.value = ''; //清空
				fm.title.focus(); //将焦点以至表单字段
				return false;
			}
			if (fm.cont.value.length < 10) {
				alert('内容不得小于10位');
				fm.cont.value = ''; //清空
				fm.cont.focus(); //将焦点以至表单字段
				return false;
			}
			return true;
		};
	}
	
	

	if (font != null) {
		html.onmouseup = function () {
			font.style.display = 'none';
			color.style.display = 'none';
		};
	}
	
	if (ubb != null) {
		var ubbimg = ubb.getElementsByTagName('img');
		ubbimg[0].onclick = function() {
			font.style.display = 'block';
		};
		ubbimg[2].onclick = function () {
			content('[b][/b]');
		};
		ubbimg[3].onclick = function () {
			content('[i][/i]');
		};
		ubbimg[4].onclick = function () {
			content('[u][/u]');
		};

		ubbimg[6].onclick = function() {
			color.style.display = 'block';
			fm.t.focus();
		};
		ubbimg[7].onclick = function () {
			var url = prompt('请输入网址：','http://');
			if (url) {
				if (/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+/.test(url)) {
					content('[url]'+url+'[/url]');
				} else {
					alert('网址不合法！');
				}
			}
		};

		ubbimg[8].onclick = function () {
			centerWindow('photo_up.php?dir=photo/notice','photo_up',250,400);
		};

		ubbimg[14].onclick = function () {
			fm.cont.rows += 2;
		};
		ubbimg[15].onclick = function () {
			fm.cont.rows -= 2;
		};
	}
	
	
	
	function content(string) {
		fm.cont.value += string; 
	}
	
	if (fm != undefined) {
		fm.t.onclick = function () {
			showcolor(this.value);
		}
	}
	
	var message = document.getElementsByName('message');
	var friend = document.getElementsByName('friend');
	var _delete = document.getElementsByName('delete');
	var delete1 = document.getElementsByName('delete1');
	var modify = document.getElementsByName('modify');
	
	
	for (var i=0;i<modify.length;i++) {
		modify[i].onclick = function () {
			location.href='notice_modify.php?'+this.title;
		};
	}
	for (var i=0;i<message.length;i++) {
		message[i].onclick = function () {
			centerWindow('message.php?id='+this.title,'message',250,400);
		};
	}
	for (var i=0;i<friend.length;i++) {
		friend[i].onclick = function () {
			if(confirm('您确定要关注此人吗？')){
				location.href='notice_detail.php?'+this.title;			
			}
		};
	}
	for (var i=0;i<delete1.length;i++) {
		delete1[i].onclick = function () {
			if(confirm('您确定要删除本帖吗？')){
				location.href='notice_detail.php?'+this.title;			
			}
		};
	}
	for (var i=0;i<_delete.length;i++) {
		_delete[i].onclick = function () {
			if(confirm('您确定要删除该回复吗？')){			
				location.href='notice_detail.php?'+this.title;
			}
		};
	}
};

function centerWindow(url,name,height,width) {
	var left = (screen.width - width) / 2;
	var top = (screen.height - height) / 2;
	window.open(url,name,'height='+height+',width='+width+',top='+top+',left='+left);
}

function font(size) {
	document.getElementsByTagName('form')[1].cont.value += '[size='+size+'][/size]'
};

function showcolor(value) {
	document.getElementsByTagName('form')[1].cont.value += '[color='+value+'][/color]'
};

