<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Article */


?>
<div class="article-update">

    <?= $this->render('_form', [
        'models' => $models,
        'catetags'=>$catetags,
        'cateinfo'=> $cateinfo,
        'taginfo'=>$taginfo
    ]) ?>

</div>
