var app= angular.module('userApp',['commonApp']);
var ajaxdata;
app.controller('userController',['$scope','$http','gridDataService',function($scope,$http,gridDataService){

	gridDataService.success(function(data){
		$scope.datas = data;
	});
	$scope.rowdatas = [];
	
$scope.$watch('rowdatas',function(newVal,oldVal){
		if(newVal.length==0){
			$scope.isAll = true;
		}
},true);


$("#update").click(function () {
			if(getSelectedIds($scope.rowdatas).length>1){
			alert('只能选择一条数据操作');
		}else if(getSelectedIds($scope.rowdatas).length ==0){
			alert('请选中一条数据修改');
		}else{
			var id = getSelectedId($scope.rowdatas);
			$(this).attr('href','/backend/web/index.php?r=user%2Fupdate&id='+id);
		}
});

	
}]);//控制器代码结束

app.factory('gridDataService',['$http',function ($http) {
	return $http.get('/backend/web/index.php?r=user/take');
}]);
