<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	session_start();
	$db = new Db();
	$id=$_GET['can'];
	$result=$db->row("select * from tie_main where guan_main=:id",array('id'=>$id));
	$result1=$db->row("select * from tie where guan_main=:id",array('id'=>$id));
	
	//楼主信息
	$user=$db->row("select * from user where id=:id",array('id'=>$result['hui_type']));
	
	//倒叙查看
	if($_GET['paidao']==1){
		$pai='desc';
		$paidao=1;
	}else{
		$pai='';
		$paidao=0;
	}
	
	//只看作者
	if($_GET['zhikan']==1){
		$zhikan="and `from` ='China_Sh'";
		$kan=1;
	}else{
		$zhikan='';
		$kan=0;
	}
	
	//分页操作
	$pageSize=4;
	$pageNum=empty($_GET['pageNum'])?1:$_GET['pageNum'];
	$sql="select * from tie_main where guan_main=:guan and lou!=0 $zhikan order by addtime $pai limit ".(($pageNum-1)*$pageSize).",".$pageSize;
	$chaxun = $db->query($sql,array('guan'=>$result1['guan_main']));
	$toutal=$db->single("select count(*) from tie_main where guan_main=:guan and lou!=0 $zhikan",array('guan'=>$result1['guan_main']));
	$yeshu=ceil($toutal/$pageSize);
	$paiming=0;
	
	if($_SESSION['cha']=='kai'){
		$update_sql="update tie set cha=cha+1 where guan_main=:main";
		$update=$db->query($update_sql,array('main'=>$id));
		$_SESSION['cha']='guan';
	}
	
	
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $result1['title'];?></title>
    <link href="css/autocomplete.css" rel="stylesheet">
    <link href="css/forum.css" rel="stylesheet">
    <link href="css/mod-dz-1.css" rel="stylesheet">
    <link href="css/style_6_common.css" rel="stylesheet">
    <link href="css/style_6_forum_index.css" rel="stylesheet">
    <link href="css/style_6_widthauto.css" rel="stylesheet">
    <link href="css/bdsstyle.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" charset="utf-8" src="ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="lang/zh-cn/zh-cn.js"></script>
    <?php include("css/main.html"); ?>
	<?php include("view/head.php"); ?>
	<?php include("css/footer.html"); ?>
	<?php include("css/chat.html"); ?>
    <style type="text/css">
    	.page{
    		display:inline-block;
    		border: 1px solid ;
    		font-size: 20px;
    		width: 30px;
    		height: 30px;
    		background-color: #1faeff;
    		text-align: center;
    	}
		.touxiang{
			width:100px;
			height:100px;
		}
    	a,a:hover{ text-decoration:none; color:#333}
    	
		.tbl {
		    background: #e5edf2 none repeat scroll 0 0;
		    border-right: 1px solid #c2d5e3;
		    overflow: hidden;
		    width: 160px;
		}
		
		.tbr {
		    hyphens: auto;
		    word-break: break-all;
		}
		
		.list-paddingleft-2 {
			padding-left: 36px;
		}
		body{
			background: #FFFFFF;
		}
    </style>
  </head>
<body >
	<?php include("view/header.php"); ?>


<div class="container-fluid" style="margin-top: 70px;" >
	<ol class="breadcrumb">
		  <li><a href="chat.php">首页</a></li>
		  <li><a href="c.php">c语言</a></li>
		  <li class="active"><?php echo $result1['title'];?></li>
	</ol>
</div>

<div class="container-fluid" >
	
	<div class="row">
		<div class="col-xs-7">
			<span style="padding-left: 10px;"><button type="button" class="btn btn-primary" onclick="xianshi(<?php echo "'".$user['username']."'";?>)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>回帖</button></span>
		</div>
	</div>
	
	<table class="table table-bordered">
		<?php
			if($pageNum==1){
				?>
				<tr>
			<td class="tbl">
				<div style="text-align: center;">
					<p>楼主</p>
					<a href="shuoshuo.php?id=<?php echo $user['id'];?>">
						<img src="<?php if($user['avatar']==null){echo "img/avatar.jpg";}else{echo "images/".$user['avatar'];}?>" class="touxiang" value="<?php echo $user['avatar'] ?>">
					</a>
					<input type="hidden" id="cang" value="<?php echo $result1['guan_main'];?>" />
					<input type="hidden" id="lei" value="<?php if($user['id']==$_SESSION['user']['id']){
				echo "0";
			}else{
				echo "1";
			}?>;" />
				</div>	
				<table class="table" style="background-color:#e5edf2; ">
						<tr>
							<td>昵称:</td>
							<td><?php echo $user['username'];?></td>
						</tr>
						<tr>
							<td>性别:</td>
							<td><?php if($user['sex']==0){
								echo "保密";
							}else if($user['sex']==1){
								echo "男";
							}else{
								echo "女";
							}?></td>
						</tr>
						<tr>
							<td>qq:</td>
							<td><?php echo $user['qq'];?></td>
						</tr>
						<tr>
							<td>发帖:</td>
							<td><?php echo $user['posts_num'];?></td>
						</tr>
						<tr>
							<td>回复:</td>
							<td><?php echo $user['hui_num'];?></td>
						</tr>
				</table>
			</td>
			
			<td class="tbr">
				<div style="height: 65px;padding-left: 20px;padding-top: 1px;">
					<h3><small><a style="color: #ifaeff" >[<?php echo $result1['te'];?>]</a></small> <a style="color: #ifaeff"><?php echo $result1['title'];?></a></h3>
				</div>
				<div style="width:98%;height:1px;margin-bottom:10px;padding:0px;background-color:#D5D5D5;overflow:hidden;"></div>
					<p class="text-right" style="padding-right: 90px;">
					<span style="padding-right: 30px;">
					<a style="color: #78BA00;">发表于:<?php echo tranTime($result['addtime']);?></a>
					 | 
					<a style="color: #78BA00;" class="zhikan" title="查看作者" onclick="zhikanzuo()">只看楼主</a>
					 | 
					<a style="color: #78BA00;" class="zhikan" title="倒序查看" onclick="daoxun()">倒序查看</a>
					 | 
					<a style="color: #78BA00;">共<?php echo $toutal;?>层</a>
					</span>
					</p>
				<div style="width:98%;height:1px;margin-bottom:10px;padding:0px;background-color:#D5D5D5;overflow:hidden;"></div>
				<div style="padding-top: 12px;min-height: 380px;">
					<?php echo $result['content'];?>
				
				</div>
				
				<div style="width:98%;height:1px;margin-bottom:10px;padding:0px;background-color:#D5D5D5;overflow:hidden;"></div>
				
				<div style="padding-right: 90px;">
					<p class="text-right" style="color: yellow;"><a href="javascript:void(0)" onclick="alert('举报')" style="color: #f4b300;"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>举报</a></p>
				</div>
				
			</td>
		</tr>
			<?php
			}
			?>
	
		<?php
			foreach($chaxun as $in){
				$paiming++;
				$us=$db->row("select * from user where username=:id",array('id'=>$in['from']));
				?>
				<tr>
				<td class="tbl">
					<div style="text-align: center;">
					<p>第<?php if($paidao==1){
						echo $toutal+1-($paiming+$pageSize*($pageNum-1));
					}else{
						echo ($paiming+$pageSize*($pageNum-1));
					}?>楼</p>
					<a>
						<img src="<?php if($us['avatar']==null){echo "img/avatar.jpg";}else{echo "images/".$us['avatar'];}?>" class="touxiang" value="<?php echo $us['avatar'] ?>">
					</a>
					</div>
					<table class="table" style="background-color:#e5edf2; ">
						<tr>
							<td>昵称:</td>
							<td><?php echo $us['username'];?></td>
						</tr>
						<tr>
							<td>性别:</td>
							<td><?php if($us['sex']==0){
								echo "保密";
							}else if($us['sex']==1){
								echo "男";
							}else{
								echo "女";
							}?></td>
						</tr>
						<tr>
							<td>qq:</td>
							<td><?php echo $us['qq'];?></td>
						</tr>
						<tr>
							<td>发帖:</td>
							<td><?php echo $us['posts_num'];?></td>
						</tr>
						<tr>
							<td>回复:</td>
							<td><?php echo $us['hui_num'];?></td>
						</tr>
					</table>
				</td>
				
				<td class="tbr">
						<span style="padding-right: 30px;">
						<a style="color: #78BA00;">回复于:<?php echo tranTime($in['addtime']);?> </a>
						</span>
					<div style="width:98%;height:1px;margin-bottom:10px;padding:0px;background-color:#D5D5D5;overflow:hidden;"></div>
					<div style="padding-top: 12px;min-height: 380px;">
						<?php echo $in['content']?>
					</div>
					<div style="width:98%;height:1px;margin-bottom:10px;padding:0px;background-color:#D5D5D5;overflow:hidden;"></div>
		
					<div style="padding-right: 90px;">
						<p class="text-right" style="color: yellow;">
						<a href="javascript:void(0)" onclick="xianshi(<?php echo "'".$us['username']."'";?>)" style="color: #f4b300;"><span class="glyphicon glyphicon-fire" aria-hidden="true"></span>回复此楼</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="javascript:void(0)" onclick="alert('举报${item.sec_id },${item.sec_sequence }')" style="color: #f4b300;"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>举报</a></p>
					</div>
				</td>
				</tr>
			<?
			}
			?>
			
	</table>
	
	<div class="row">
		<div class="col-xs-7">
			<span style="padding-left: 10px;"><button type="button" class="btn btn-primary" onclick="xianshi(<?php echo "'".$user['username']."'";?>)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>回复楼主</button></span>
		</div>
		<div class="col-xs-5 text-nowrap" >
			<div class="row">
				<?php include("view/huipage.php"); ?>
			</div>
		</div>
	</div>
	
	
	<div style="width:98%;height:3px;margin-bottom:10px;padding:0px;background-color:#D5D5D5;overflow:hidden;"></div>
	
	<form action="saveMainContent" method="post" id="saveTiezi">
        
        <label for="biaoti">回复的人是：</label>
		<input type="text" name="mainTitle" id="mainTitle" style="width: 150px;" disabled="disabled">
		
		<button type="button" class="btn btn-primary btn-xs text-right" onclick="getContent()" >回复帖子</button>
			
        <!-- 加载编辑器的容器 -->
        <div style="padding: 0px;margin: 0px;width: 100%;height: 100%;" >
	       <script id="editor" type="text/plain" style="width:1250px;height:250px;">
	       	
	       </script>
        </div>
   </form>
