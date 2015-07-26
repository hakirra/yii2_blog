<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
.article-form{background: #F2F2F2;}
.tdlable{width: 60px !important;text-align: center;}
/*.tdinput{float: left;}*/
.tdinput>input{margin: 0 !important;}
.left-form{width:70%;float: left;}
.right-form{background: '';float: left;width: 28%;}
.postbox{
position: relative;
min-width: 255px;
border: 1px solid #DED8D8;
box-shadow: 0 1px 1px rgba(0,0,0,.04);
background: #fff;
margin-bottom: 20px;
padding: 0;
line-height: 1;
}
.postbox h3 {
font-size: 14px;
padding: 8px 12px;
margin: 0;
line-height: 1.4;
border-bottom: 1px solid #DED8D8;
}
.inside {
padding: 0 12px 12px;
line-height: 1.4em;
font-size: 13px;
}
div.checkcate{height: 24px;}
div.checkcate input{vertical-align: middle;}
.inside span{margin-left: 5px;display: inline-block;height: 24px;
line-height: 24px;
vertical-align: middle;}
.inside label{font-weight: normal;cursor: pointer;}
.taglist input{display: inline-block;}
.tag-text{width: 190px !important;height: 34px !important;}
.taglist a{
cursor: pointer;
width: 18px;
height: 18px;
border-radius: 50%;
vertical-align: middle;
display: inline-block;
margin-right: 6px;
overflow: hidden;
background: #b4b9be;
}
.taglist a:before{
content: '\2716';
margin-top: -2px;
display: block;
text-align: center;
background: 0 0;
color: #fff;
}
.taglist{
font-size: 12px;
/*overflow: auto;*/
margin-top: 5px;
display:block;
width: 190px;
}
.taglist span{
width: auto;
margin-right: 5px;
margin-left: 0 !important;
display: inline-block !important;
font-size: 13px;
line-height: 1.8em;
cursor: default;
max-width: 100%;
overflow: hidden;
text-overflow: ellipsis;
}
.taglist a:hover{background: #CC0000;}
</style>
	 <!-- 配置文件 -->
    <script type="text/javascript" src="/backend/ueditor/ueditor.config.js"></script>
     <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/backend/ueditor/ueditor.all.min.js"></script>
     <script type="text/javascript" src="/backend/ueditor/lang/zh-cn/zh-cn.js"></script>
      <script type="text/javascript">
      	window.onload=function () {
         var ue = UE.getEditor('content',{'initialFrameHeight':'400','initialFrameWidth':'100%'});
         	$("button[type=submit]").on('click',function () {
         		
         		if($("input[name='title']").val() ==''){
         			$("#title-error").css({'display':'block','color':'red'});
         			return false;
         		}else{
         			
         			$("#title-error").css('display','none');
         		}
         		
         		if(!ue.hasContents()){
         			$("#content-error").css({'display':'block','color':'red'});
         			return false;
         		}
         		
         		$(".hidden-text").val(tagarr);
         			
         	});
         /**
          * 添加标签代码
          */
         	var tagarr = [];
		        $(".taglist").delegate('a','click',function(){
					$(this).parent().remove();
					tagarr.remove($.trim($(this).parent().text()));
				});
				$(".add-btn").click(function(){
					var val = $.trim($(".tag-text").val());
					if(val.indexOf(',')!=-1){
						var arr = val.split(',');
						for(var i=0;i<arr.length;i++){
							tagarr.push(arr[i]);
							var obj = $("<span><a ></a>"+arr[i]+"</span>");
							$(".taglist").append(obj);
						}
					}else{
						if(tagarr.indexOf(val)==-1 && val !=''){
							tagarr.push(val);
							var obj = $("<span><a ></a>"+val+"</span>");
							$(".taglist").append(obj);
						}
						
					}
					$(".tag-text").val('').focus();
				});
      	}
  		</script>
<div class="article-form">
    <?php $form = ActiveForm::begin(); ?>
 <div class="left-form">
  	<table class="table table-condensed">  		 
   		<tr>
   			<td class="tdlable"><span style="color: red;">*&nbsp;</span>标题</td>
   			<td class="tdinput"><input type="text" name="Article[title]" /><span id="title-error" style="display: none;">标题必填</span></td>	
   		</tr>
   	
   		<tr>
   			<td class="tdlable">关键字</td>
   			<td class="tdinput"><input type="text" name="Article[keywords]"/>多关键词之间用空格或者“,”隔开</td>
   		</tr>
   	
   		<tr>
   			<td class="tdlable">摘要</td>
   			<td class="tdinput"><textarea cols="10" rows="3" name="Article[excerpt]"></textarea></td>
   		</tr>
   		<tr>
   			<td class="tdlable"><span style="color: red;">*&nbsp;</span>内容</td>
   			<td class="tdinput">
   				<textarea name="Article[content]" id="content"></textarea>
   				<span id="content-error"  style="display: none;">内容必填</span>
   			</td>   			
   		</tr>

   	</table>
 
  <div class="form-group">
        <button type="submit" class="btn btn-success">新增</button>        
        <a class="btn btn-primary" href="/backend/web/index.php?r=article%2Findex">取消</a> 
   </div>
</div>
<div class="right-form">
	<div class="postbox">
		<h3 class="hndle ui-sortable-handle"><span>分类目录</span></h3>
		<div class="inside">
		<?php
			foreach($catetags as $cate){	
				$strpad = str_pad('', intval($cate['level'])*18,"&nbsp;",STR_PAD_LEFT);
			echo "<div class='checkcate'><label>{$strpad}<input type='checkbox' value={$cate['category_id']} name='post_category[]'/><span>{$cate['name']}</span></label></div>";
							
			}	
		?>
		</div>
	</div>
	<div class="postbox">
		<h3 class="hndle ui-sortable-handle"><span>评论状态</span></h3>
		<div class="inside">
			<?= $form->field($models['article'], 'comment_status')->radioList(['open'=>'启用','close'=>'禁用'])?>
		</div>
	</div>
	<div class="postbox">
		<h3 class="hndle ui-sortable-handle" style="margin-bottom: 10px;"><span>标签</span></h3>
		<div class="inside">
			<p style="margin-top: 10px !important;">
				<input type="text" class="tag-text"/> 
				<input type="hidden" name="Article[tags]" class="hidden-text"/> 
				<input type="button" value="添加" class="add-btn"/>
			</p>
			
			<p style="margin-top: -10px;margin-bottom: 0;">多个标签请用英文逗号(,)隔开</p>
			<div class="taglist"></div>
		</div>
	</div>
</div>
    <?php ActiveForm::end(); ?>

</div>


