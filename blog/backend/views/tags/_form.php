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
	<?= $form->field($models, 'name')->textInput(['maxlength' => 255]) ?>
	<?= $form->field($models, 'slug')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">   	
        <?= Html::submitButton($models->isNewRecord ? '新增' : '修改', ['name'=>'submit','class' => $models->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('取消', ['index'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
