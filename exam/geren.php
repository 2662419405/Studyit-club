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
	
	//分页
	$pageSize=5;
	$pageNum=empty($_GET['pageNum'])?1:$_GET['pageNum'];
	$sql="select * from post where post_type != 1 order by addtime desc limit ".(($pageNum-1)*$pageSize).",".$pageSize;
	$chaxun = $db->query($sql);
	$toutal=$db->single("select count(*) from post where post_type != 1");
	$yeshu=ceil($toutal/$pageSize);
	
	foreach($chaxun as $vo){
        if($vo['pictures']){
            $vo['pictures'] = explode(',',$vo['pictures']);
        }

        //如果转发
        if(isset($vo['pid']) && $vo['post_type'] == 2){
            $parent  = array();
            $content = '';
            $pid = $vo['pid'];
            $parent  = $db->row('select * from post where id = '.$pid);
            do{
                if(isset($parent) && $parent['post_type'] == 2){
                    $content = '@'.$parent['username'].':'.$parent['content'].'//'.$content;
                    $parent  = $db->row('select * from post where id = '.$parent['pid']);
                    $flag = true;
                }else{
                    if($parent['pictures']){
                        $parent['pictures'] = explode(',',$parent['pictures']);
                    }
                    $sub['parent'] = $parent;
                    $flag = false;
                }
            }while($flag === true);
            //去除结尾的“//”
            $sub['content'] = substr($content,0,-2);
            $vo['sub'] = $sub;
        }
        $lists[] = $vo;
    }
    
    $na=$user['username'];
	
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
		.button{
			border-color: #fff;

		}
	</style>
</head>
<script>
$(function(){
	$('#follow,#cancel-follow').click(function(){
        var friend_id = <?php echo $user_id;?>;
        var friend_name=document.getElementById('hidden1').value;
        $.post("follow.php",{friend_id:friend_id,friend_name:friend_name},function(re){
            if(re == 1){
                layer.msg('关注成功',{time:1000});
            }else{
                layer.msg('已取消',{time:1000});
            }
            window.location.reload();
        });
    });
});

/**检测字数**/
function checknum(v, word) {
    var len = 140 - v.length;
    $('#sayword_' + word).text(len);
    if (len < 0) {
        $('#sayword_' + word).css({
            "color": "red"
        });
    }
}

/**选择好友**/
function chooseFriend(username){
    var content = $('textarea').val();
    content = content + '@'+username + ' ';
    $('#saybox_0').val(content);
    $('.interest-link').hide();
}

