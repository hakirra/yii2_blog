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
<style>
	.orderColor{color:red;}
</style>
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
    
	<table class="table table-bordered">
		<thead>
			<tr>
				<th style="width: 15px;"></th>
				<th style="width: 20px;"><input type="checkbox" id="selectAll"></th>
				<th><?= $sort->link('cid')?></th>
				<th><?= $sort->link('name')?></th>
				<th><?= $sort->link('slug')?></th>
				<th><?= $sort->link('total')?></th>
				
			</tr>
		</thead>
		<tbody>
			
			<?php foreach($models as $key=>$rowdata):?>
			
			<tr onclick="selectRow(<?= $rowdata[id]?>)">
				<td><?= ($pagination->page)*($pagination->defaultPageSize)+($key+1)?></td>
				<td><input type="checkbox" autocomplete="off" onclick="selectRow(<?= $rowdata[id]?>)"></td>
				<td><?= $rowdata[id]?></td>
				<td><?= $rowdata['name']?></td>
				<td><?= $rowdata['slug']?></td>	
				<td><?= $rowdata['total']?></td>
				
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
<script>
var ids =[];//存放所有选中行的id
function selectRow(id) {
		
		if(ids.indexOf(id) ==-1){
			ids.push(id);
		}else{
			ids.remove(id);
		}
}
	window.onload=function () {	
		var isAll;
		$("#selectAll").click(function () {
		
			if(!isAll){
					$.ajax({
						url:"<?=Yii::$app->request->baseUrl.'/index.php?'?>"+'r=category/take&offset='+<?=($pagination->page)*($pagination->defaultPageSize)?>,
						async:false,
						success:function (data) {
							if(data instanceof Array)
								ids = getSelectedIds(data);		
						}
					});
					
				$(":checkbox").each(function (i) {
					$(this).prop('checked',true);
					$("tbody>tr").addClass('info');
				});
				isAll = true;
			}else{
				ids.length = 0;
				$(":checkbox").each(function (i) {
					$(this).prop('checked',false);
					$("tbody>tr").removeClass('info');
				});
				isAll = false;
			}		
		});//全选结束
		
		$("tbody input:checkbox").click(function (e) {
			var evt = e ? e : window.event; 
			if(evt.stopPropagation){
				evt.stopPropagation();
			}else{
				evt.cancelBubble = true; 
			}
			$(this).parent().parent().toggleClass('info');	
		});
		$("tbody>tr").on('click',function () {		
			var box = $(this).find("input:checkbox");
			$(this).toggleClass('info');
			box.prop('checked',!box.prop('checked'));	
		});
		
		$("#update").click(function () {
	   if(ids.length>1){
			alert('只能选择一条数据操作');
		}else if(ids.length ==0){
			alert('请选中一条数据修改');
		}else{
			var id = ids[0];
			$(this).attr('href',"<?=Yii::$app->request->baseUrl.'/index.php?'?>"+'r=category/update&id='+id);
		}
	});

		$("#delete").click(function () {
			
			if(ids.length ==0){
				alert('请选择要删除的数据');
			}else{
				var btnkey = confirm('您确定要删除选中的数据吗');
				if(btnkey){
					$(this).attr('href',"<?=Yii::$app->request->baseUrl.'/index.php?'?>"+'r=category/delete&id='+ids);
				}
					
			}
		});
		
		$("#search").click(function () {
			var param = $.trim($("#input-search").val());
			$(this).attr('href',"<?=Yii::$app->request->baseUrl.'/index.php?'?>"+'r=category/index&name='+param);
		});
	
}
	

		

</script>
	



