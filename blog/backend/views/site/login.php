<?php
use yii\bootstrap\ActiveForm;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style type="text/css" media="screen">
        *{margin: 0;padding: 0}
        input{padding:10px;display: block;margin: 10px auto;}
    </style>
</head>
<body style="overflow:hidden;">
    <div style="height:450px;width:100%;background:#008EAD"></div>
    <div style="background:white;width:500px;height:220px;position:absolute;top:300px;left:450px;">
    	<!--<form action="/backend/web/index.php?r=site/login" method="post">	-->
    		<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    	
        <input type="text" name="LoginForm[username]" value="" placeholder="用户名">   
        <input type="password" name="LoginForm[password]" value="" placeholder="密码"> 
        <!--<input type="hidden" name="LoginForm[rememberMe]" value="0">-->
        <!--<?= $form->field($model, 'rememberMe')->checkbox() ?>-->
        <input type="submit" name="LoginForm[submit]" value="登录" style="padding:10px 74px;color:white;background:#31B000;border:none">
        <!--</form>--> 
         <?php ActiveForm::end(); ?>
    </div>

</body>
</html>