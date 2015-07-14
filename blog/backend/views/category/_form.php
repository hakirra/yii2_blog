<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\user */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
	
</style>
<div class="user-form">
	
    <?php $form = ActiveForm::begin(); ?>
	<?= $form->field($models['cate'], 'name')->textInput(['maxlength' => 255]) ?>
	<?= $form->field($models['cate'], 'slug')->textInput(['maxlength' => 255]) ?>
	<div class="form-group">
		
		<label class="control-label" >父节点</label>
	<select id="catetags-cate_id" class="form-control" name="CateTags[cate_id]">
		<!--<option value=""><?=$models['tags']['cate_id']?></option>-->
		<?php 
			foreach($catetags as $cate){
				if($cate['cid']==$models['tags']['pid']){
					$selected = 'selected';
				}else{
					$selected = '';
				}
				
				if($cate['pid']!=$models['tags']['cate_id']&&$cate['cid']!=$models['tags']['cate_id']){
					$strpad = str_pad('', intval($cate['pid'])*12,"&nbsp;",STR_PAD_LEFT);
					echo "<option value='{$cate[cate_id]}' $selected>{$strpad}{$cate['name']}</option>";
				}
				
			}		
		?>
	</select>
</div>
    <div class="form-group">   	
        <?= Html::submitButton($models['cate']->isNewRecord ? '新增' : '修改', ['name'=>'submit','class' => $models['cate']->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('取消', ['index'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
