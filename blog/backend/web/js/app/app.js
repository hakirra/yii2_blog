$("#update").click(function () {
	   if(ids.length>1){
			alert('只能选择一条数据操作');
		}else if(ids.length ==0){
			alert('请选中一条数据修改');
		}else{
			var id = ids[0];
			$(this).attr('href','/backend/web/index.php?r=user%2Fupdate&id='+id);
		}
});

$("#delete").click(function () {
	
	if(ids.length ==0){
		alert('请选择要删除的数据');
	}else{
		var btnkey = confirm('您确定要删除选中的数据吗');
		if(btnkey){
			$(this).attr('href','/backend/web/index.php?r=user/delete&id='+ids);
		}
			
	}
});

$("#search").click(function () {
	var param = $.trim($("#input-search").val());
	$(this).attr('href','/backend/web/index.php?r=user/index&username='+param);
});









