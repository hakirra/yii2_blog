<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="stylesheet" type="text/css" href="../../../frontend/web/css/iconfont.css"/>-->
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body style="overflow-x: hidden">
    <?php $this->beginBody() ?>
    <div class="wrap">

		<header class="mui-bar mui-bar-nav" style="background-color: #438EB9;">
			<a href="<?= Yii::$app->homeUrl?>" class="mui-icon mui-action-back mui-icon-left-nav mui-pull-left" style="color: white;">简易博客系统</a>

			<div class="mui-pull-right"style="color: white;padding-top:10px ;">
				<span><?=date('Y-m-d') ?></span>
				<a href="<?=Yii::$app->request->absoluteUrl.'?r=site/logout'?>" title="退出" style='color: white;'><span><?=Yii::$app->user->identity->username ?></span></a>
			</div>
		</header>
        <div class="custom-container">
        <!--<?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>-->
        <?= $content ?>
        </div>
    </div>



    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
