<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	session_start();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	
	//分页操作
	$pageSize=20;
	$pageNum=empty($_GET['pageNum'])?1:$_GET['pageNum'];
	$sql="select * from tie where type = 1 order by addtime desc limit ".(($pageNum-1)*$pageSize).",".$pageSize;
	$chaxun = $db->query($sql);
	$toutal=$db->single("select count(*) from tie");
	$yeshu=ceil($toutal/$pageSize);
	
	//计算回复，查看，帖子数量
	$quan=$db->query("select * from tie");
	$chakan=0;
	$huifu=0;
	$tiezi=0;
	foreach($quan as $q){
		$tiezi++;
		$huifu+=$q['hui'];
		$chakan+=$q['cha'];
	}
	
	$_SESSION['cha']='kai';//避免重复
	
	?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<?php include("css/main.html"); ?>
		<?php include("view/head.php"); ?>
		<?php include("css/footer.html"); ?>
		<?php include("css/chat.html"); ?>
		<title>C语言专区</title>
		<link href="css/autocomplete.css" rel="stylesheet">
	    <link href="css/forum.css" rel="stylesheet">
	    <link href="css/mod-dz-1.css" rel="stylesheet">
	    <link href="css/style_6_common.css" rel="stylesheet">
	    <link href="css/style_6_forum_index.css" rel="stylesheet">
	    <link href="css/style_6_widthauto.css" rel="stylesheet">
	    <link href="css/bootstrap.min.css" rel="stylesheet">
	    <script type="text/javascript" charset="utf-8" src="ueditor.config.js"></script>
    	<script type="text/javascript" charset="utf-8" src="ueditor.all.min.js"> </script>
    	<script type="text/javascript" charset="utf-8" src="lang/zh-cn/zh-cn.js"></script>
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
	    	a,a:hover{ text-decoration:none; color:#333}
	    	body{
	    		background: #FFFFFF;
	    	}
			.nav {
				height: 100%;
				padding-left: 162px;
				overflow: visible;
			}
	    </style>
	</head>
	<body>
		<?php include("view/header.php"); ?>

<div class="container-fluid" style="margin-top: 100px;">
	<div class="row">
		<div class="col-xs-2 text-right">
			<img alt="" src="img/language_length3.png">
		</div>
		<div class="col-xs-10 text-left">
			  <h3>C语言专区</h3>
			  <p>版主:sh</p>
		</div>
		<p class="jinzhi">
			免责声明：
IT俱乐部所发布的帖子所包含的问答、技术和知识信息及软件的使用说明仅限用于学习和研究目的；不得将上述内容用于商业或者非法用途，否则，一切后果请用户自负。本站信息来自网络，版权争议与本站无关。您必须在下载后的24个小时之内，从您的电脑中彻底删除上述内容。如果您喜欢该网站，可以加入到我们的开发中来，一起改bug，为打击提供更好的服务。如有侵权请QQ或邮箱与我们联系处理。
		</p>
	</div>
	<!-- 横线 -->
	<div style="width:98%;height:3px;margin-bottom:10px;padding:0px;background-color:#D5D5D5;overflow:hidden;"></div>
	
	<div class="row">
		<div class="col-xs-9"  style="width: 73%;">
			<span style="padding-left: 10px;"><a href="#" onclick="xianshi()" class="btn btn-primary"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>写帖</a></span>
		</div>
		<div class="col-xs-3 text-nowrap" style="width: 27%;">
			<span class="text-muted" >
				共<?php echo $tiezi;?>帖子&nbsp;&nbsp;|&nbsp;&nbsp;
				共<?php echo $huifu;?>条回复&nbsp;&nbsp;|&nbsp;&nbsp;
				共<?php echo $chakan;?>次查看&nbsp;&nbsp;|&nbsp;&nbsp;
			  </span>
		</div>
	</div>
	
	<form action="#" method="post" id="saveTiezi" style="display: none;">
		<label for="biaoti">帖子所属：</label>
        <select name="mainFlag" style="width: 140px;" id="mainFlag">
        	<option value="新人贴">新人贴</option>
        	<option value="技术贴">技术贴</option>
        	<option value="问答贴">问答贴</option>
        	<option value="求助贴">求助贴</option>
        	<option value="合作帖">合作帖</option>
        </select>
        
        <label for="biaoti">帖子标题：</label>
		<input type="text" name="mainTitle" id="mainTitle" placeholder="最大长度50个汉字" style="width: 360px;" >
		
		<button type="button" class="btn btn-primary btn-xs text-right" onclick="getContent()" >发表帖子</button>
			
        <!-- 加载编辑器的容器 -->
        <div style="padding: 0px;margin: 0px;width: 100%;height: 100%;" >
	       <script id="editor" type="text/plain" style="width:1250px;height:400px;"></script>
        </div>
   </form>
	
	<table class="table table-striped">
  		<tr>
  			<th width="60%"><strong>标题：</strong></th>
  			<th width="10%"><strong>发表时间：</strong></th>
  			<th width="10%"><strong>作者</strong></th>
  			<th width="10%"><strong>回复/查看</strong></th>
  			<th width="10%"><strong>最后回复</strong></th>
  		</tr>
  		<?php
  			foreach($chaxun as $in){
  				?>
  				<tr onclick="tiao(<?php echo "'".$in['guan_main']."'";?>)">
  					<td>
						<a href="javascript:void(0)"><img src="<?php if($in['hui']>=20&&$in['cha']>=100){echo "img/pin_1.gif";}else{echo "img/folder_new.gif";}?>  " /><?php if($in['hui']>=20&&$in['cha']>=100){echo " [日月精华]";}else{echo " [新人帖子]";}?>&nbsp;&nbsp;<?php echo $in['title'];?>&nbsp;&nbsp;<?php echo "(".$in['te'].")";?></a>
  					</td>
					<td><?php echo tranTime($in['addtime']);?></td>
					<td><?php echo $in['admin'];?></td>
		  			<td><?php echo $in['hui'];?>/<?php echo $in['cha'];?></td>
		  			<td><?php echo $in['last_admin'];?></td>
				</tr>
  			<?php
  			}
  			?>
		
	</table>
	
	<div class="row">
		<?php include("view/page.php"); ?>
	</div>
	
	
	<div style="width:98%;height:3px;margin-bottom:10px;padding:0px;background-color:#D5D5D5;overflow:hidden;"></div>
	
	<!-- 富文本 -->
	
    
    <!-- end富文本 -->
</div>

	<?php include("view/right.php"); ?>
	<?php include("view/footer.php"); ?>
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
	<script>
		var ue = UE.getEditor('editor');
		function getContent() {
			var content=ue.getContent();
			var mainFlag=$('#mainFlag option:selected').val();
			var mainTitle=$('#mainTitle').val();
			if(mainTitle.length<=0||mainTitle.length>50||content.length==0){
				layer.msg('请正确填写帖子',{time:1000});
				return false;
			}
			$.post('ajaxChat.php',{
				content:content,
				mainFlag:mainFlag,
				mainTitle:mainTitle,
				type:1
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
	    function xianshi() {
	        $("#saveTiezi").slideToggle("slow");
	    }
	    
	    function tiao(data){
	    	window.location.href="tie.php?zhikan=0&paidao=0&can="+data;
	    }
	</script>
	
	</body>
</html>