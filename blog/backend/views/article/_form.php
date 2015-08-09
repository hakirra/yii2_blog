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
/*.tdinput>input{margin: 0 !important;}*/
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
.comment{padding: 0 12px 6px;}
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
speak:none;
background: 0 0;
color: #fff;
}
.taglist span a:hover{background: #CC0000;}
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

.top-lock{display: inline-block;padding: 0 1px;}
.top-lock input{vertical-align: middle;}
.top-lock label{cursor: pointer;vertical-align: middle;height: 42px;padding-left: 6px;}
.protect{display: none;}
#top,#lock{cursor: default;}
#top{margin-bottom: 4px}
#protect-input{width: 190px;height: 34px;}
</style>
	 <!-- 配置文件 -->
    <script type="text/javascript" src="/backend/ueditor/ueditor.config.js"></script>
     <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/backend/ueditor/ueditor.all.min.js"></script>
     <script type="text/javascript" src="/backend/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="/backend/web/js/jquery1.11.js"></script>

<div class="article-form">
	
    <?php $form = ActiveForm::begin(); ?>
 <div class="left-form">
  	<table class="table ">  		 
   		<tr>
   			<td class="tdlable"><span style="color: red;">*&nbsp;</span>标题</td>
   			<td class="tdinput"><?= $form->field($models['article'], 'title')->textInput()->label(false)?></td>			
   		</tr>
   	
   		<tr>
   			<td class="tdlable">关键字</td>
   			<td class="tdinput"><?= $form->field($models['article'], 'keywords')->textInput()->label(false)?>多关键词之间用空格或者“,”隔开</td>
   		</tr>
   	
   		<tr>
   			<td class="tdlable">摘要</td>
   			<td class="tdinput"><?= $form->field($models['article'], 'excerpt')->textarea()->label(false)?></td>
   			<!--<textarea cols="10" rows="3" name="Article[excerpt]"></textarea>-->
   		</tr>
   		<tr>
   			<td class="tdlable"><span style="color: red;">*&nbsp;</span>内容</td>
   			<td class="tdinput">	
   					 <?= Html::activeTextarea($models['article'],'content',['id'=>'content'])?>	
   					 <div class="help-block" id="content-error" style="display: none;">请输入文章内容</div>
   			</td>   	
   					
   		</tr>

   	</table>
 
  <div class="form-group">
         <?= Html::submitButton(!$cateinfo ? '新增' : '修改', ['name'=>'submit','class' => !$cateinfo ? 'btn btn-success' : 'btn btn-primary']) ?>       
        <a class="btn btn-primary" href="/backend/web/index.php?r=article%2Findex">取消</a> 
   </div>
</div>
<div class="right-form">
	<div class="postbox">
		<h3 class="hndle ui-sortable-handle"><span>分类目录</span></h3>
		<div class="inside comment">
		<?php
			
			foreach($catetags as $cate){
				$strpad = str_pad('', intval($cate['level'])*18,"&nbsp;",STR_PAD_LEFT);
				if($cateinfo)
				$checked = in_array($cate['category_id'], $cateinfo) ?'checked':'';
				echo "<div class='checkcate'><label>{$strpad}<input type='checkbox' $checked name='post_category[]' value='{$cate["category_id"]}'><span>{$cate["name"]}</span></label></div>";		
			}	

		?>
		</div>
	</div>
	<div class="postbox">
		<h3 class="hndle ui-sortable-handle"><span>评论状态</span></h3>
		<div class="inside" style="height: 50px;line-height: 50px;">
			<?= $form->field($models['article'], 'comment_status')->radioList(['open'=>'启用','close'=>'禁用'])->label(false)?>
		</div>
	</div>
	<div class="postbox">
		<h3 class="hndle ui-sortable-handle"><span>置顶|加密</span></h3>
		<div class="inside" style="line-height: 50px;" id="lock-inside">
			<div class="top-lock top-div">
				<!--<input type="checkbox" name="Article[istop]" value="1" <?=$models['article']['istop']?'checked':''?> class="custom-checkbox" id="top">-->
				
				<?= Html::activeCheckbox($models['article'],'istop',['id'=>'top','labelOptions'=>['for'=>'top']])?>
				
				<!--<label for="top" class="top">置顶</label>-->
			</div>
			<div class="top-lock lock-div"><input type="checkbox"  class="custom-checkbox" id="lock"><label for="lock" class="lock">加密</label></div>
			<div class="protect">密码保护:<?= Html::activeTextInput($models['article'],'post_password',['id'=>'protect-input','width'=>'70'])?></div>
			<!--<input name="Article[post_password]" id="protect-input">-->
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
			<div class="taglist">
				
				<?php
					if($taginfo){
						foreach($taginfo as $value){
							echo "<span><a ></a>{$value}</span>";
						}
					}
				?>
			</div>
		</div>
	</div>
</div>
    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">

		var ue = UE.getEditor('content',{'initialFrameHeight':'400','initialFrameWidth':'100%'});


		/**
		 * 添加标签代码
		 */
		var tagarr = [];
		var dbtags = [];//存放从数据库加载的标签数据
		//初始化dbtags数组
		(function () {
			$(".taglist span").each(function () {
				var spantext = $.trim($(this).text());
				dbtags.push(spantext);
			});
		})();
		$(".taglist").delegate('a','click',function(){
			$(this).parent().remove();
			tagarr.remove($.trim($(this).parent().text()));
			dbtags.remove($.trim($(this).parent().text()));
		});
		$(".add-btn").click(function(){

			if(dbtags) $.merge(tagarr,dbtags);

			var val = $.trim($(".tag-text").val());
			if(val.indexOf(',')!=-1){
				var arr = val.split(',');
				for(var i=0;i<arr.length;i++){
					if($.inArray(arr[i],tagarr)==-1){
						tagarr.push(arr[i]);
						var obj = $("<span><a></a>"+arr[i]+"</span>");
						$(".taglist").append(obj);
					}
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
		$("button[type=submit]").on('click',function () {

			if(!ue.hasContents()){
				$("#content-error").css({'display':'block','color':'red'});
				return false;
			}else{
				$("#content-error").css('display','none');
			}
			if(tagarr.length == 0){
				$(".taglist span").each(function () {
					var spantext = $.trim($(this).text());
					tagarr.push(spantext);
				});
			}


			$(".hidden-text").val(tagarr);

		});

		//是否显示加密保护
		$(".lock-div,.lock").on('click',function () {
			if($(".protect").css('display')=='none'){
				$(".protect").css('display','block');
				$("#lock-inside").css('height','100');
				$(".lock-div input").attr('checked','checked');
			}else{
				$(".protect").css('display','none');
				$("#lock-inside").css('height','62');
				$(".lock-div input").removeAttr('checked');
			}
			$(".top-div input").removeAttr('checked');
		});


		$(".top-div,.top").on('click',function () {
			$(".protect").css('display','none');
			$("#lock-inside").css('height','62');
			$(".lock-div input").removeAttr('checked');
		});


</script>
