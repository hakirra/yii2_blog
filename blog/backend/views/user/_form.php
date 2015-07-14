<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\user */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
	<?= $form->field($model, 'username')->textInput(['maxlength' => 255,'autocomplete'=>'off']) ?>
	<?= $form->field($model, 'password_hash')->passwordInput() ?>
	<?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>
	<?= $form->field($model, 'status')->radioList([1=>'启用',0=>'禁用'])?>

    <div class="form-group">
 
        <?= Html::submitButton($model->isNewRecord ? '新增' : '修改', ['name'=>'submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('取消', ['index'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
