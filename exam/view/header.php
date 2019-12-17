	<?php
		$arr1=$db->query("select * from study where type=1");
		$arr2=$db->query("select * from study where type=2");
		$arr3=$db->query("select * from study where type=3");
		$arr4=$db->query("select * from study where type=4");
		$arr5=$db->query("select * from study where type=5");
		$arr6=$db->query("select * from study where type=6");
		?>
	<div class="cloud-header">
		<div>
			<div class="login_left">
				<img src="img/logo_it.png" alt="IT俱乐部" title="IT俱乐部" class="login_it" />
			</div>
			<div class="login_left">
				<span>IT俱乐部</span>
			</div>
			<div class="nav">
				<ul class="header-list">
					<li class="list-nav">
						<a href="chat.php">讨论专区</a>
					</li>
					<li class="list-nav">
						<a href="#">自制游戏</a>
						<div class="cloud-sub-nav solution-nav common-mobile current1">
							<ul class="nav-content">
								<li class="nav-col col-0">
									<ul class="nav-type">
										<li>
											<div class="product-type" style="width: 120px;">好友对战游戏</div>
											<ul class="sub-col sub-col-0">
												<li>
													<a href="game/chess/index.php" title="象棋小游戏" >象棋游戏</a>
												</li>
											</ul>
										</li>
									</ul>
								</li>
								<li class="nav-col col-1">
									<ul class="nav-type">
										<li>
											<div class="product-type" style="width: 120px;">网页单机小游戏</div>
											<ul class="sub-col sub-col-0">
												<li>
													<a href="game/fang_div/index.php" title="俄罗斯方块" >俄罗斯方块</a>
												</li>
											</ul>
										</li>
									</ul>
								</li>
							</ul>
						</div>
					</li>
					<li class="list-nav">
						<a href="#">作业及比赛</a>
						<div class="cloud-sub-nav doc-nav common-mobile current1">
							<ul class="nav-content">
								<li class="nav-col col-0">
									<ul class="nav-type">
										<li>
											<div class="product-type" style="width: 120px;">内部比赛</div>
											<ul class="sub-col sub-col-0">
												<li>
													<a href="#" title="C语言基础" >C语言基础</a>
												</li>
												<li>
													<a href="#" title="网页搭建" >网页搭建</a>
												</li>
											</ul>
										</li>
									</ul>
								</li>
								<li class="nav-col col-1">
									<ul class="nav-type">
										<li>
											<div class="product-type" style="width: 120px;">最近作业</div>
											<ul class="sub-col sub-col-0">
												<li>
													<a href="#" title="c语言" >c语言</a>
													<a href="#" title="前段" >前段</a>
												</li>
											</ul>
										</li>
									</ul>
								</li>
							</ul>
						</div>
					</li>
					<li class="list-nav">
						<a href="#">学习资源</a>
						<div class="cloud-sub-nav market-nav common-mobile current1">
							<ul class="nav-content">
								<li class="nav-col col-0">
									<ul class="nav-type no-border">
										<div class="product-type">
											前段基础
										</div>
										<ul>
											<li>
												<?php
												foreach($arr1 as $a){
													$name=$a['title'];
													?>
													<a href="study.php?id=<?php echo $name;?>">
														<?php echo $name?>
														</a>
												<?php
												}
												?>
											</li>
										</ul>
									</ul>
								</li>
								<li class="nav-col col-1">
									<ul class="nav-type no-border">
										<div class="product-type">
											前段高级
										</div>
										<ul>
											<li>
												<?php
												foreach($arr2 as $a){
													$name=$a['title'];
													?>
													<a href="study.php?id=<?php echo $name;?>">
														<?php echo $name?>
														</a>
												<?php
												}
												?>
											</li>
										</ul>
									</ul>
								</li>
								<li class="nav-col col-2">
									<ul class="nav-type no-border">
										<div class="product-type">
											服务器
										</div>
										<ul>
											<li>
												<?php
												foreach($arr3 as $a){
													$name=$a['title'];
													?>
													<a href="study.php?id=<?php echo $name;?>">
														<?php echo $name?>
														</a>
												<?php
												}
												?>
											</li>
										</ul>
									</ul>
								</li>
								<li class="nav-col col-3">
									<ul class="nav-type no-border">
										<div class="product-type">
											数据库
										</div>
										<ul>
											<li>
												<?php
												foreach($arr4 as $a){
													$name=$a['title'];
													?>
													<a href="study.php?id=<?php echo $name;?>">
														<?php echo $name?>
														</a>
												<?php
												}
												?>
											</li>
										</ul>
									</ul>
								</li>
								<li class="nav-col col-4">
									<ul class="nav-type no-border">
										<div class="product-type">
											算法
										</div>
										<ul>
											<li>
												<?php
												foreach($arr6 as $a){
													$name=$a['title'];
													?>
													<a href="study.php?id=<?php echo $name;?>">
														<?php echo $name?>
														</a>
												<?php
												}
												?>
											</li>
										</ul>
									</ul>
								</li>
								<li class="nav-col col-4">
									<ul class="nav-type no-border">
										<div class="product-type">
											其他开发
										</div>
										<ul>
											<li>
												<?php
												foreach($arr5 as $a){
													$name=$a['title'];
													?>
													<a href="study.php?id=<?php echo $name;?>">
														<?php echo $name?>
														</a>
												<?php
												}
												?>
											</li>
										</ul>
									</ul>
								</li>
							</ul>
						</div>
					</li>
					<li class="list-nav">
						<a href="#">社团新闻</a>
						<div class="cloud-sub-nav partner-nav current1">
							<ul class="nav-content">
								<li class="nav-col col-0">
									<ul class="nav-type">
										<li>
											<a href="news.php" >社团开始纳新</a>
										</li>
									</ul>
								</li>
							</ul>
						</div>
					</li>
					<li class="list-nav">
						<a href="join_kaifa.php">一起开发与运维</a>
					</li>
				</ul>
				<div class="cloud-header-search" id="current">
					<div class="bg1" id="bg1">
						
					</div>
					<div class="content1">
						<form action="search.php" method="post">
							<input type="text" name="key" id="header-search-input" value="" class="search-input input"/>
							<span class="button1" id="header-search-button">
								<img class="icon" src="img/search.jpg"/>
							</span>
						</form>
					</div>
				</div>
				<ul class="login" style="display: block;">
					<li class="list-nav login-li">
						<a href="setting.php" class="login_session"><?php echo $_SESSION['user']['username'] ?></a>
					</li>
					<li class="qie" id="qie">
						<span>账号设置</span>
						<ul class="sub-nav logout-nav" id="ul1" style="display: none;">
							<li id="acount">
								账号切换
							</li>
							<li onclick="window.location.href='logout.php'">
								退出									
							</li>
						</ul>
					</li>
					<li class="console">
						<a href="geren.php" class="console_a">进入个人空间</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<script>
		$('#current').click(function(){
			$('#header-search-input').addClass("hasWidth");
			$('#current').addClass("current");
			$('#header-search-input').focus();
		})
		
		$('#header-search-input').blur(function(){
			$('#header-search-input').removeClass("hasWidth");
			$('#current').removeClass("current");
		})

		$('#qie').hover(function(){
			$('#ul1').show()
		},function(){
			$('#ul1').hide();
		})
		
		$('.login_left').click(function(){
			window.location.href="main.php";
		})
		
		$('#acount').click(function(){
			//iframe层
			layer.open({
			  type: 2,
			  title: '切换账号',
			  shadeClose: true,
			  shade: 0.5,
			  area: ['400px', '250px'],
			  content: 'acount.php' 
			}); 
		})
		
	</script>
