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
    <?= Html::csrfMetaTags() ?>
    <?= Html::encode($this->title) ?>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div  style="overflow-x: hidden;" id='branch'>

    	 <?= $content ?>     
    </div>
      <?php $this->endBody() ?>
    <script>
        var isAll,ids =[];

        function selectRow(id) {
            var id = String(id);
            if($.inArray(id,ids) ==-1){
                ids.push(id);
            }else{
                ids.remove(id);
            }
            if(ids.length==0){
                isAll = false;
                $("#selectAll").removeAttr('checked');
            }
        }
        window.onload = function(){
           setTimeout(function(){
               var h = $("#branch").height();
               parent.changeHeight(h);
           },200);


            <?php
            $url = \yii\helpers\Url::to('');
            $url = preg_replace('/(%|&)\S*/','',$url);
            ?>

            $("#selectAll").click(function () {

                if(!isAll){
                    $.ajax({
                        url:"<?=$url?>"+'/take&offset='+<?=($pagination->page)*($pagination->defaultPageSize)?>,
                        async:false,
                        success:function (data) {

                            if(data instanceof Array && data.length>0){

                                for(var attr in data[0]){
                                    ids = getSelectedIds(data,attr);//attr是表字段主键，必须传
//                                    break;
                                }
                            }

                        }
                    });

                    $(":checkbox").each(function (i) {
                        $(this).prop('checked',true);
                        $(".tbody>tr").addClass('info');
                    });
                    isAll = true;
                }else{
                    ids.length = 0;
                    $(":checkbox").each(function (i) {
                        $(this).prop('checked',false);
                        $(".tbody>tr").removeClass('info');
                    });
                    isAll = false;
                }
            });

            $(".tbody input:checkbox").click(function (e) {
                var evt = e ? e : window.event;
                if(evt.stopPropagation){
                    evt.stopPropagation();
                }else{
                    evt.cancelBubble = true;
                }
                console.log(ids);
                $(this).parent().parent().toggleClass('info');
            });
            $(".tbody>tr").on('click',function () {
                var box = $(this).find("input:checkbox");
                console.log(ids);
                $(this).toggleClass('info');
                box.prop('checked',!box.prop('checked'));
            });

            $("#update").click(function () {
                if(ids.length>1){
                    alert('只能选择一条数据操作');
                }else if(ids.length ==0){
                    alert('请选择要操作的数据');
                }else{
                    var id = ids[0];

                    $(this).attr('href',"<?=$url?>"+'/update&id='+id);
                }
            });

            $("#delete").click(function () {

                if(ids.length ==0){
                    alert('请选择要操作的数据');
                }else{
                    var btnkey = confirm('您确定要永久删除数据吗');
                    if(btnkey){
                        $(this).attr('href',"<?=$url?>"+'/delete&id='+ids);
                    }

                }
            });

            $("#search").click(function () {
                var param = $.trim($("#input-search").val());
                $(this).attr('href',"<?=$url?>"+'/index&username='+param);
            });
        }
    </script>
     </body>
</html>
<?php $this->endPage() ?>