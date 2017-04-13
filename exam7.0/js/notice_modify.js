 window.onload = function () {
	var send = document.getElementById('send');
	var cancel = document.getElementById('cancel');
	var id = document.getElementById('notice_id');

	cancel.onclick = function () {
		history.go(-1);
	};
	send.onclick = function () {
		if (confirm('您确定要修改该帖吗？')) {
			document.getElementById('form1').action='?id='+id.value+'&action=create';
			document.getElementById('form1').submit();		

		}
	};
};