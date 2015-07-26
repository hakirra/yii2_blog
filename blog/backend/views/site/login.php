<?php
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
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
    
    		<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    	
        <input type="text" name="LoginForm[username]"  placeholder="用户名" autocomplete='off'>   
        <input type="password" name="LoginForm[password]" placeholder="密码" autocomplete='off'> 

        <input type="submit" name="LoginForm[submit]" value="登录" style="padding:10px 74px;color:white;background:#31B000;border:none">
        
         <?php ActiveForm::end(); ?>
    </div>

</body>
</html>