/**确认发布**/
function saysub(pid,type) {
    var content = $('#saybox_'+ pid).val();
    var check_result = checkWordsNumber(content);
    if(check_result){
        layer.msg(check_result);
        return false;
    }
    /**获取图片路径,拼接成字符串**/
    var pics = '';
    $('.img_common').each(function(){
        pics += $(this).attr('src') + ",";
    });
    if(pics){
        pics = pics.substring(0,pics.length-1);
    }

    if(type == 'comment'){
        type = 1;
    }else if(type == 'forward'){
        type = 2;
    }else{
        type = 0;
    }

    $.post("ajaxAction.php", {pid:pid,type:type,content:content,pictures:pics}, function(data) {
        if (data == -1) {
            layer.msg('请先登录',{time:1000},function(){
                window.location.href = 'login.php';
            });
            return false;
        }
        layer.msg('发布成功',{time:1000},function(){
            var index = parent.layer.getFrameIndex(window.name);
            parent.location.reload();
            parent.layer.close(index); 
        });
    })
}
/**检测字数：大于0，小于140字**/
function checkWordsNumber(content){
    var len = content.length;
    var message = '';
    if (len == 0) {
        message = "发布内容不能为空！";
    }
    if (len > 140) {
        message = "发布内容不能超过140字！";
    }
    return message;
}
$(function(){

    $('.weibo_list_bottom .weibo_list_bottom_message').live('click',function(){
		console.log(1);
        var total = $(this).children('span').html();
        var comment_list = $(this).parent().siblings(".weibo_comment").children(".comment_list");
        if(comment_list.is(":hidden")){
            if(total > 0 ){
                var index = layer.msg('数据加载中', {icon: 16});
                var pid = $(this).parent().attr('value');
                $.post("getComment.php", {pid: pid}, function(jsdata) {
                    var data = jsdata;
                    $(data).each(function(){
                        var str = '';
                        str += '<div class="weibo_list weibo-comment" >';
                        str += '<div class="weibo_list_top">';
                        str += '<div class="weibo_list_head">';
                        str += '<a href=shuoshuo.php?id='+this.user_id+'><img class ="avatar" src="' + this.avatar + '"></a></div>';
                        str += '<ul class="weibo-comment-ul">';
                        str += '<li><b>' + this.username + '</b></li>';
                        str += '<li><span>' + this.addtime + '</span></li>';
                        str += '<li><p>' + this.content + '</p></li>';
                        str += '</ul></div></div>';
                        comment_list.append(str);
                    });

                    if(total > 5){
                        var str_total = '';
                        str_total += '<div class="weibo_comment_more">';
                        str_total += '<a href="comment.php?post_id='+pid+'">后面还有'+ (total-5) +'条评论，点击查看全部></a></div>';
                        comment_list.append(str_total);
                    }
                    layer.close(index);
                }, "json");
            }
        }else{
            comment_list.children().remove();
        }
        $(this).parent().siblings(".weibo_comment").slideToggle(200);
    });

    /** 展开与关闭 **/
    $(".weibo_list_bottom .weibo_list_bottom_message").click(function(){
        $(this).toggleClass("weibo_list_bottom_message_cur");
    });

    $(".my_friend_list button").click(function(){
        $(this).toggleClass("my_friend_btn_click");
    });

    $(".my_head_message .show_btn").click(function(){
        $(this).toggleClass("show_btn_on");
    });

    $(".weibo_list_top .weibo_list_head_collect").click(function(){
        $(this).toggleClass("weibo_list_head_collect_cur");
    });

	
    /** 转发 **/
	$('a[class=forward]').live('click',function(){
		var pid = $(this).parent().attr('value');
        //iframe层
        layer.open({
            type: 2,                            //弹出框
            title: '转发帖子',                   //标题
            area:['700px','500px'],             //弹层宽高
            shade: 0.5,                         //背景透明度
            content: 'getForward.php?pid='+pid //iframe的url
        });
	})

    /** 点赞 **/
    $('a[class=praise]').live('click',function(){
        var post_id = $(this).parent().attr('value');
        var count   = $(this).children().text();
        var that    = $(this);
		console.log($(this).parent())
        $.post("praise.php",{post_id:post_id},function(re){
            if(re == 1){
                layer.msg('点赞成功！',{time:2000});
                count++;
                that.children().text(count);
            }else{
                layer.msg('您已经赞过啦！',{time:2000});
            }
        });
    });
});

/**
 * highslide展示图片效果
 */
