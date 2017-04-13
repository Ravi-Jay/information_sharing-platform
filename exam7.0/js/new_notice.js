
 
window.onload = function () {
	var send = document.getElementById('send');
	var cancel = document.getElementById('cancel');
	
	var ubb = document.getElementById('ubb');
	var fm = document.getElementById('form1');
	var font = document.getElementById('font');
	var color = document.getElementById('color');
	var html = document.getElementsByTagName('html')[0];

	
	cancel.onclick = function () {
		history.go(-1);
	};
	send.onclick = function () {
		if (confirm('您确定要创建该帖吗？')) {
			fm.action='?action=create';
			fm.submit();		
		}
	};
	
	if (fm != undefined) {
		fm.onsubmit = function () {
			if (fm.name.value.length < 2 || fm.name.value.length > 40) {
				alert('标题不得小于2位或者大于40位');
				fm.name.value = ''; //清空
				fm.name.focus(); //将焦点以至表单字段
				return false;
			}
			if (fm.message.value.length < 10) {
				alert('内容不得小于10位');
				fm.message.value = ''; //清空
				fm.message.focus(); //将焦点以至表单字段
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
	}
	
	
	
	function content(string) {
		fm.message.value += string; 
	}

};


function centerWindow(url,name,height,width) {
	var left = (screen.width - width) / 2;
	var top = (screen.height - height) / 2;
	window.open(url,name,'height='+height+',width='+width+',top='+top+',left='+left);
}
function font(size) {
	document.getElementsByTagName('form')[1].message.value += '[size='+size+'][/size]'
};

function showcolor(value) {
	document.getElementsByTagName('form')[1].message.value += '[color='+value+'][/color]'
};


