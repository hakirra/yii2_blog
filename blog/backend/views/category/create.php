<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\user */

//$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create" style="height:100%;">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'models' => $models,
        'catetags'=>$catetags
    ]) ?>

</div>
