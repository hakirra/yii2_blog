var common = angular.module('commonApp',[]);

//点击选中or取消行指令
common.directive('selectRow',function(){
	return {
		controller:function($scope){
			$scope.loadRow=function(index,obj){
				obj.bool=!obj.bool;
				if(obj.$$hashKey)
					delete obj.$$hashKey;
				var key = $scope.rowdatas.indexOf(obj);
				if(key==-1){	
					$scope.rowdatas.push(obj);			
				}else{
					$scope.rowdatas.delete(key);
				}
				
			}
		}
	}
});

//辅助指令,点击表格中的checkbox改变其值
common.directive('changeBool',function(){
	return {
		controller:function($scope){
			$scope.changeBool=function(obj,$event){
					if(this.stopPropagation){
				$event.stopPropagation();
			}
			obj.bool = !obj.bool;
			}
		}
	}
});

//grid表格全选/反选指令
common.directive('getAll',['$http','gridDataService',function($http,gridDataService){
	var arr = [];
	gridDataService.success(function (data) {
		if(data.length>0)
			arr = data;
	});
	return {
		controller:function($scope){
		$scope.getAll=function(){
		var eles = angular.element("input[type=checkbox]");
		for (var i = 0; i < eles.length; i++) {
			if((i+1)<eles.length){
				
				if($scope.isAll && !arr[i].bool){//全选
					arr[i].bool = !arr[i].bool;
					$scope.rowdatas  = angular.copy(arr);
				}else if(!$scope.isAll && arr[i].bool){

					arr[i].bool = !arr[i].bool;	
					$scope.rowdatas.length = 0;	
				}
				
			}			
		}
		$scope.isAll = !$scope.isAll;
//		console.log($scope.rowdatas);
	}
		}
	}
}]);

//字段排序指令
common.directive('orderCol',function(){
	return {
		link:function(scope,ele,attr){
			scope.orderType="id";
			scope.order="";
			ele.on('click',function(e){
				scope.$apply(function(){
					scope.orderType = attr.orderCol;
				if(scope.order == '-')
					scope.order ='';
				else
					scope.order = '-';
				})
				
			})
		}
	}
})
