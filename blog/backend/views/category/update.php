<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\user */

$this->title = 'Update User: ' . ' ' . $model->cid;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cid, 'url' => ['view', 'id' => $model->cid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'models' => $models,
        'catetags'=>$catetags

    ]) ?>

</div>