$(function(){
    hs.graphicsDir = 'highslide/graphics/';
    hs.align = 'center';
    hs.transitions = ['expand', 'crossfade'];
    hs.wrapperClassName = 'dark borderless floating-caption';
    hs.fadeInOut = true;
    hs.dimmingOpacity = .75;

    if (hs.addSlideshow) hs.addSlideshow({
        interval: 5000,
        repeat: false,
        useControls: true,
        fixedControls: 'fit',
        overlayOptions: {
            opacity: .6,
            position: 'bottom center',
            hideOnMouseOut: true
        }
    });
});
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
					
					
					<div class="left l" id="left_c">
			<script type="text/javascript" src="js/jquery.qqFace.js"></script>
			<script>
			    $(function(){
			        $('.emotion').qqFace({
			            id : 'facebox', 
			            assign:'saybox_0', 
			            path:'face/'
			        });
			    });
			</script>
			<input type="hidden" id="hidden1" value="<?php echo $na ?>"/>
			<div class="send-weibo" style="box-shadow: 2px 2px 5px rgba(0,0,0,0.35);">
			    <div class="ui form" style="overflow: auto">
			        <div class="field">
			            <div class="content-title" style="font-size: 16px; color: #d79f34; padding: 8px 0 4px 0;">
			                随时随地，想发就发~~~
			            </div>
			            <div class="weibo-text">
			                <textarea  name="content" id="saybox_0"   onkeyup="checknum(this.value, '0')"  rows="5" onKeyPress="if(event.keyCode==13) {document.getElementById('fabu').click();}"></textarea>
			            </div>
			        </div>
			    </div>
			    <div class="send-action">
			        <span>
			            <a href="javascript:;">
			                <span class="emotion" onclick="emotion()">
			                    <i class="smile large icon"><img src="img/index_bg1.jpg"></i>表情
			                </span>
			            </a>
			        </span>
			        <span>
			            <a class="at-friend" id="A2"><i class="at large icon "><img src="img/index_bg2.jpg"></i>一下</a>
			        </span>
			        <span>
			            <a id="btn3" href="javascript:;"><i class="file image outline large icon"></i><img src="img/index_bg3.jpg" class="index_img11">图片</a>
			        </span>
			        <div class="release">
			            <span class="countTxt">还可输入<em id="sayword_0" class="count">140</em>字</span>
			            <button class="ui teal button" onclick="saysub(0)" id="fabu">发布 </button>
			        </div>
			    </div>
			    <div class="interest-link" style="display: none" id="tu1">
			        <div class="interest-search-link">好友列表</div>
			        <div class="interest-scroll">
			            <div id="friends" class="interest-scroll-content">
			                <!--@好友列表-->
			                <?php
			                    $user_lists = $db->query('SELECT username FROM friends where user_id = :user_id and status = 1',array('user_id'=>$user['id']));
			                    foreach ($user_lists as $v) { ?>
			                    <div class="interest-search-txt">
			                        <a href="javascript:;"  onclick="chooseFriend('<?php echo $v['username']?>')" >
			                            <?php echo $v['username']?>
			                        </a>
			                    </div>
			                <?php } ?>
			            </div>
			        </div>
			    </div>
			    
			</div>
			<div class="photo_upload_box_outside" id="photo_upload_box_outside" tabindex="2000">
				    <div class="photo_upload_box">
				        <a class="photo_upload_close"href="javascript:void(0);"onclick="photo_upload_close()"></a>
				        <h1>本地上传</h1>
				        <p class="upload_num">共<span id="uploaded_length">0</span>张，还能上传<span id="upload_other">9</span>张</p>
				        <ul id="ul_pics" class="ul_pics clearfix">
				            <li id="local_upload"><img src="img/local_upload.png" id="btn2"/></li>
				        </ul>
				        <div class="arrow_layer">
				            <span class="arrow_top_area"><i class="arrow_top_bg"></i><em class="arrow_top"></em></span>
				        </div>
				    </div>
				</div>
				
				<script type="text/javascript" src="js/plupload.full.min.js"></script>
			    <script type="text/javascript">
			    	var oA2=document.getElementById('A2');
			    	oA2.onclick=function(){
			    		if(tu1.style.display=='block'){
				    		tu1.style.display='none';
				    	}else{
				    		tu1.style.display='block';
				    	}
			    	}
			    	var upload_total = 9;
				    var uploader = new plupload.Uploader({
				        runtimes: 'gears,html5,html4,silverlight,flash', 
				        browse_button: ['btn3', 'btn2'], 
				        url: "upload.php", 
				        flash_swf_url: 'js/Moxie.swf',
				        silverlight_xap_url: 'js/Moxie.xap', 
				        filters: {
				            max_file_size: '5mb',
				            mime_types: [
				                {title: "files", extensions: "jpg,png,gif,jpeg"}
				            ]
				        },
				        multi_selection: true, 
				        init: {
				            FilesAdded: function(up, files) { 
				                var length_has_upload = $("#ul_pics").children("li").length;
				                if (files.length >= upload_total) { 
				                    $("#local_upload").hide();
				                }
				                var li = '';
				                plupload.each(files, function(file) { 
				                    if (length_has_upload <= upload_total) {
				                        li += "<li class='li_upload' id='" + file['id'] + "'><div class='progress'><span class='bar'></span><span class='percent'>0%</span></div></li>";
				                    }
				                    length_has_upload++;
				                });
				                $("#ul_pics").prepend(li);
				                uploader.start();
				            },
				            UploadProgress: function(up, file) {
				                var percent = file.percent;
				                $("#" + file.id).find('.bar').css({"width": percent + "%"});
				                $("#" + file.id).find(".percent").text(percent + "%");
				            },
				            FileUploaded: function(up, file, info) { 
				                showPhotoUploadBox($('#btn3'));
				                var uploaded_length = $(".img_common").length;
				                if (uploaded_length <= upload_total) {
				                    var data = eval("(" + info.response + ")");//解析返回的json数据
				                    $("#" + file.id).html("<input type='hidden'name='pic[]' value='" + data.pic + "'/><input type='hidden'name='pic_name[]' value='" + data.name + "'/>\n\
				                <img class='img_common' src='" + data.pic + "'/><span class='picbg'></span><a class='pic_close' onclick=delPic('" + data.pic + "','" + file.id + "')></a>");
				                }
				                showUploadBtn();
				            },
				            Error: function(up, err) { 
				                alert(err.message);
				            }
				        }
				    });
				    uploader.init();
				
				    function delPic(pic, file_id) { 
				        $.post("deletePic.php", {pic: pic}, function(data) {
				            $("#" + file_id).remove();
				            showUploadBtn();
				        })
				    }
				    function showUploadBtn() {
				        var uploaded_length = $(".img_common").length;
				        $("#uploaded_length").text(uploaded_length);
				        var other_length = (upload_total - uploaded_length) > 0 ? upload_total - uploaded_length : 0;
				        $("#upload_other").text(other_length);
				        var uploaded_length = $(".img_common").length;
				        if (uploaded_length >= upload_total) {
				            $("#local_upload").hide();
				        } else {
				            $("#local_upload").show();
				        }
				    }
				    function showPhotoUploadBox(obj) { 
				        var left = obj.offset().left;
				        var top = obj.offset().top + 26;
				        $("#photo_upload_box_outside").css({"left": left, "top": top}).show()
				    }
				    function photo_upload_close() {
				        $("#photo_upload_box_outside").fadeOut(500, function() {
				            $(".li_upload").remove();
				        })
				    }
			    </script>
			<h4 class="weibo_list_title">全部帖子</h4>
			<?php if(!isset($lists)){ ?>
            <div class="empty">
                <p>还没有帖子哦！</p>
            </div>
            <?php }else {?>
			<?php foreach($lists as $v){
				$avatar = $db->single('select avatar from user where id = :user_id',
                                array('user_id'=>$v['user_id']));
				 ?>
			    <div class="weibo_list">
			        <div class="weibo_list_top">
			            <div class="weibo_list_head">
			                <a href="shuoshuo.php?id=<?php echo $v['user_id'] ?>">
			                    <img class="avatar"    src="<?php echo get_cover_path($avatar) ?>" />
			                </a>
			            </div>
			            <ul>
			                <li><b><?php echo $v['username'] ?></b></li>
			                <li><span><?php echo tranTime($v['addtime']); ?></span></li>
			                <li>
			                    <p>
			                        <?php
			                        if($v['post_type'] == 2){
			                            echo $v['content'].'//'.$v['sub']['content'];
			                        }else{
			                            echo ubbReplace($v['content']);
			                        }
			                        ?>
			                    </p>
			                </li>
			                <?php  if($v['pictures']){ ?>
			                    <li>
			                        <div class="highslide-gallery">
			                            <?php foreach($v['pictures'] as $pic){ ?>
			                                <a id="aaaa" href="<?php echo $pic; ?>" class="highslide" onclick="return hs.expand(this)">
			                                    <img src="<?php echo $pic; ?>"  title="点击放大" />
			                                </a>
			                            <?php } ?>
			                    </li>
			                <?php } ?>
			            </ul>
			        </div>
			
			        <?php if($v['post_type'] == 2 ){ ?>
			            <div class="weibo_list_top" style="background: #F2F2F5">
			                <ul>
			                    <li><b><?php echo $v['sub']['parent']['username'] ?></b></li>
			                    <li><span><?php echo tranTime($v['sub']['parent']['addtime']) ?></span></li>
			                    <li>
			                        <p>
			                            <?php echo ubbReplace($v['sub']['parent']['content']) ?>
			                        </p>
			                    </li>
			                    <?php  if($v['sub']['parent']['pictures']){ ?>
			                        <li>
			                            <div class="highslide-gallery">
			                                <?php foreach($v['sub']['parent']['pictures'] as $pic){ ?>
			                                    <a id="aaaa" href="<?php echo $pic; ?>" class="highslide" onclick="return hs.expand(this)">
			                                        <img src="<?php echo $pic; ?>"  title="点击放大" />
			                                    </a>
			                                <?php } ?>
			                        </li>
			                    <?php } ?>
			                </ul>
			            </div>
			        <?php } ?>
			
			        <div class="weibo_list_bottom" value="<?php echo $v['id'] ?>" >
			            <!--转发-->
			            <a class="forward" href="javascript:;">转发
			                ( <?php echo $v['forward_num'] ?> )
			            </a>
			            <!--评论-->
			            <a class="weibo_list_bottom_message">评论
			                ( <span> <?php echo $v['comment_num'] ?> </span> )
			            </a>
			            <!--点赞-->
			            <a class="praise" href="javascript:;">点赞
			                ( <span> <?php echo $v['praise_num'] ?> </span> )
			            </a>
			        </div>
			        <div class="weibo_comment">
			            <div class="send-weibo" style="background: rgba(0,0,0,0); border-bottom: 3px solid rgba(225,225,225,0.6);">
			                <div class="ui form">
			                    <div class="field">
			                        <div class="weibo-text">
			                            <textarea  name="content" id="saybox_<?php echo $v['id'] ?>" onkeyup="checknum(this.value, <?php echo $v['id'] ?>)"  rows="5" ></textarea>
			                        </div>
			                    </div>
			                </div>
			                <div class="send-action">
			                        <span style="color: #d79f34;">
			                            评论~~~
			                        </span>
			                    <div class="release">
			                        <span class="countTxt">还可输入<em id="sayword_<?php echo $v['id'] ?>" class="count">140</em>字</span>
			                        <button class="ui teal button" onclick="saysub(<?php echo $v['id'] ?> , 'comment')">发布 </button>
			                    </div>
			                </div>
			            </div>
			
			            <div class="comment_list"></div>
			            
			        </div>
			    </div>
			<?php } ?>
			<?php	} ?>
		</div>
		<?php include("view/ri.php"); ?>
					
					
					
				</div>
			</div>
		</div>
	</div>
	
	<?php include("view/right.php"); ?>
	<?php include("view/footer.php"); ?>
	<script type="text/javascript" src="js/plupload.full.min.js"></script>
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
		var size=<?php echo $pageSize;?>;//当前的分页尺码
		var conn=size;
		var total=<?php echo $toutal;?>;//获取全部的数据
		var parentDiv=$('#left_c');
		var flag=false;//防止数据重复获取
		$(window).scroll(function(){
	    if ($(window).scrollTop() + $(window).height() >= $(document).height()-200) {
	    		if(conn < total ){
                	var index = layer.msg('数据加载中', {icon: 16});
                	$.post('ajaxHuo.php',{
                		conn:conn,
                		size:size
                	},function(data){
                		$(data).each(function(){
	                        var str = '';
							str += '<div class="weibo_list" >';
							str += '<div class="weibo_list_top" >';
							str += '<div class="weibo_list_head" >';
							str += '<a href="shuoshuo.php?id='+this.user_id+'">';
							str += '<img class="avatar" src="'+this.img+'">';
							str += '</a>';
							str += '</div>';
							str += '<ul>';
							str += '<li><b>'+this.username+'</b></li>';
			                str += '<li><span>'+this.addtime+'</span></li>';
							str += '<li><p>'+this.content+'</p></li>';
							if(this.pictures.length!=0){
								str+='<li>';
								str+='<div class="highslide-gallery">';
								for(let i=0;i<this.pictures.length;i++){
									str+='<a id="aaaa" href="'+this.pictures[i]+'" class="highslide"  onclick="return hs.expand(this)">';
									str+='<img src="'+this.pictures[i]+'" title="点击放大">';
									str+='</a>';
								}
								str+='</div>';
								str+='</li>';
							}
							str += '</ul>';
							str += '</div>';
							//如果是转发机制
							if(this.post_type==2){
								str += '<div class="weibo_list_top" style="background: #F2F2F5">';
								str += '<ul>';
								str += '<li><b>'+this.sub.parent.username+'</b></li>';
								str += '<li><span>'+this.sub.parent.addtime+'</span></li>';
								str += '<li><p>'+this.sub.parent.content+'</p></li>';
								if(this.sub.parent.pictures.length!=0){
									str+='<li>';
									str+='<div class="highslide-gallery">';
									for(let i=0;i<this.sub.parent.pictures.length;i++){
										str+='<a id="aaaa" href="'+this.sub.parent.pictures[i]+'" class="highslide"  onclick="return hs.expand(this)">';
										str+='<img src="'+this.sub.parent.pictures[i]+'" title="点击放大">';
										str+='</a>';
									}
									str+='</div>';
									str+='</li>';
								}
								str += '</ul>';
								str += '</div>';
							}

							str += '<div class="weibo_list_bottom" value='+this.id+'>';
							str += '<a class="forward" href="javascript:;">';
							str += '转发('+this.forward_num+')';
							str += '</a>';
							str += '<a class="weibo_list_bottom_message" href="javascript:;">';
							str += '评论(<span>'+this.comment_num+'</span>)';
							str += '</a>';
							str += '<a class="praise" href="javascript:;">';
							str += '点赞(<span>'+this.praise_num+'</span>)';
							str += '</a>';
							str += '</div>';
							str += '<div class="weibo_comment" >';
							str += '<div class="send-weibo" style="background: rgba(0,0,0,0); border-bottom: 3px solid rgba(225,225,225,0.6);">';
							str += '<div class="ui form" >';
							str += '<div class="field" >';
							str += '<div class="weibo-text" >';
							str += '<textarea name="content" id="saybox_'+this.id+'"  onkeyup="checknum(this.value,'+this.id+')"  rows="5" ></textarea>';
							str += '</div>';
							str += '</div>';
							str += '</div>';
							str += '<div class="send-action" >';
							str += '<span style="color: #d79f34;">';
							str += '评论~~~';
							str += '</span>';
							str += '<div class="release" >';
							str += '<span class="countTxt" >';
							str += '还可输入';
							str += '<em id="sayword_'+this.id+'" class="count">140</em>';
							str += '</span>';
							str += '<button class="ui teal button" onclick="saysub('+this.id+' , \'comment\')"  rows="5" >发布</button>';
							str += '</div>';
							str += '</div>';
							str += '</div>';
							str += '<div class="comment_list" >';
							str += '</div>';
							str += '</div>';
							str += '</div>';
	                        parentDiv.append(str);
	                    });
						layer.close(index);
                	}, "json")
                	conn+=size;
	    		}
	        }
	    });
	</script>
</body>
</html>
