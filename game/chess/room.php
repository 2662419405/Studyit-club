<?php
require('library/Db.class.php');
require("library/function.php");
is_login();
session_start();
$db = new Db();
$username=$_COOKIE['chess_name'];
$info=$db->row("select * from tb_room where id = '".$_GET['id']."'");
if(!$info){
    header("location:index.php");           //跳转到游戏首页
    exit;
}
$name = $info['name'];       //查询游戏的房间号
$guest = $info['guest'];         //查询客户端名称
$host = $info['host'];       //查询服务器名称
$chess = $info['chess'];         //查询全部棋子所在位置
$flag = $info['flag'];       //查看标记
$guest_win = $info['guest_win'];      //查看客户端的赢局记录
$host_win = $info['host_win'];       //查看服务器端的赢局记录
if($guest != '' && $host != '' && $username != $guest && $username != $host){
    header("location:index.php");                 //跳转到游戏首页
    exit;        //退出
}
if($host != '' && $guest == '' && $username != $host){
    header("location:join.php?roomid=".$_GET['id']);         //跳转到加入游戏页面
    exit;        //退出
}
/*if($host == '' && $guest != '' && $username != $guest){
    header("location:join.php?roomid=".$_GET['id']);         //跳转到加入游戏页面
    exit;        //退出
}*/
if(isset($_COOKIE['message'])){          //如果信息存储到Cookie中，则输出Cookie中的聊天信息
    echo "<script>alert('".$_COOKIE['message']."');</script>";
    setcookie("message", null);          //设置Cookie中的信息
}
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>IT俱乐部--<?php echo $name."房间";?></title>
    <link rel="stylesheet" href="css/room.css" />
    <script src="chessrule.js"></script>
    <link rel="shortcut icon" href="../../ico/it.ico" />
    <script>
        function copy_url(){            //自定义复制网址函数
            if(window.clipboardData && window.clipboardData.setData){
                window.clipboardData.setData('text',document.location.href);
                alert('复制成功！Ctrl + V 把地址发送给好友');
            }else{
                alert('您的浏览器不支持该复制功能，请使用Ctrl + C或鼠标右键进行复制');
            }
        }
    </script>
    <script>
        var allow_load = <?php
                    if(($username == $guest && $flag == "guest") || ($username == $host && $flag == "host"))
                        echo 0;
                    else
                        echo 1;
                  ?>;
        var site = "<?php echo $username != $host?'guest':'host';?>";
        var site_num = "<?php echo $username == $guest?'0':'1';?>";
        //房主：红棋（1），客人：黑棋（0）
        var flag = "<?php echo $flag;?>";//初始化标记变量
        var guest = "<?php echo $guest;?>";//获取黑棋玩家名称
        var host = "<?php echo $host;?>";//获取红棋玩家名称
        var now_chess = "";//初始化当前棋子的变量为空
        var moved = "";//初始化移动棋子的变量为空
        var eated = "";//初始化吃棋的变量
        var pause_time = 0;//初始化发布信息的时间
        var prompt_pause_time = 0;//初始化提示信息的时间
        var guest_win = <?php echo $guest_win;?>;//黑棋方的赢局次数
        var host_win = <?php echo $host_win;?>;//红棋方的赢局次数
        var game_ended = 0;//初始化游戏结束标记
        var t3 = "";
        function form_chess(chess){       //自定义函数
            now_chess = chess;//对当前棋子的变量重新赋值
            var chess_split = chess.split(",");//分割棋子字符串为数组
            var pla = "<table width=556 height=601 border=0 cellpadding=0 cellspacing=0 bordercolor=#000000 background=images/bg.png><tr><td><table align=center border=0 cellpadding=0 cellspacing=0 width=540 height=601>";
            if(site == "host")
                for(var i = 0;i < 10;i ++){          //设置棋盘中主机的棋子10行9列，并布置主机棋子位置
                    pla += "<tr>";
                    for(j = 0;j < 9;j ++){
                        pla += "<td><div id=chess_"+(i * 9 + j + 1)+"><input type=hidden name=chess_value_"+(i * 9 + j + 1)+" id=chess_value_"+(i * 9 + j + 1)+" value="+chess_split[i * 9 + j]+"><a href=javascript:click_chess("+(i * 9 + j + 1)+")><img alt="+chess_split[i * 9 + j]+","+(i * 9 + j + 1)+" src=images/"+chess_split[i * 9 + j]+".png border=0 width=58px height=58px></a></div></td>";
                    }
                    pla += "</tr>";
                }
            else
                for(var i = 9;i >= 0;i --){          //设置棋盘中客机的棋子10行9列，并布置客机棋子位置
                    pla += "<tr>";
                    for(j = 8;j >= 0;j --){
                        pla += "<td><div id=chess_"+(i * 9 + j + 1)+"><input type=hidden name=chess_value_"+(i * 9 + j + 1)+" id=chess_value_"+(i * 9 + j + 1)+" value="+chess_split[i * 9 + j]+"><a href=javascript:click_chess("+(i * 9 + j + 1)+")><img alt="+chess_split[i * 9 + j]+","+(i * 9 + j + 1)+"  src=images/"+chess_split[i * 9 + j]+".png  border=0 width=58px height=58px></a></div></td>";
                    }
                    pla += "</tr>";
                }
            pla += "</table></td></tr></table>";
            return pla;
        }
        var prev_click = "";//初始化上一个单击的棋子的变量
        var chess_flash = "";//初始化棋子闪烁的变量
        var flash_status = 0;//初始化棋子闪烁状态的变量
        var message_guest = "";//初始化黑棋玩家聊天信息的变量
        var message_host = "";//初始化红棋玩家聊天信息的变量
        var prev_message_guest = "";//初始化黑棋玩家上一条聊天信息的变量
        var prev_message_host = "";//初始化红棋玩家上一条聊天信息的变量
        function click_chess(num){          //单击棋子操作
            if(site != flag)               //如果当前的site值不等于棋子的走棋标记,弹出对方执棋提示信息
                open_prompt("对方执棋！", '40%', '2%');
            else{                       //否则执行走棋操作
                close_prompt();                //关闭提示信息，设置为隐藏
                for(var i = 1;i < 91;i ++)
                    document.getElementById("chess_"+i).style.visibility = "visible";        //设置棋子可见
                chess_flash = "";//棋子闪烁的变量定义为空
                if(document.getElementById("chess_value_"+num).value.substr(0, 1) == site_num){
                    chess_flash = num;//将当前单击的棋子定义为闪烁的棋子
                    prev_click = num;        //记录棋子当前位置
                }else{
                    if(prev_click != ""){     //如果棋子的走棋方法不对，则弹出提示
                        if(!check(document.getElementById('chess_value_'+prev_click).value, prev_click, num))
                            open_prompt("您的操作有误！", '40%', '2%');
                        else{//执行吃棋操作，将房间号、棋子的原始坐标点、目标坐标点传递到submit.php页面
                            send_request("submit.php?roomid=<?php echo $_GET['id'];?>&from="+prev_click+"&to="+num+"&site="+site+"&time="+Math.random());
                            allow_load = 1;//为变量赋值
                            prev_click = "";//将上一单击棋子的值设置为空
                        }
                    }else
                        open_prompt("这不是您的棋子！", '40%', '2%');//打开提示框
                }
            }
        }
        var prompt_count = 0;//初始化变量
        function open_prompt(message, top, left){           //输出提示框所在的位置
            prompt_count = 1;//将变量值设置为1
            prompt_pause_time ++;                       //计时按每1秒进行累计
            if(message){//如果聊天信息不为空
                document.getElementById("item").style.visibility = "visible";//设置元素可见
                document.getElementById("item").style.align = "center";//设置元素居中显示
                document.getElementById("item").style.top = top ;//设置元素到顶部的距离
                document.getElementById("item").style.left = left ;//设置元素到左侧的距离
                document.getElementById("item").innerHTML =  '<table class=message_box><tr><td valign=middle>系统提示：<br><br>&nbsp;&nbsp;'+message+'</td></tr></table>';//设置元素中显示的内容
            }
        }
        function close_prompt(){         //关闭提示信息，设置为隐藏
            document.getElementById("item").style.visibility = "hidden";//设置元素为隐藏
            document.getElementById("item").innerHTML =  '';//设置元素中的内容为空
            prompt_pause_time = 0;          //计时功能初始化为0
        }
        var http_request = false;
        function send_request(url) {
            open_prompt((prompt_pause_time > 0?'等待对方响应（'+prompt_pause_time+'秒）':''), '40%', '2%');
            if (window.XMLHttpRequest) { //创建XMLHTTPRequest对象
                http_request = new XMLHttpRequest();
                if (http_request.overrideMimeType) {
                    http_request.overrideMimeType('text/xml');
                }
            } else if (window.ActiveXObject) { //创建XMLHTTP对象
                try {
                    http_request = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (e) {
                    try {
                        http_request = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch (e) {}
                }
            }
            if (!http_request) {//如果http_request的值为假，则不能创建对象
                alert('不能创建 XMLHttpRequest 对象!');
                return false;
            }
            http_request.onreadystatechange = processRequest;//指定回调方法
            http_request.open('GET', url, true);//用GET方法提交数据
            http_request.send(null);//发送的信息为空
        }
        var resultDiv;//定义创建div元素的变量
        var text = new Array();//定义空数组
        function processRequest() {             //设置棋盘中的提示信息框
            if (http_request.readyState == 4 && http_request.status == 200) {//如果请求已完成并发送成功
                if(http_request.responseText == "ended")//如果服务器返回值为ended
                    document.location.href = "index.php";//页面跳转到游戏首页
                text = http_request.responseText.split("|");//将返回值以|进行分割并返回数组
                if(http_request.responseText){//如果返回值为真
                    t3 = text[3];//获取被吃棋子的值
                    message_guest = decodeURI(text[8]);//获取黑棋棋主聊天信息
                    message_host = decodeURI(text[9]);//获取红棋棋主聊天信息
                    guest_win = text[6];//获取黑棋棋主赢棋次数
                    host_win = text[7];//获取红棋棋主赢棋次数
                    if(text[4] != guest){//如果黑棋玩家名称有变化
                        if(text[4] == ""){//如果黑棋玩家名称为空
                            open_prompt(guest+"退出游戏房间！", '40%', '2%');//打开提示框
                            guest = "";//将黑棋玩家名称定义为空
                            prompt_pause_time = 0;//将提示框中的时间定义为0
                            allow_load = 0;//为变量赋值
                        }else{
                            open_prompt(text[4]+"进入游戏房间！", '40%', '2%');//打开提示框
                            guest = text[4];//重新定义黑棋玩家名称
                            flag = text[1];//重新定义当前走棋标志
                            document.getElementById("pla").innerHTML = form_chess(text[0]);//对棋盘进行重新布局
                        }
                    }
                    if(text[5] != host){//如果红棋玩家名称有变化
                        if(text[5] == ""){//如果红棋玩家名称为空
                            open_prompt(host+"退出游戏房间，您已成为房主！", '40%', '2%');//打开提示框
                            host = "";//将红棋玩家名称定义为空
                            prompt_pause_time = 0;//将提示框中的时间定义为0
                            allow_load = 0;//为变量赋值
                            if(site == 'guest'){//如果执行当前操作的是黑棋玩家
                                setTimeout("location.href = 'join.php?roomid=<?php echo $_GET['id'];?>'",1000);//过1秒钟重新加入游戏
                            }
                        }
                    }
                }
                if(now_chess != text[0] && text[0]){//如果棋盘棋子有变化
                    document.getElementById("pla").innerHTML = form_chess(text[0]);//对棋子重新布局
                    flag = text[1];//重新定义当前走棋标志
                    moved = text[2];//重新定义当前移动的棋子
                    if(site == flag)//如果执行当前操作的是要走棋的玩家
                        allow_load = 0;//为变量赋值
                    if(text[3] == "000" && site == "guest"){//如果黑棋“将”被吃，则黑棋执行如下语句
                        resultDiv = document.createElement("div");//创建div元素
                        resultDiv.className = "imgDiv";//为div设置class属性值
                        resultDiv.innerHTML = "<img src='images/failure.png' width='100%' height='100%'>";//为div设置图片
                        document.body.appendChild(resultDiv);//向body中添加div元素
                        setTimeout("document.body.removeChild(resultDiv)",3000);//过3秒钟移除div元素
                        eated = text[3];//将被吃的棋子赋值给变量eated
                        game_ended = 1;//将游戏结束变量值定义为1
                        allow_load = 1;//为变量赋值
                        prompt_pause_time = 0;//将提示框中的时间定义为0
                    }else if(text[3] == "100" && site == "host"){  //如果红棋“帅”被吃，则红棋执行如下语句
                        resultDiv = document.createElement("div");//创建div元素
                        resultDiv.className = "imgDiv";//为div设置class属性值
                        resultDiv.innerHTML = "<img src='images/failure.png' width='100%' height='100%'>";//为div设置图片
                        document.body.appendChild(resultDiv);//向body中添加div元素
                        setTimeout("document.body.removeChild(resultDiv)",3000);//过3秒钟移除div元素
                        eated = text[3];//将被吃的棋子赋值给变量eated
                        game_ended = 1;//将游戏结束变量值定义为1
                        prompt_pause_time = 0;//将提示框中的时间定义为0
                    }else if(text[3] == "000" && site == "host"){  //如果黑棋“将”被吃，则红棋执行如下语句
                        resultDiv = document.createElement("div");//创建div元素
                        resultDiv.className = "imgDiv";//为div设置class属性值
                        resultDiv.innerHTML = "<img src='images/success.png' width='100%' height='100%'>";//为div设置图片
                        document.body.appendChild(resultDiv);//向body中添加div元素
                        setTimeout("document.body.removeChild(resultDiv)",3000);//过3秒钟移除div元素
                        eated = text[3];//将被吃的棋子赋值给变量eated
                        game_ended = 1;//将游戏结束变量值定义为1
                        prompt_pause_time = 0;//将提示框中的时间定义为0
                    }else if(text[3] == "100" && site == "guest"){ //如果红棋“帅”被吃，则黑棋执行如下语句
                        resultDiv = document.createElement("div");//创建div元素
                        resultDiv.className = "imgDiv";//为div设置class属性值
                        resultDiv.innerHTML = "<img src='images/success.png' width='100%' height='100%'>";//为div设置图片
                        document.body.appendChild(resultDiv);//向body中添加div元素
                        setTimeout("document.body.removeChild(resultDiv)",3000);//过3秒钟移除div元素
                        eated = text[3];//将被吃的棋子赋值给变量eated
                        game_ended = 1;//将游戏结束变量值定义为1
                        prompt_pause_time = 0;//将提示框中的时间定义为0
                    }else if(text[3] && eated != text[3] && text[3] != 'blank'){   //如果有新的棋子被吃
                        eated = text[3];//将被吃的棋子赋值给变量eated
                    }
                }
            }
        }
        function send_message(){             //定义发送聊天信息的函数
            var message = document.getElementById('message').value;//获取玩家聊天信息
            if(message != ''){             //如果聊天信息不为空
                var message = encodeURI(encodeURI(message));//对聊天信息进行编码
                send_request('send_message.php?roomid=<?php echo $_GET['id'];?>&message='+message+'&site='+site+'&random='+Math.random());//将聊天信息存储在数据表中
                document.getElementById('message').value = '';                   //消息框清空
                open_prompt('消息发送成功！', '40%', '2%');                     //弹出消息框
            }
        }
    </script>
</head>
<body>
<table align="center" style="padding-top:5%;">
    <tr>
        <td width="210" rowspan="3" valign="top">
            <table width="191" height="100%" border="0" cellpadding="0" cellspacing="0">
                <tr valign="top">
                    <script>document.write("<td height=240 valign='bottom' nowrap background='images/"+(site=='host'?'left1':'left2')+".png'>")</script>
                        <table width="191" height="60" border="0">
                            <tr>
                                <th width="40" height="30" align="right" valign="middle"><div id="top_box_flag" width="100%"></div></th>
                                <th width="130" height="30" align="left" valign="middle"><div id="top_box" width="100%"></div></th>
                                <th width="22" height="30" align="left" valign="middle"></th>
                            </tr>
                            <tr>
                                <td height="30" align="left" valign="middle"></td>
                                <td height="30" align="left" valign="top"><div id="top_box_tongji" width="100%"></div></td>
                                <td height="30" align="left" valign="middle"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="191" height="126" align="center">
                        <a href="javascript:copy_url()"><img src="images/left3.png" style="margin-top:6px;"></a>
                        <script>document.write("<a href=exit.php?roomid=<?php echo $_GET['id'];?>&site="+site+"><img src='images/btn_exit.png' width=90 height=39 style='margin-top:8px;'></a>");</script>
                        <script>if(site == "host") document.write("<a href=end.php?roomid=<?php echo $_GET['id'];?>><img src='images/btn_end.png' width=90 height=39 border=0></a>");</script><br>
                    </td>
                </tr>
                <tr valign="bottom">
                    <script>document.write("<td height=240 valign='bottom' nowrap background='images/"+(site=='host'?'left2':'left1')+".png'>")</script>
                        <table width="191" height="60" border="0">
                            <tr><th width="40" height="30" align="right"><div id=bottom_box_flag width=100%></div></th>
                                <th width="130" align="left"><div id=bottom_box width=100%></div></th>
                                <th width="22" align="left"></th>
                            </tr>
                            <tr><td height="30" align="left"></td>
                                <td height="30" align="left" valign="top"><div id=bottom_box_tongji width=100%></div></td>
                                <td height="30" align="left"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <td width="3" rowspan="3">
            <!--显示棋盘-->
            <div id="pla"></div>
        </td>
        <td width="240" align="right" valign=top>
            <table style="position:relative;">
                <tr>
                    <td><img src="images/sign.png" width="220" height="63"></td>
                </tr>
                <tr>
                    <td><img src="images/roomcode.png" width="220" height="70"><div class="roomcode"><?php echo $name;?></div></td>
                </tr>
                <tr>
                    <td width="220" height="260"><div id="item" style="position:absolute; left:0px; top:0px; z-index:1; visibility: hidden;"></div></td>
                </tr>
                <tr>
                    <td width="220" height="201" valign=bottom>
                        <table class="message" cellspacing="0" cellpadding="0">
                            <tr align="left">
                                <td height="45" colspan="3" scope="col" valign=middle>&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="15"></td>
                                <td><div id="message_pla" class="message_chat"></div></td>
                                <td width="15"></td>
                            </tr>
                            <tr>
                                <td height="45" colspan="3" valign="middle" class="message_td">
                                    <input type="text" id="message" name="message" size="18" onBlur="this.focus();" onKeyPress="if(event.keyCode==13) {document.getElementById('button').click();}" />
                                    <input name="button" id="button" type="button" class="message_btn" onClick="send_message()" value="发送" />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<script>
    var message_sum = 5;                               //每屏显示5条信息
    var message_arr = new Array();//定义空数组
    function show_message(message){                      //输出聊天记录信息
        var div = document.getElementById("message_pla");//获取指定的div元素
        if(message_arr.length < message_sum){     //如果聊天记录的条数小于5条，那么输出全部的聊天信息
            div.innerHTML += message;
            message_arr[message_arr.length] = message;
            div.scrollTop = div.scrollHeight;     //滚动条始终保持在底部
        }else{                                     //如果聊天记录条数大于5条
            for(var i = 1;i < message_sum;i ++){            //获取聊天记录的数组从0到4的下标，
                message_arr[i - 1] = message_arr[i];
            }
            message_arr[message_sum - 1] = message;       //将聊天信息存储在数组中，存取5条聊天记录
            div.innerHTML = "";    //聊天记录设置为空
            for(var i = 0;i < message_sum;i ++){              //应用for循环语句输出数组中的5条聊天记录
                div.innerHTML += message_arr[i];
            }
            div.scrollTop = div.scrollHeight;//滚动条始终保持在底部
        }
    }
    function get_info() {               //定义get_info()函数
        if(guest && message_guest && prev_message_guest != message_guest){  //如果黑棋玩家聊天信息有变化
            show_message(guest + "：" + message_guest+"<br />");//输出黑棋玩家聊天信息
            prev_message_guest = message_guest;//将当前聊天信息定义为上一条聊天信息
        }
        if(host && message_host && prev_message_host != message_host){ //如果红棋玩家聊天信息有变化
            show_message(host + "：" + message_host+"<br />");//输出红棋玩家聊天信息
            prev_message_host = message_host;//将当前聊天信息定义为上一条聊天信息
        }
        if (site == "guest") {                //如果执行当前操作的是黑棋玩家
            document.getElementById('top_box').innerHTML = "<font class='style4'>" + host + "</font>";//定义指定元素中的内容
            document.getElementById('bottom_box').innerHTML = guest;//定义指定元素中的内容
            document.getElementById('top_box_tongji').innerHTML = "<font class='style4'>获胜：" + host_win + " 局</font>";//定义指定元素中的内容
            document.getElementById('bottom_box_tongji').innerHTML = "获胜：" + guest_win + " 局";//定义指定元素中的内容
            if (flag == "guest") {             //如果当前要走棋的是黑棋玩家
                //黑棋玩家输出走棋图标
                document.getElementById('bottom_box_flag').innerHTML = "<img src='./images/move.gif' width='27' height='16'>";
                document.getElementById('top_box_flag').innerHTML = "";//将元素中的内容定义为空
            }
            else {
                //红棋玩家输出走棋图标
                document.getElementById('top_box_flag').innerHTML = "<img src='./images/move.gif' width='27' height='16'>";
                document.getElementById('bottom_box_flag').innerHTML = "";//将元素中的内容定义为空
            }
        } else if (site == "host") {               //如果执行当前操作的是红棋玩家
            document.getElementById('bottom_box').innerHTML = "<font class='style4'>" + host + "</font>";//定义指定元素中的内容
            document.getElementById('top_box').innerHTML = guest;//定义指定元素中的内容
            document.getElementById('bottom_box_tongji').innerHTML = "<font class='style4'>获胜：" + host_win + " 局</font>";//定义指定元素中的内容
            document.getElementById('top_box_tongji').innerHTML = "获胜：" + guest_win + " 局";//定义指定元素中的内容
            if (flag == "host") {              //如果当前要走棋的是红棋玩家
                //红棋玩家输出走棋图标
                document.getElementById('bottom_box_flag').innerHTML = "<img src='./images/move.gif' width='27' height='16'>";
                document.getElementById('top_box_flag').innerHTML = "";//将元素中的内容定义为空
            }
            else {
                //黑棋玩家输出走棋图标
                document.getElementById('top_box_flag').innerHTML = "<img src='./images/move.gif' width='27' height='16'>";
                document.getElementById('bottom_box_flag').innerHTML = "";//将元素中的内容定义为空
            }
        }
        if(chess_flash != ""){//如果闪烁棋子变量的值不为空
            if(flash_status == 0){//如果闪烁状态变量值为0
                document.getElementById("chess_"+chess_flash).style.visibility = "hidden";//将该棋子设置为隐藏
                flash_status = 1;//将闪烁状态变量值定义为1
            }else{
                document.getElementById("chess_"+chess_flash).style.visibility = "visible";//将该棋子设置为可见
                flash_status = 0;//将闪烁状态变量值定义为0
            }
        }
        if(moved){    //如果有棋子移动
            var moved_split = moved.split(",");//将moved值以逗号为分割符分割为数组
            document.getElementById("chess_"+moved_split[0]).className = "moved";  //为数组中第一个元素值添加样式
            document.getElementById("chess_"+moved_split[1]).className = "moved";  //为数组中第二个元素值添加样式
        }
        if(allow_load == 1){
            pause_time = 0;             //初始化变量
            send_request('get_info.php?roomid=<?php echo $_GET['id'];?>&site='+site+'&random='+Math.random());//获取棋盘信息
            //移除棋子的超链接开始标记<a>
            document.getElementById("pla").innerHTML = document.getElementById("pla").innerHTML.replace(/<a(.*?)>/ig, "");
            //移除棋子的超链接结束标记</a>
            document.getElementById("pla").innerHTML = document.getElementById("pla").innerHTML.replace(/<\/a>/ig, "");
        }
        if(pause_time == 3 || host == "" || guest == ""){
            pause_time = 0;//为变量赋值
            send_request('get_info.php?roomid=<?php echo $_GET['id'];?>&site='+site+'&random='+Math.random());       //获取棋盘信息
        }
        pause_time ++;          //计时器自加1操作
        if(prompt_count > 0){//如果变量值大于0
            if(prompt_count == 3){//如果变量值等于3
                prompt_count = 0;//将变量值重新定义为0
                close_prompt();//关闭提示框
            }else
                prompt_count ++;//将变量值执行加1操作
        }
        if(game_ended == 1)//如果游戏结束变量值为1
            game_ended ++;//将变量执行加1操作
        else if(game_ended == 2){//如果游戏结束变量值为2
            if(site == "host"){//如果执行当前操作的是红棋玩家
                if(t3 == "100")//如果红棋“帅”被吃
                    guest_win ++;        //黑棋方赢一场次，在数据表中加1
                else
                    host_win ++;         //红棋方赢一场次，在数据表中加1
                send_request("restart.php?roomid=<?php echo $_GET['id'];?>&guest_win="+guest_win+"&host_win="+host_win+'&random='+Math.random());     //记录当前棋盘胜负，重新开局
                game_ended = 0;//将游戏结束变量值定义为0
            }
        }
    }
    //为象棋棋子进行初始布局
    send_request('get_info.php?roomid=<?php echo $_GET['id'];?>&site='+site+'&random='+Math.random());
    get_info();//执行函数
    setInterval("get_info()", 1000);//每隔一秒执行一次函数
</script>
</body>