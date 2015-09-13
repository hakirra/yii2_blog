<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/*$this->title = 'categorys';
$this->params['breadcrumbs'][] = $this->title;*/
//	$data = $this->context->getData();

?>
<style>
	.tbar-ul{
		list-style: none;
		margin: 8px 30px 0 0; 
		padding: 0;
		font-size: 13px;
		float: left;
		color: #666;
	}
	.tbar-ul>li {
		display: inline-block;
		margin: 0;
		padding: 0;
		white-space: nowrap;
}
.tbar-ul a {
line-height: 2;
padding: .2em;
text-decoration: none;}
.tbar-ul .active{color: black;font-weight: 600 ;}
.line{display: inline-block;height: 12px;border: 1px solid gray;vertical-align: middle;margin: 0 5px 3px 5px;}
#search-form{display: inline;vertical-align: middle;}
</style>
<div class="category-index" ng-controller='categoryController'>
 
 	<div style="margin: 0;padding: 0;" id="tool-bar">
	        <?= Html::a('新增', ['create'], ['class' => 'btn btn-success']) ?>
		<?= Html::a('测试', ['take'], ['class' => 'btn btn-success']) ?>
	        <a id="update" class="btn btn-primary" href="#">修改</a>
	        <a id="delete" class="btn btn-danger" href="#">删除</a>
	        <?php $form = ActiveForm::begin(['id'=>'search-form']); ?>
	      	<!--<form action="<?=Url::to(['article/index'])?>" method="get" id="search-form">-->
	        <input id='input-search' class="form-control"  name='title' autocomplete="off" placeholder="请输入文章标题查询" style='display:inline-block;width:200px;'>
	        <!--</form>-->
	        <?php ActiveForm::end(); ?>
	        <a id="search" class="btn btn-info" href="#">查询</a>
	       
	        	<ul class="tbar-ul">
	        		<li >
	        			<a class="<?= $class['total']?>" href="<?= Yii::$app->request->baseUrl.'/index.php?r=article' ?>">全部(<?=$branchinfo['total']?>)</a><span class="line"></span>
	        		</li>
	        		<li>
	        			<a class="<?= $class['top']?>" href="<?= Yii::$app->request->baseUrl.'/index.php?r=article&istop=1' ?>">置顶(<?=$branchinfo['top']?>)</a><span class="line"></span>
	        		</li>
	        		<li>
	        			<a class="<?= $class['private']?>" href="<?= Yii::$app->request->baseUrl.'/index.php?r=article&post_password=true'?>">私密(<?=$branchinfo['private']?>)</a>
	        		</li>
	        	</ul>
	     
	    </div>
  
  		<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th style="width: 15px;"></th>
				<th style="width: 20px;"><input type="checkbox" id="selectAll"></th>
				
				<th><?= $sort->link('title')?></th>
				<th><?= $sort->link('author_name')?></th>
				<th>分类目录</th>
				<th>标签</th>
				<th><?= $sort->link('comment')?></th>
				<th><?= $sort->link('created')?></th>
			</tr>
		</thead>
		<tbody class="tbody">
			
			<?php foreach($models as $key=>$rowdata):?>
				
			<tr onclick="selectRow(<?= $rowdata['article_id']?>)">
				<td><?= ($pagination->page)*($pagination->defaultPageSize)+($key+1)?></td>
				<td><input type="checkbox" autocomplete="off" onclick="selectRow(<?= $rowdata['article_id']?>)"></td>
				
				<td><?= $rowdata['post_password']?$rowdata['title'].'&nbsp;—&nbsp;<b>密码保护</b>':$rowdata['title']?></td>
				<td><?= $rowdata['author_name']?></td>	
				<td>
				<?php
				  $str ='';
					foreach($rowdata['category'] as $val)
					{
					  if($val['catetags']=='category')
							$str.=$val['name'].'、';				
					} 
				 	echo $str = rtrim($str,'、');
				 ?>
				 </td>
				<td>
				<?php
				  $str ='';
					foreach($rowdata['category'] as $val)
					{
					  if($val['catetags']=='tags')
							$str.=$val['name'].'、';	 
					} 
					if(!$str)
						echo '—';
					else echo $str = rtrim($str,'、');
				 ?>
				</td>
				<td><?= $rowdata['comment_total']?></td>
				<td><?= date('Y-m-d',$rowdata['created'])?></td>
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

	



