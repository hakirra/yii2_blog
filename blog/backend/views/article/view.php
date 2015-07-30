<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Article */
	

?>
 <!-- 配置文件 -->
    <script type="text/javascript" src="/backend/ueditor/ueditor.config.js"></script>
     <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/backend/ueditor/ueditor.all.min.js"></script>
     <script type="text/javascript" src="/backend/ueditor/lang/zh-cn/zh-cn.js"></script>
<div class="article-view">

<div>
	<?= '@web'?>
</div>
 <?php $form = ActiveForm::begin(); ?>
<!-- <?= $form->field($models['category'], 'category_id')->checkboxList(['0'=>'篮球','1'=>'足球','2'=>'羽毛球','3'=>'乒乓球']) ?>-->
	<?php 
	/*	v($catetags);
		v($info);exit;*/
		

		function customCheckbox($index, $label, $name, $checked, $value){
				
			
			$cid = preg_replace('/-\d+/','',$value);
			$level = preg_replace('/\d+-{1}/','',$value);
			$strpad = str_pad('', intval($level)*18,"&nbsp;",STR_PAD_LEFT);
//			echo "<div class='checkcate'><label>{$strpad}<input type='checkbox' name='category_id[]' value='{$cid}'>{$label}</label></div>";
					
	}
//		v($catetags);exit;
		foreach($catetags as $cate){
//		$sel = array('category_id'=>'3');
//			 echo Html::checkboxList('category_id',$sel,$cate,['item'=>'customCheckbox']);
			$checked = in_array($cate['category_id'], $info) ?'checked':'';

			$strpad = str_pad('', intval($cate['level'])*18,"&nbsp;",STR_PAD_LEFT);
			echo "<div class='checkcate'><label>{$strpad}<input type='checkbox' $checked name='category_id[]' value='{$cate["category_id"]}'>{$cate["name"]}</label></div>";
		}
		
	?>
	
	<!--<?= $form->field($models['article'], 'content')->textarea(['id'=>'content'])->label(false)?>-->
<?php ActiveForm::end(); ?>
 <!--<?= Html::activeTextarea($models['article'],'content',['id'=>'content'])?>-->
</div>
<script>
	
	  var ue = UE.getEditor('content',{'initialFrameHeight':'400','initialFrameWidth':'500'});

</script>

