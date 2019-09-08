<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	session_start();
	$db = new Db();
	//查看用户id
	$user_id=empty($_GET['id'])?$_SESSION['user']['id']:$_GET['id'];
	$addtime = time();
	
	//分别遍历被访问的信息，和空间信息
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	$geren = $db->row("select * from geren where user_id = :user_id",array('user_id'=>$user_id));
	
	if($user_id!=$_SESSION['user']['id']){
		//如果不是自己访问
		$sql="insert into kong(f,t,addtime)values(:f,:t,$addtime)";
		$db->query($sql,array('f'=>$_SESSION['user']['id'],'t'=>$user_id));
		$db->query("update geren set fang=fang+1 where user_id=$user_id");
	}
	
	//遍历今日被访问次数
	$todaystart = strtotime(date('Y-m-d'.'00:00:00',time()));
	$todayend = strtotime(date('Y-m-d'.'00:00:00',time()+3600*24));
	$jinri_fang = $db->single("select count(*) from kong where t=:t and addtime between :shijian and :jiezhi ",array('t'=>$user_id,'shijian'=>$todaystart,'jiezhi'=>$todayend));
	
	$na=$user['username'];
	
	//截取滑动的留言内容
	$num=15;
	$sql1="select * from liuyan where name = :username order by id desc limit :num";
	$quanbu=$db->query($sql1,array('username'=>$na,'num'=>$num));
	
	//显示内容
	$num1=50;
	$sql="select * from liuyan where name = :username order by id desc limit :num";
	$chaxun = $db->query($sql,array('username'=>$na,'num'=>$num1));
	
	?>

<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8" />
	<title><?php echo $user['username']."的空间";?></title>
	<?php include("css/main.html"); ?>
	<?php include("view/head.php"); ?>
	<?php include("css/footer.html"); ?>
	<?php include("css/geren.html"); ?>	
	<?php include("css/header.html"); ?>	
	<script type="text/javascript" src="highslide/highslide-with-gallery.js"></script>
	<style type="text/css">
		body{
			background: #FFF;
			overflow-x: hidden;
		}
	</style>
</head>
<script src="js/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="layer/layer.js"></script>
<script>
window.onload=function()
{
	var oDiv=document.getElementById('div_liu');
	var aA=oDiv.getElementsByTagName('a');
	var i=0;
	for(i=0;i<aA.length;i++)
	{
		aA[i].pause=1;
		aA[i].time=null;
		initialize(aA[i]);
		aA[i].onmouseover=function()
		{
			this.pause=0;	
		};
		aA[i].onmouseout=function()
		{
			this.pause=1;
		};
	}
	setInterval(starmove,30);//定义块的速度 
	function starmove()
	{
		for(i=0;i<aA.length;i++)
		{
			if(aA[i].pause)
			{
				domove(aA[i]);
			}
		}
	}
	
	function domove(obj)
	{
		if(obj.offsetTop<=-obj.offsetHeight)
		{
			obj.style.top=oDiv.offsetHeight+"px";
			initialize(obj);
		}
		else
		{
			obj.style.top=obj.offsetTop-obj.ispeed+"px";	
		}
	}
	function initialize(obj)
	{
		var iLeft=parseInt(Math.random()*oDiv.offsetWidth);
		var scale=Math.random()*1+1;
		var iTimer=parseInt(Math.random()*2000);
		obj.pause=0;

		obj.style.fontSize=12*scale+'px';

		if((iLeft-obj.offsetWidth)>0)
		{
			obj.style.left=iLeft-obj.offsetWidth+"px";
		}
		else
		{
			obj.style.left=iLeft+"px";
		}
		clearTimeout(obj.time);
		obj.time=setTimeout(function(){
			obj.pause=1;
		},iTimer);
		obj.ispeed=Math.ceil(Math.random()*4)+1;
	}
};
/**检测字数：大于0，小于140字**/
function checkWordsNumber(content){
    var len = content.length;
    var message = '';
    if (len == 0) {
        message = "发布内容不能为空！";
    }
    if (len > 70) {
        message = "发布内容不能超过70字！";
    }
    return message;
};

