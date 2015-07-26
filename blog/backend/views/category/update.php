<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\user */

$this->title = 'Update User: ' . ' ' . $models->category_id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $models->category_id, 'url' => ['view', 'id' => $models->category_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'models' => $models,
        'catetags'=>$catetags

    ]) ?>

</div>
