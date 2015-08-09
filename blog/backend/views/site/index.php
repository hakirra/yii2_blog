<style>
    ul, li {
        list-style: none;
        padding: 0;
    }

    .nav-bar {
        width: 188px;
        position: fixed;
    }

    .nav-bar:before {
        content: "";
        display: block;
        width: 189px;
        position: fixed;
        bottom: 0;
        top: 0;
        z-index: -1;
        background-color: #f2f2f2;
        border-right: 1px solid #ccc;
        height: 1800px;
    }

    iframe {
        margin-left: 190px;
    }
</style>

<div class="nav-bar">
    <ul class="nav nav-list">
        <li class="active" data-ctrl="user">
            <a href="javascript:void(0)">
                <span class="mui-icon iconfont icon-user_set">用户管理</span>
            </a>
        </li>

        <li data-ctrl="category"><a href="javascript:void(0)"><span class="mui-icon iconfont icon-lanmu">栏目管理</span></a>
        </li>
        <li data-ctrl="tags"><a href="javascript:void(0)"><span class="mui-icon iconfont icon-lanmu">标签管理</span></a>
        </li>
        <li data-ctrl="article"><a href="javascript:void(0)"><span
                    class="mui-icon iconfont icon-article">文章管理</span></a></li>
        <li data-ctrl="comment"><a href="javascript:void(0)"><span
                    class="mui-icon iconfont icon-pinglun">评论管理</span></a></li>
        <li id="rbac" data-ctrl="rbac">
            <a href="javascript:void(0)" class="dropdown-toggle">
                <span class="mui-icon iconfont icon-rbac">RBAC管理</span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li>
                    <a href="<?= Yii::$app->request->absoluteUrl . '?r=manager/index' ?>">
                        <i class="icon-double-angle-right"></i>
                        管理员管理
                    </a>
                </li>
                <li>
                    <a href="form-elements.html">
                        <i class="icon-double-angle-right"></i>
                        角色管理
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>

<iframe id="iframe" marginwidth="0" frameborder="0" scrolling="no"
        src="<?= Yii::$app->request->baseUrl . '/index.php?r=user' ?>"></iframe>

<script type="text/javascript">
    function changeHeight(h) {
        $("#iframe").css('height', h);
    }
    window.onload = function () {
        $('#rbac').click(function () {
            $(this).find('.submenu').toggle();
        });
        var iframeW = ($(window).width() - 190).toString() + 'px';

        $("iframe").css({'width': iframeW});
        $("ul.nav-list>li").click(function () {
            $("ul.nav-list>li").removeClass('active');
            $(this).addClass('active');
            var ctrl = $(this).attr('data-ctrl');
            $("#iframe").attr('src', "<?=Yii::$app->request->baseUrl.'/index.php?r='?>" + ctrl);
        });
    }
</script>