<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
        <?= Html::a('刪除', ['delete'], ['class' => 'btn btn-danger']) ?>
        <input class="form-control" ng-model="search" placeholder="请输入公司名" style='display:inline-block;width:200px;'>
        <?= Html::a('查询', ['seache'], ['class' => 'btn btn-info']) ?>
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
			<th ng-class="{dropup:order==''}" order-col="ip_addr">
				最后登录ip地址<span class="caret" ng-class="{orderColor:orderType=='ip_addr'}"></span>
		   </th>
		</tr>
		</thead>
		<tbody>
			<tr ng-repeat="obj in datas| filter:search | orderBy:order + orderType" ng-click="loadRow($index,obj)" select-row ng-class="{info:obj.bool}">
				<td ng-bind="$index + 1"></td>
				<td><input type="checkbox" ng-checked="obj.bool" ng-model="obj.bool" change-bool ng-click="changeBool(obj,$event)" autocomplete="off"></td>
				<td ng-bind="obj.id"></td>
				<td ng-bind="obj.username"></td>
				<td ng-bind="obj.email"></td>
				<td ng-bind="obj.status==1?'启用':'禁用'"></td>
				<td ng-bind="obj.ip_addr"></td>
			</tr>
		</tbody>
		<!--<?php foreach($userData as $key=>$val):?>
			<tr>
				<td><?=$key+1?></td>
				<td><input type="checkbox"> </td>
				<td><?=$val['id']?></td>
				<td><?=$val['username']?></td>
				<td><?=$val['email']?></td>
				<td><?=$val['status']==1?'启用':'禁用'?></td>
				<td><?=$val['ip_addr']?></td>
			</tr>
		<?php endforeach;?>-->
	</table>

</div>