/**检测字数**/
function checknum(v, word) {
    var len = 70 - v.length;
    $('#sayword_' + word).text(len);
    if (len < 0) {
        $('#sayword_' + word).css({
            "color": "red"
        });
    }
}
	
/**确认发布**/
function saysub(pid,type) {
    var content = $('#saybox_'+ pid).val();
    var name=$('#btn_name').val();
    var pic=$('#btn_touxiang').val();
    var name1=$('#btn_name1').val();
    var pic1=$('#btn_touxiang1').val();
    var check_result = checkWordsNumber(content);
    if(check_result){
        layer.msg(check_result);
        return false;
    }

    $.post("ajaxLiuyan.php", {sendName:name1,name:name,content:content}, function(data) {
        if (data == -1) {
            layer.msg('提交失败',{time:1000});
            return false;
        }
        layer.msg('提交成功',{time:1000});
        addNew(name1,content,pic1);
    })
}

function addNew(sName, sMsg ,touxiang)
{
	var shijian=biao();
	var oDiv=document.getElementById('content');
	var oUl=oDiv.getElementsByTagName('ul')[0];
	var oTmpUl=document.getElementById('tmp_container');
	var oLi=null;
	var oTimer=null;
	var iHeight=0;
	
	oLi=document.createElement('li');
	oLi.innerHTML='<div class="pic"><a href="#"><img src='+touxiang+' class="fl"></a><ul><li><strong>'+sName+'</strong></li><li><i>'+shijian+'</i></li></ul><div class="pic1">'+sMsg+'<div>';
	
	oTmpUl.appendChild(oLi);
	iHeight=oLi.offsetHeight+149;
	
	oLi.innerHTML='';
	oLi.style.height='0px';
	
	if(oUl.getElementsByTagName('li').length==0)
	{
		oUl.appendChild(oLi);
	}
	else
	{
		oUl.insertBefore(oLi, oUl.getElementsByTagName('li')[0]);
	}
	
	var alpha=0;
	oTimer=setInterval
	(
		function ()
		{
			var h=parseInt(oLi.style.height)+2;
			
			if(h>=iHeight)
			{
				h=iHeight;
				clearInterval(oTimer);
				oLi.innerHTML='<div class="pic"><a href="#"><img src='+touxiang+' class="fl"></a><ul><li><strong>'+sName+'</strong></li><li><i>'+shijian+'</i></li></ul><div class="pic1">'+sMsg+'<div>';
				
				oLi.style.filter="alpha(opacity:0)";
				oLi.style.opacity="0";
				
				oTimer=setInterval
				(
					function ()
					{
						alpha+=10;
						oLi.style.filter="alpha(opacity:"+alpha+")";
						oLi.style.opacity=alpha/100;
						
						if(alpha==100)
						{
							oLi.style.filter="";
							oLi.style.opacity="";
							
							clearInterval(oTimer);
						}
					},15
				);
			}
			oLi.style.height=h+'px';
		},10
	);
}

function biao() {

	var date = new Date();
	
	var iYear = date.getFullYear();
	var iMonth = date.getMonth() + 1;
	var iDate = date.getDate();
	var iHours = date.getHours();
	var iMin = date.getMinutes();
	var iSec = date.getSeconds();
	str = iYear + '-' + iMonth + '-' + iDate + ' ' + toTwo(iHours) + ':' + toTwo(iMin) + ':' + toTwo(iSec);
	return str;
	
}

