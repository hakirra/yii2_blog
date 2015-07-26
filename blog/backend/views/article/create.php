<?php

use yii\helpers\Html;

?>
<div class="article-create">
	 <!-- 配置文件 -->
    <script type="text/javascript" src="/backend/ueditor/ueditor.config.js"></script>
     <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/backend/ueditor/ueditor.all.min.js"></script>
     <script type="text/javascript" src="/backend/ueditor/lang/zh-cn/zh-cn.js"></script>

    <?= $this->render('_form', [
        'models' => $models,
        'catetags'=>$catetags
    ]) ?>

</div>
