<style>
	ul,li{list-style: none;padding: 0;}
	.nav-bar{
		width: 188px;
		/*border: 1px solid red;*/
		/*float: left;*/
		position: absolute;		
	}
	.nav-bar:before{
  content: "";
  display: block;
  width: 189px;
  position: fixed;
  bottom: 0;
  top: 0;
  z-index: -1;
  background-color: #f2f2f2;
  border-right: 1px solid #ccc;
  height: 1500px;
	}
	.nav-content{margin-left: 190px;width: auto;height: 600px;}
/*	.nav-bar>.nav-list>li>a{
		display: block;
		height: 38px;
		line-height: 38px;
		color: #585858;
		padding-left: 10px;
	}
	.nav-bar>.nav-list>li>a:hover{text-decoration: none;color: #1963AA;}
	.nav-list>li{
		  display: block;
  padding: 0;
  margin: 0;
  border: 0;
  border-top: 1px solid #fcfcfc;
  border-bottom: 1px solid #e5e5e5;
  position: relative;
	}*/
</style>

	<div class="nav-bar">
			<ul class="nav nav-list">
					<li class="active">
						<a href="index.html">
							<span class="mui-icon iconfont icon-user_set">用户管理</span>
						</a>
					</li>

			<li><a href="#" ><span class="mui-icon iconfont icon-lanmu">栏目管理</span></a></li>
			<li><a href="#" ><span class="mui-icon iconfont icon-article">文章管理</span></a></li>
			<li><a href="#" ><span class="mui-icon iconfont icon-pinglun">评论管理</span></a></li>
			<li id="rbac">
				<a href="#" class="dropdown-toggle">
					<span class="mui-icon iconfont icon-rbac">RBAC管理</span>
					<b class="arrow icon-angle-down"></b>
				</a>
				<ul class="submenu">
							<li>
								<a href="<?=Yii::$app->request->absoluteUrl.'?r=manager/index'?>">
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
	<div class="nav-content">
		<?php echo $content?>
	</div>
<script type="text/javascript">
window.onload=function () {
	$('#rbac').click(function () {
		$(this).find('.submenu').toggle();
	});
}
</script>