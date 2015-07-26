<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\user */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
	#catetags-category_id{padding: 6px 0;}
</style>
<div class="user-form">
	
    <?php $form = ActiveForm::begin(); ?>
	<?= $form->field($models, 'name')->textInput(['maxlength' => 255]) ?>
	<?= $form->field($models, 'slug')->textInput(['maxlength' => 255]) ?>
	<div class="form-group">
		
		<label class="control-label" >父节点</label>
	<select id="catetags-category_id" class="form-control" name="Category[category_id]">
		<option value="">无</option>
		
		<?php 
			foreach($catetags as $cate){
				if($cate['category_id']==$models['pid']){
					$selected = 'selected';
				}else{
					$selected = '';
				}
			if($cate['pid']!=$models['category_id']&&$cate['category_id']!=$models['category_id']){
					
					$strpad = str_pad('', intval($cate['level'])*12,"&nbsp;",STR_PAD_LEFT);
					echo "<option value='{$cate[category_id]}' $selected>{$strpad}|-{$cate['name']}</option>";
				}
				
			}		
		?>
	</select>
</div>
    <div class="form-group">   	
        <?= Html::submitButton($models->isNewRecord ? '新增' : '修改', ['name'=>'submit','class' => $models->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('取消', ['index'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
