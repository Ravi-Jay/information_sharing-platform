/**
 * 
 */
window.onload = function () {
	var _delete = document.getElementsByName('delete');
	for (var i=0;i<_delete.length;i++) {
		_delete[i].onclick = function () {
			if(confirm('您确定要从此列表删除该用户吗？')){			
				location.href='admin_users.php?'+this.title;
			}
		};
	}
	var add = document.getElementById('add');
	add.onclick=function(){
		location.href='reg_adm.php?'+this.title;
	}

};