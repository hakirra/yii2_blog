<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="user-index" ng-controller='userController'>
    <div style="margin: 0;padding: 0;">
        <?= Html::a('新增', ['create'], ['class' => 'btn btn-success']) ?>
        <a id="update" class="btn btn-primary" href="#">修改</a>
        <a id="delete" class="btn btn-danger" href="#">删除</a>
        <!--<?= Html::a('刪除', ['delete'], ['class' => 'btn btn-danger']) ?>-->
        <input id='input-search' class="form-control"  placeholder="请输入用户名" style='display:inline-block;width:200px;'>
        <a id="search" class="btn btn-info" href="#">查询</a>
    </div>

	<table class="table table-bordered table-condensed table-hover">
		<thead>
			<tr>
				<th style="width: 15px;"></th>
				<th style="width: 20px;"><input type="checkbox" id="selectAll"></th>
				<th><?= $sort->link('id')?></th>
				<th><?= $sort->link('username')?></th>
				<th><?= $sort->link('email')?></th>
				<th><?= $sort->link('status')?></th>
				<th><?= $sort->link('login_time')?></th>
				<th><?= $sort->link('ip_addr')?></th>
			</tr>
		</thead>
		<tbody class="tbody">
			
			<?php foreach($models as $key=>$rowdata):?>
			
			<tr onclick="selectRow(<?= $rowdata[id]?>)">
				<td><?= ($pagination->page)*($pagination->defaultPageSize)+($key+1)?></td>
				<td><input type="checkbox" autocomplete="off" onclick="selectRow(<?= $rowdata[id]?>)"></td>
				<td><?= $rowdata[id]?></td>
				<td><?= $rowdata[username]?></td>
				<td><?= $rowdata[email]?></td>
				<td><?= $rowdata[status]?'启用':'禁用'?></td>
				<td><?= $rowdata[login_time]?date('Y-m-d H:i',$rowdata[login_time]):''?></td>
				<td><?= $rowdata[ip_addr]?></td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	 <div class="text-right" >
            <div  style="position:relative;right:10px;">
            	
            	<?= LinkPager::widget(['pagination' => $pagination,'firstPageLabel'=>'首页','lastPageLabel'=>'末页','maxButtonCount'=>7]) ?>
            </div>           
    </div>
    
</div>

	


