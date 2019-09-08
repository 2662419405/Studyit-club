<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	session_start();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	
	?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>论坛中心</title>
		<link href="css/autocomplete.css" rel="stylesheet">
	    <link href="css/forum.css" rel="stylesheet">
	    <link href="css/mod-dz-1.css" rel="stylesheet">
	    <link href="css/style_6_common.css" rel="stylesheet">
	    <link href="css/style_6_forum_index.css" rel="stylesheet">
	    <link href="css/style_6_widthauto.css" rel="stylesheet">
	    <link href="css/bootstrap.min.css" rel="stylesheet">
	    <?php include("css/main.html"); ?>
		<?php include("view/head.php"); ?>
		<?php include("css/setting.html"); ?>
		<?php include("css/footer.html"); ?>
		<?php include("css/chat.html"); ?>
	</head>
	<body>
		<?php include("view/header.php"); ?>
		<div id="chat_content">
			
			<div class="container-fluid" >
		<nav class="navbar bg-success" >
		</nav>
	</div>

<div class="container-fluid" >
	<div class="bm bmw  flg cl con01" style="background-color: #ffffff;" >
      <div class="bm_h cl" style="position: relative;background-color: #ffffff;" >
        <span class="o" >
          <img id="category_8702_img" src="img/collapsed_no.gif" title="收起/展开" alt="收起/展开" onclick="toggle_collapse('category_8701');">
        </span>
        <h4 >
        	<i class="jg"></i>
			<a href="javascript:void(0)">编程语言 专区</a>
        </h4>
      </div>
      
      
      <div id="category_8701" class="bm_c" >
        
			<table class="fl_tb" >
          <tbody class="js-hover">
            <tr class="fl_row">
            	<td class="fl_g" width="32.9%">
                <div class="fl_icn_g" style="width: 200px;">
                  <a href="c.php"><img src="img/language_length3.png" alt="Oracle" align="left"></a>
                </div>
                  <dl style="margin-left: 200px;">
                    <dt>
                       <a href="c.php" class="game-title">C语言</a>
                       <em class="game-todayposts" title="今日"></em>
                    </dt>
                    <dd class="game-desc">
                       <a href="c.php" style="color: red;">由于开发人数有限,目前只开放C语言专区</a>
                    </dd> 
                  </dl>
              </td>
              <td class="fl_g" width="32.9%">
                <div class="fl_icn_g" style="width:200px;">
                  <a href="javascript:void(0)"><img src="img/language_length2.png" alt="MySQL" align="left"></a>
                </div>
                  <dl style="margin-left:200px;">
                    <dt>
                       <a href="javascript:void(0)" class="game-title">Android</a>
                       <em class="game-todayposts" title="今日"></em>
                    </dt>
                    <dd class="game-desc">
                       <a href="javascript:void(0)"  class="text-nowrap">Android如何能够学习好</a>|
                       <a href="javascript:void(0)"  class="text-nowrap">Android做一个简单的小游戏</a>|
                       <a href="javascript:void(0)"  class="text-nowrap">为何Android比苹果卡呢</a>
                    </dd> 
                  </dl>
              </td>
              <td class="fl_g" width="32.9%">
                <div class="fl_icn_g" style="width:200px;">
                  <a href="javascript:void(0)"><img src="img/language_length1.png" alt="SQLSever" align="left"></a>
                </div>
                  <dl style="margin-left: 200px;">
                    <dt>
                       <a href="javascript:void(0)" class="game-title">JAVA专区</a>
                       <em class="game-todayposts" title="今日"></em>
                    </dt>
                    <dd class="game-desc">
                       <a href="javascript:void(0)"  class="text-nowrap">JAVA为何分为好几个版本</a>|
                       <a href="javascript:void(0)"  class="text-nowrap">初识JAVA跟我来</a>|
                       <a href="javascript:void(0)"  class="text-nowrap">JAVA注意事项|</a>
                       <a href="javascript:void(0)"  class="text-nowrap">JAVA为何一直这么火</a>
                    </dd>
                  </dl>
              </td>
            </tr>
            <tr class="fl_row">
              <td class="fl_g" width="32.9%">
                <div class="fl_icn_g" style="width: 200px;">
                  <a href="javascript:void(0)"><img src="img/language_length5.png" alt="Java" align="left"></a>
                </div>
                  <dl style="margin-left: 200px;">
                    <dt>
                       <a href="javascript:void(0)" class="game-title">Java Web</a>
                       <em class="game-todayposts" title="今日"></em>
                    </dt>
                    <dd class="game-desc">
                       <a href="javascript:void(0)"  class="text-nowrap">JAVAweb和java的区别</a>|
                       <a href="javascript:void(0)"  class="text-nowrap">初识JAVA跟我来</a>|
                       <a href="javascript:void(0)"  class="text-nowrap">Java Web注意事项|</a>
                       <a href="javascript:void(0)"  class="text-nowrap">Java Web为何一直这么火</a>
                    </dd>
                  </dl>
              </td>
              <td class="fl_g" width="32.9%">
                <div class="fl_icn_g" style="width: 200px;">
                  <a href="javascript:void(0)"><img src="img/language_length6.png" alt="Java" align="left"></a>
                </div>
                  <dl style="margin-left: 200px;">
                    <dt>
                       <a href="javascript:void(0)" class="game-title">PHP</a>
                       <em class="game-todayposts" title="今日"></em>
                    </dt>
                    <dd class="game-desc">
                       <a href="javascript:void(0)" >由于目前人数有限，暂时不开放这么多板块</a>
                    </dd>
                  </dl>
              </td>
              <td class="fl_g" width="32.9%">
                <div class="fl_icn_g" style="width: 200px;">
                  <a href="javascript:void(0)"><img src="img/language_length7.png" alt="Java" align="left"></a>
                </div>
                  <dl style="margin-left: 200px;">
                    <dt>
                       <a href="javascript:void(0)" class="game-title">.Net</a>
                       <em class="game-todayposts" title="今日"></em>
                    </dt>
                    <dd class="game-desc">
                       <a href="javascript:void(0)" >由于目前人数有限，暂时不开放这么多板块</a>
                    </dd>
                  </dl>
              </td>
            </tr>
            <tr class="fl_row">
              <td class="fl_g" width="32.9%">
                <div class="fl_icn_g" style="width: 200px;">
                  <a href="javascript:void(0)"><img src="img/language_length8.png" alt="Java" align="left"></a>
                </div>
                  <dl style="margin-left: 200px;">
                    <dt>
                       <a href="javascript:void(0)" class="game-title">JSP</a>
                       <em class="game-todayposts" title="今日"></em>
                    </dt>
                    <dd class="game-desc">
                       <a href="javascript:void(0)" >由于目前人数有限，暂时不开放这么多板块</a>
                    </dd>
                  </dl>
              </td>
              <td class="fl_g" width="32.9%">
                <div class="fl_icn_g" style="width: 200px;">
                  <a href="javascript:void(0)"><img src="img/language_length9.png" alt="Java" align="left"></a>
                </div>
                  <dl style="margin-left: 200px;">
                    <dt>
                       <a href="javascript:void(0)" class="game-title">Css</a>
                       <em class="game-todayposts" title="今日"></em>
                    </dt>
                    <dd class="game-desc">
                       <a href="javascript:void(0)" >由于目前人数有限，暂时不开放这么多板块</a>
                    </dd>
                  </dl>
              </td>
              <td class="fl_g" width="32.9%">
                <div class="fl_icn_g" style="width: 200px;">
                  <a href="javascript:void(0)"><img src="img/language_length10.png" alt="Java" align="left"></a>
                </div>
                  <dl style="margin-left: 200px;">
                    <dt>
                       <a href="javascript:void(0)" class="game-title">C++</a>
                       <em class="game-todayposts" title="今日"></em>
                    </dt>
                    <dd class="game-desc">
                       <a href="javascript:void(0)" >由于目前人数有限，暂时不开放这么多板块</a>
                    </dd>
                  </dl>
              </td>
            </tr>
            <tr class="fl_row">
              <td class="fl_g" width="32.9%">
                <div class="fl_icn_g" style="width: 200px;">
                  <a href="javascript:void(0)"><img src="img/language_length11.png" alt="Java" align="left"></a>
                </div>
                  <dl style="margin-left: 200px;">
                    <dt>
                       <a href="javascript:void(0)" class="game-title">C#</a>
                       <em class="game-todayposts" title="今日"></em>
                    </dt>
                    <dd class="game-desc">
                       <a href="javascript:void(0)" >由于目前人数有限，暂时不开放这么多板块</a>
                    </dd>
                  </dl>
              </td>
              <td class="fl_g" width="32.9%">
                <div class="fl_icn_g" style="width: 200px;">
                  <a href="javascript:void(0)"><img src="img/language_length12.png" alt="Java" align="left"></a>
                </div>
                  <dl style="margin-left: 200px;">
                    <dt>
                       <a href="javascript:void(0)" class="game-title">jQuery</a>
                       <em class="game-todayposts" title="今日"></em>
                    </dt>
                    <dd class="game-desc">
                       <a href="javascript:void(0)" >由于目前人数有限，暂时不开放这么多板块</a>
                    </dd>
                  </dl>
              </td>
              <td class="fl_g" width="32.9%">
                <div class="fl_icn_g" style="width: 200px;">
                  <a href="javascript:void(0)"><img src="img/language_length13.png" alt="Java" align="left"></a>
                </div>
                  <dl style="margin-left: 200px;">
                    <dt>
                       <a href="javascript:void(0)" class="game-title">Python</a>
                       <em class="game-todayposts" title="今日"></em>
                    </dt>
                    <dd class="game-desc">
                       <a href="javascript:void(0)" >由于目前人数有限，暂时不开放这么多板块</a>
                    </dd>
                  </dl>
              </td>
            </tr>
          </tbody>
       </table>
        
	   </div>
	</div>
    
    
