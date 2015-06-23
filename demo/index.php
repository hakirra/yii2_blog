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
				<th></th>
				<th><input type="checkbox"></th>
				<th>ID</th>
				<th>用户名</th>
				<th>邮箱</th>
				<th>状态</th>
				<th>最后登录时间</th>
				<th>最后登录IP</th>
			</tr>
		</thead>
		<tbody>
			
			<?php foreach($models as $key=>$rowdata):?>
			
			<tr select-row>
				<td><?=$key+1?></td>
				<td><input type="checkbox"></td>
				<td><?= $rowdata[id]?></td>
				<td><?= $rowdata[username]?></td>
				<td><?= $rowdata[email]?></td>
				<td><?= $rowdata[status]?'启用':'禁用'?></td>
				<td><?= date('Y-m-d H:i',$rowdata[login_time])?></td>
				<td><?= $rowdata[ip_addr]?></td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	
	 <div class="text-right" >
            <ul id="pagination"  style="position:relative;right:10px;"></ul>
    </div>
</div>

	


