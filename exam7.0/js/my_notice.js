window.onload = function () {
	var all = document.getElementById('all');
	var fm = document.getElementById('form1');
	all.onclick = function () {
		for (var i=0;i<fm.elements.length;i++) {
			if (fm.elements[i].name!='chkall') {
				fm.elements[i].checked = fm.chkall.checked;
			}
		}
	};
	fm.onsubmit = function () {
		if (confirm('确定要删除这批短信？')) {
			return true;
		} 
		return false;
	};
};