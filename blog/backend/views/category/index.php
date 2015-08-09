<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\categorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/*$this->title = 'categorys';
$this->params['breadcrumbs'][] = $this->title;*/
//	$data = $this->context->getData();

?>

<div class="category-index" ng-controller='categoryController'>
    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <div style="margin: 0;padding: 0;">
        <?= Html::a('新增', ['create'], ['class' => 'btn btn-success']) ?>
        <a id="update" class="btn btn-primary" href="#">修改</a>
        <a id="delete" class="btn btn-danger" href="#">删除</a>
        <!--<?= Html::a('刪除', ['delete'], ['class' => 'btn btn-danger']) ?>-->
        <input id='input-search' class="form-control"  placeholder="请输入名称或别名" style='display:inline-block;width:200px;'>
        <a id="search" class="btn btn-info" href="#">查询</a>
    </div>

	<table class="table table-bordered table-condensed table-hover">
		<thead>
			<tr>
				<th style="width: 15px;"></th>
				<th style="width: 20px;"><input type="checkbox" id="selectAll"></th>
				
				<th><?= $sort->link('name')?></th>
				<th><?= $sort->link('slug')?></th>
				<th><?= $sort->link('total')?></th>
				<th><?= $sort->link('pid')?></th>
			</tr>
		</thead>
		<tbody class="tbody">
			
			<?php foreach($models as $key=>$rowdata):?>
			
			<tr onclick="selectRow(<?= $rowdata[category_id]?>)">
				<td><?= ($pagination->page)*($pagination->defaultPageSize)+($key+1)?></td>
				<td><input type="checkbox" autocomplete="off" onclick="selectRow(<?= $rowdata['category_id']?>)"></td>
				
				<td><?= $rowdata['name']?></td>
				<td><?= $rowdata['slug']?></td>	
				<td><?= $rowdata['total']?></td>
				<?php 
					
						if($rowdata['pid']==0){
							echo "<td>无</td>";
						}else{
							for($i=0;$i<count($models2);$i++){
								if($models2[$i]['category_id']==$rowdata['pid'])
									echo "<td>{$models2[$i]['name']}</td>";
							}
						}
					
				?>
				
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

	



