<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/*$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;*/
//	$data = $this->context->getData();
?>
<style>
	.orderColor{color:red;}
</style>
<div class="user-index" ng-controller='userController'>
    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <div style="margin: 0;padding: 0;">
        <?= Html::a('新增', ['create'], ['class' => 'btn btn-success']) ?>
        <!--<?= Html::a('修改', ['update'], ['class' => 'btn btn-primary','id'=>'update']) ?>-->
        <a id="update" class="btn btn-primary" href="#">修改</a>
        <a id="delete" class="btn btn-danger" href="#">删除</a>
        <!--<?= Html::a('刪除', ['delete'], ['class' => 'btn btn-danger']) ?>-->
        <input id='search' class="form-control"  ng-model="searchtext" placeholder="请输入公司名" style='display:inline-block;width:200px;'>
        
    </div>
    
	<table class="table table-bordered">
		<thead>
		<tr>
			<th style="width: 15px;"></th>
			<th style="width: 20px;"><input type="checkbox" ng-click="getAll()" get-all ng-checked="!isAll" autocomplete="off"> </th>
			<th ng-class="{dropup:order==''}" order-col="id">
				ID<span class="caret" ng-class="{orderColor:orderType=='id'}"></span>
			</th>
			<th ng-class="{dropup:order==''}" order-col="username">
				用户名<span class="caret" ng-class="{orderColor:orderType=='username'}"></span>
			</th>
			<th ng-class="{dropup:order==''}" order-col="email">
				邮箱<span class="caret" ng-class="{orderColor:orderType=='email'}"></span>
			</th>
			<th ng-class="{dropup:order==''}" order-col="status">
			     状态<span class="caret" ng-class="{orderColor:orderType=='status'}"></span>
			</th>
			<th ng-class="{dropup:order==''}" order-col="login_time">
				最后登录时间<span class="caret" ng-class="{orderColor:orderType=='login_time'}"></span>
			</th>
			<th ng-class="{dropup:order==''}" order-col="ip_addr">
				最后登录ip地址<span class="caret" ng-class="{orderColor:orderType=='ip_addr'}"></span>
		   </th>
		</tr>
		</thead>
		<tbody>
			<tr ng-repeat="obj in datas|limitTo:2| orderBy:order + orderType" ng-click="loadRow($index,obj)" select-row ng-class="{info:obj.bool}">
				<td ng-bind="$index + 1"></td>
				<td><input type="checkbox" ng-checked="obj.bool" ng-model="obj.bool" change-bool ng-click="changeBool(obj,$event)" autocomplete="off"></td>
				<td ng-bind="obj.id"></td>
				<td ng-bind="obj.username"></td>
				<td ng-bind="obj.email"></td>
				<td ng-bind="obj.status==1?'启用':'禁用'"></td>
				<td ng-bind="obj.login_time?obj.login_time+'000':obj.login_time|date:'y-MM-d H:mm:ss'"></td>
				<td ng-bind="obj.ip_addr"></td>
			</tr>
		</tbody>

	</table>
	
	 <div class="text-right" >
            <ul id="pagination"  style="position:relative;right:10px;"></ul>
    </div>
</div>

	