</div>
	<?php include("view/right.php"); ?>
	<?php include("view/footer.php"); ?>
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
    <script>
		var ue = UE.getEditor('editor');
		function getContent() {
			var lei=$('#lei').val();
			var content=ue.getContent();
			var mainTitle=$('#mainTitle').val();
			if(mainTitle.length==0){
				layer.msg('没有选择回复的人,请通过点击选中回复的人',{time:2000});
				return false;
			}
			var cang=$('#cang').val();
			$.post('ajaxHuiChat.php',{
				content:content,
				to:mainTitle,
				cang:cang,
				type:1,
				lei:lei
			},function(data){
				console.log(data);
				if(data==1){
						layer.msg('发帖成功',{time:1000},function(){
				            var index = parent.layer.getFrameIndex(window.name);
				            parent.location.reload();
				            parent.layer.close(index); 
				        });
					}else{
						layer.msg('发帖失败',{time:1000});
					}
			});
	    }
		function xianshi(data) {
			$('#mainTitle').val(data);
			var scrollTop=$('#saveTiezi').offset().top;
			document.documentElement.scrollTop=document.body.scrollTop=scrollTop;
	    }
	    function zhikanzuo(){
	    	var cang=$('#cang').val();//标题
	    	var daoxu=<?php echo $paidao;?>;
	    	var zhi=<?php if($kan==0){
	    		echo 1;
	    	}else{
	    		echo 0;
	    	}?>;
	    	window.location.href='tie.php?can='+cang+'&paidao='+daoxu+'&zhikan='+zhi;
	    }
	    function daoxun(){
	    	var cang=$('#cang').val();//标题
	    	var zhi=<?php echo $kan;?>;
	    	var daoxu=<?php if($paidao==0){
	    		echo 1;
	    	}else{
	    		echo 0;
	    	}?>;
	    		window.location.href='tie.php?can='+cang+'&paidao='+daoxu+'&zhikan='+zhi;
	    }
	</script>
</body>
</html>