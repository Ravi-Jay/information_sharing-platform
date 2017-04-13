/**
 * 返回列表、删除短信
 */
 
 window.onload = function () {
	var ret = document.getElementById('back');
	var del = document.getElementById('delete');
	ret.onclick = function () {
		history.go(-1);
		document.getElementById('img1').src="images/readed.png";
	};
	del.onclick = function () {
		if (confirm('您确定要删除该短信吗？')) {
			location.href='?action=delete&id='+this.name;
		}
	};
};