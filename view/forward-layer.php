<?php include_once("view/headd.html"); ?>
<script type="text/javascript" src="js/jquery.js" ></script>
<script>
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
function saysub(pid,type) {
    /**检测字数**/
    var content = $('#saybox_'+ pid).val();
    var check_result = checkWordsNumber(content);
    if(check_result){
    	alert(check_result);
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

    /**微博类型**/
    if(type == 'comment'){
        type = 1;
    }else if(type == 'forward'){
        type = 2;
    }else{
        type = 0;
    }

    /**ajax提交**/
    $.post("ajaxAction.php", {pid:pid,type:type,content:content,pictures:pics}, function(data) {
        if (data == -1) {
        	alert('请先登录');
        	window.location.href='login.php';
            return false;
        }
        alert('发布成功');
        window.location.reload();
    })
}
</script>
<body style="background-color: #f2f2f2">
<!-- 引入头部菜单-->
<div class="main">
    <div class="left weibo_list_forward">
        <div class="weibo_list " style="box-shadow: 2px 2px 5px rgba(0,0,0,0);">
            <div class="weibo_comment" style="overflow: hidden; display: block;box-shadow: 2px 2px 5px rgba(0,0,0,0);">
                <!-- 微博回复框开始 -->
                <div class="send-weibo">
                    <div class="ui form" style="">
                        <div class="field">
                            <div class="weibo-text">
                                <textarea name="content" id="saybox_<?php echo $pid ?>" onkeyup="checknum(this.value, '0')" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="send-action">
                        <span style="color: #d79f34;">
                            最新转发~~~
                        </span>
                        <div class="release">
                            <span class="countTxt">还可输入<em id="sayword_0" class="count">140</em>字</span>
                            <button class="ui teal button" onclick="saysub(<?php echo $pid ?> , 'forward')">转发</button>
                        </div>
                    </div>
                </div>
                <!-- 微博回复框结束-->

                <!--转发数据开始-->
                <?php if(isset($lists)){ ?>
                    <div class="comment_list">
                        <!-- 示例数据 ,请在此更改样式-->
                        <?php foreach($lists as $v) { ?>
                            <div class="weibo_list">
                                <div class="weibo_list_top">
                                    <div class="weibo_list_head">
                                        <a href="<?php echo "homepage.php?friend_id=".$v['user_id'] ?>">
                                            <img class="avatar"   src="<?php echo get_cover_path($v['avatar']) ?>"  />
                                        </a>
                                    </div>
                                    <ul>
                                        <li><b><?php echo $v['username'] ?></b></li>
                                        <li><span><?php echo tranTime($v['addtime']); ?></span></li>
                                        <li><p><?php echo ubbReplace($v['content']); ?></p></li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($total_forword > 2){ ?>
                        <div class="weibo_comment_more">
                            <a class="more-forward"  value="<?php echo $pid ?>">
                                查看所有<?php echo $total_forword ?>条转发
                            </a>
                        </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <!--转发数据结束-->
            </div>
        </div>
    </div>
</div>
</body>
</html>