function toTwo(n) {
	return n < 10 ? '0' + n : '' + n;
}	
</script>
<body>
	<?php include("view/header.php"); ?>
	
	<div class="background-container">
		<div class="layout-head ">
			<div class="layout-head-inner" style="background: no-repeat; height: 250px;">
				<div class="head-info">
					<h1 class="head-title">
						<span class="title-text ui-mr5"><?php echo $user['username']."的空间";?></span>
					</h1>
					<div class="head-description">
						<span class="description-text"><?php echo $geren['title'];?></span>
					</div>
				</div>
				<div class="head-detail">
					<div class="head-detail-name">
						<span class="user-name textoverflow">
							<?php echo $user['username'];?>
						</span>
					</div>
					<div class="head-detail-info clearfix" style="font-size: 16px;">
						<ul class="fff">
							<li>发帖:<?php echo $user['posts_num'];?></li>
							<li>关注:<?php echo $user['follows_num'];?></li>
							<li>粉丝:<?php echo $user['fans_num'];?></li>
						</ul>
					</div>
				</div>
				<div class="layout-shop-item">
					<div class="shop-item cs" style="width: px; height: 32px; left: 150px; top: 252px;">
						<div class="head-nav">
							<ul class="head-nav-menu">
								<li style="display: <?php if($user_id==$_SESSION['user']['id']){echo "inline-block";}else{echo "none";}?>;">
									<span class="arr">
										<a href="geren.php">主页</a>
									</span>
								</li>
								<li>
									<span class="arr">
										<a href="shuoshuo.php?id=<?php echo $user_id;?>">说说</a>
									</span>
								</li>
								<li>
									<span class="arr">
										<a href="zanMe.php?id=<?php echo $user_id;?>">我的赞</a>
									</span>
								</li>
								<li>
									<span class="arr">
										<a href="fenMe.php?id=<?php echo $user_id;?>">粉丝</a>
									</span>
								</li>
								<li>
									<span class="arr">
										<a href="guanMe.php?id=<?php echo $user_id;?>">关注</a>
									</span>
								</li>
								<li>
									<span class="arr">
										<a href="liuyanban.php?id=<?php echo $user_id;?>">留言板</a>
									</span>
								</li>
								<li>
									<span class="arr">
										<a href="dang.php?id=<?php echo $user_id;?>">个人档</a>
									</span>
								</li>
							</ul>
						</div>
					</div>
					<div class="shop-item" style="top: 186px; left: 887px; width: 159px; height: 56px; cursor: pointer;">
						<div class="visit-module">
							<div class="other-info">
								<div class="today-wrapper">
									<p class="visit-today">
										今日访客 
										<span class="count count-margin "><?php echo $jinri_fang;?></span>
									</p>
								</div>
								<div class="count-wrapper">
									<p class="visit-count">
										访问总量
										<span class="count ">
											<?php echo $geren['fang'];?>
										</span>
									</p>
								</div>
							</div>
							<i class="icon-visit icon-star-1">
							</i>
						</div>
					</div>
				</div>
				<div class="actions profile-hd-actions">
					<a id="cancel-follow" href="javascript:;" class="btn-head" id="add_specialcare" style="display: <?php if($user_id==$_SESSION['user']['id']){echo "none";}else{echo "inline-block";}?>;">
						<s class="ui-icon icon_add_care"></s>
						<span class="txt">
							<?php if(is_follow($user_id) == true){
								echo "取消关注";
							}else{
								echo "添加关注";
							}?>
						</span>
					</a>
					<div class="btn-head btn-head-like">
						<a class="lnk-left" style="text-decoration: none;" href="javascript:;" onclick="zan()" title="<?php echo $geren['zan'];?>">
							<s class="ui-icon sp-btn-like"></s>
							<span class="txt good-num">
								<?php echo $geren['zan'];?>
							</span>
							<span class="txt message-num">
							</span>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="layout-nav">
			<div class="layout-nav-inner">
				<div class="head-avatar">
					<img title="进入空间" src="<?php if($user['avatar']==null){echo "img/avatar.jpg";}else{echo "images/".$user['avatar'];}?>" class="user-avatar" value="<?php echo $user['avatar'] ?>">
				</div>
			</div>
		</div>
		<div class="layout-background">
			<div class="layout-body">
				<div class="layout-page clearfix">
					
					
					<div class="left1">
				<div class="liuyanban_content">
					<div id="div_liu">
						<?php if(isset($quanbu)){ ?>
							<?php foreach($quanbu as $v) {?>
								<a href="javascript:;"><?php echo $v['content']?></a>
							<?php }?>
						<?php } ?>
					</div>
				</div>
				<div class="liuyanban_index">
					<?php if(!isset($chaxun)){ ?>
		            <div class="empty">
		                <p>还没有留言哦！</p>
		            </div>
		            <?php }else {?>
						<div class="liuyanban">
							<h1><?php echo $user['username'];?>的留言板</h1>
						</div>
						<div class="start_liuyan">
							<dl>
								<dt>快来留个言吧~~~</dt>
								<dd>
									<input id='btn_name1' class="text" type="hidden" value="<?php echo $_SESSION['user']['username']?>"/>
									<input id='btn_touxiang1' class="text" type="hidden" value="<?php if($_SESSION['user']['avatar']==null){echo "img/avatar.jpg";}else{echo "images/".$_SESSION['user']['avatar'];}?>"/>
									
									<input id='btn_name' class="text" type="hidden" value="<?php echo $user['username']?>"/>
									<input id='btn_touxiang' class="text" type="hidden" value="<?php if($user['avatar']==null){echo "img/avatar.jpg";}else{echo "images/".$user['avatar'];}?>"/>
									</dd>
						        <dd><textarea  name="content" id="saybox_0"   onkeyup="checknum(this.value, '0')" class="btn_msg" placeholder="  留个言吧~~"></textarea></dd>
						        <dd style="margin-top: 15px;">
						        	<div class="release">
						            <span class="countTxt">还可输入<em id="sayword_0" class="count">70</em>字</span>
						            <button class="ui teal button" onclick="saysub(0)">发布 </button>
						        </div>
						        </dd>
							</dl>							
						</div>
						<div id="content">
					        <ul>
					        	<?php
					        		foreach($chaxun as $v){
					        			//对数据进行加载
					        			$mingzi=$v['username'];
					        			$neirong=$v['content'];
					        			$shijian=$v['addtime'];
					        			$sq="select * from user where username = :mingzi";
					        			$touxiang=$db->row($sq,array('mingzi'=>$mingzi));
					        			$tou=$touxiang['avatar'];
					        			if($tou==null){
					        				$tou='img/avatar.jpg';
					        			}else{
					        				$tou="images/".$tou;
					        			}
					        			echo "<li>";
					        			echo "<div class='pic'>";
					        			echo "<a>";
					        			echo "<img class='fl' src='$tou'>";
					        			echo "</a>";
					        			echo "<ul class='fl'>";
					        			echo "<li>";
					        			echo "<strong>";
					        			echo $mingzi;
					        			echo "</strong>";
					        			echo "</li>";
					        			echo "<li>";
					        			echo tranTime($shijian);
					        			echo "</li>";
					        			echo "</ul>";
					        			echo "<div class='pic1'>";
					        			echo $neirong;
					        			echo "</div>";
					        			echo "</div>";
					        			echo "</li>";
					        		}?>
					        </ul>
					    </div>			            	
					<?php }?>
				</div>
				<ul id="tmp_container" style="height:0px; overflow:hidden;"></ul>
			</div>
					
				<?php include("view/ri.php"); ?>
			</div>
		</div>
	</div>
	
	<?php include("view/right.php"); ?>
	<?php include("view/footer.php"); ?>
	<script>
		function zan(){
			var to_id=<?php echo $user_id;?>;
			$.post('ajaxTian.php',{
				to_id:to_id
			},
			function(data){
				console.log(data);
				if(data==1){
					layer.msg('点赞成功',{time:1000},function(){
				            var index = parent.layer.getFrameIndex(window.name);
				            parent.location.reload();
				            parent.layer.close(index); 
				        });
				}else{
					layer.msg('点赞失败');
				}
			})
		}
	</script>
</body>
</html>
