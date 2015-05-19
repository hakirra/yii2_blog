<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
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
    <!--<title><?= Html::encode($this->title) ?></title>-->
    <?php $this->head() ?>
</head>
<body ng-app='userApp'>
    <?php $this->beginBody() ?>
    <div class="wrap">
    	 <?= $content ?>     
    </div>
      <?php $this->endBody() ?>
     </body>
</html>
<?php $this->endPage() ?>