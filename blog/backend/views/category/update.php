<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\user */


?>
<div class="user-update" style="height:100%;">

    <?= $this->render('_form', [
        'models' => $models,
        'catetags'=>$catetags

    ]) ?>

</div>