<div class="bm bmw  flg cl con02" style="background-color: #ffffff;">
      <div class="bm_h cl" style="position: relative;background-color: #ffffff;">
        <span class="o">
          <img id="category_8702_img" src="img/collapsed_no.gif" title="收起/展开" alt="收起/展开" onclick="toggle_collapse('category_8702');">
        </span>
        <h4 >
        	<i class="jg"></i>
			<a style="" href="#">DataBase 专区</a>
        </h4>
      </div>
      <div id="category_8702" class="bm_c" style="">
        <table class="fl_tb" >
          <tbody class="js-hover">
            <tr class="fl_row">
              <td class="fl_g" width="32.9%">
                <div class="fl_icn_g" style="width: 120px;">
                  <a href="javascript:void(0)"><img src="img/language_mysql.png" alt="MySQL" align="left"></a>
                </div>
                  <dl style="margin-left: 120px;">
                    <dt>
                       <a href="javascript:void(0)" class="game-title">MySQL 数据库</a>
                       <em class="game-todayposts" title="今日"></em>
                    </dt>
                    <dd class="game-desc">
                       <a href="javascript:void(0)"  class="text-nowrap">MySQL引擎之前的区别</a>|
                       <a href="javascript:void(0)"  class="text-nowrap">初识MySQL跟我来</a>|
                       <a href="javascript:void(0)"  class="text-nowrap">MySQL注意事项</a>|
                       <a href="javascript:void(0)"  class="text-nowrap">各数据库SQL语句区别</a>|
                       <a href="javascript:void(0)"  class="text-nowrap">数据库优化</a>
                    </dd>
                  </dl>
              </td>
              <td class="fl_g" width="32.9%">
                <div class="fl_icn_g" style="width: 120px;">
                  <a href="javascript:void(0)"><img src="img/language_oracle.png" alt="Oracle" align="left"></a>
                </div>
                  <dl style="margin-left: 120px;">
                    <dt>
                       <a href="javascript:void(0)" class="game-title">Oracle 数据库</a>
                       <em class="game-todayposts" title="今日"></em>
                    </dt>
                    <dd class="game-desc">
                       <a href="javascript:void(0)"  class="text-nowrap">Oracle引擎之前的区别</a>|
                       <a href="javascript:void(0)"  class="text-nowrap">初识Oracle跟我来</a>|
                       <a href="javascript:void(0)"  class="text-nowrap">Oracle注意事项</a>|
                       <a href="javascript:void(0)"  class="text-nowrap">各数据库SQL语句区别</a>|
                       <a href="javascript:void(0)"  class="text-nowrap">数据库优化</a>
                    </dd>
                  </dl>
              </td>
              <td class="fl_g" width="32.9%">
                <div class="fl_icn_g" style="width: 120px;">
                  <a href="javascript:void(0)"><img src="img/language_sqlsever.png" alt="SQLSever" align="left"></a>
                </div>
                  <dl style="margin-left: 120px;">
                    <dt>
                       <a href="javascript:void(0)" class="game-title">SqlSever 数据库</a>
                       <em class="game-todayposts" title="今日"></em>
                    </dt>
                    <dd class="game-desc">
                       <a href="javascript:void(0)"  class="text-nowrap">SQLSever引擎之前的区别</a>|
                       <a href="javascript:void(0)"  class="text-nowrap">初识SQLSever跟我来</a>|
                       <a href="javascript:void(0)"  class="text-nowrap">SQLSever注意事项</a>|
                       <a href="javascript:void(0)"  class="text-nowrap">各数据库SQL语句区别</a>|
                       <a href="javascript:void(0)"  class="text-nowrap">数据库优化</a>
                    </dd>
                  </dl>
              </td>
            </tr>
            <tr class="fl_row">
              <td class="fl_g" width="32.9%">
                <div class="fl_icn_g" style="width: 120px;">
                  <a href="javascript:void(0)"><img src="img/language_other2.png" alt="Java" align="left"></a>
                </div>
                  <dl style="margin-left: 120px;">
                    <dt>
                       <a href="javascript:void(0)" class="game-title">其他数据库</a>
                       <em class="game-todayposts" title="今日"></em>
                    </dt>
                    <dd class="game-desc">
                       <a href="javascript:void(0)" >由于目前人数有限，暂时不开放这么多板块</a>
                    </dd>
                  </dl>
              </td>
              <td class="fl_g" width="32.9%">
                
              </td>
              <td class="fl_g" width="32.9%">
                
              </td>
            </tr>
          </tbody>
       </table>
     </div>
</div>
			
		</div>
		<?php include("view/footer.php"); ?>
	</body>
	<script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
</html>