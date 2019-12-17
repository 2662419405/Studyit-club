<?php
    require('library/Db.class.php');
    require("library/function.php");
    session_start();
    $user_id =  isset($_SESSION['user']['id'])?$_SESSION['user']['id']:"";
    if($user_id == '' ){
        echo -1;exit;
    }
    $db = new Db(); 
    $username = isset($_SESSION['user']['username'])?$_SESSION['user']['username']:"";
    $pid      = isset($_POST['pid']) ? $_POST['pid'] : 0;
    $content  = isset($_POST['content']) ? strip_tags($_POST['content']) : "";
    $pictures = isset($_POST['pictures']) ? $_POST['pictures'] : "";
    $type     = isset($_POST['type']) ? $_POST['type'] : 0;
    if($type == 1){
        $parent_user_id = $db->single('select user_id from post where id = :id',
                                       array('id'=>$pid));//回复id
    }
    $parent_user_id = isset($parent_user_id) ? $parent_user_id : 0 ;

    $addtime  = time();
    $sql      = "insert into post (user_id,username,content,pictures,addtime,pid,post_type,parent_user_id)
                 values( :user_id , :username , :content , :pictures , :addtime , $pid , $type ,$parent_user_id)";
    $insert	  = $db->query($sql,array("user_id"=>$user_id,"username"=>$username,"content"=>$content,
                            "pictures"=>$pictures , "addtime"=>$addtime));
    $post_id  = $db->lastInsertId();
    /*0发帖子 1评论帖子 2转发帖子*/
    switch ($type)
    {
        case 0:
            $db->query('update user set posts_num = posts_num + 1 where id = :user_id',
                        array('user_id'=>$user_id));
            $db->query('update today set laoshi_sum = laoshi_sum + 1');
      break;
        case 1:
            $db->query('update post set comment_num = comment_num + 1 where id = :pid',
                        array('pid'=>$pid));
            $db->query('update today set laoshi_sum = laoshi_sum + 1');
            break;
        case 2:
            $db->query('update user set posts_num   = posts_num + 1   where id = :user_id',
                        array('user_id'=>$user_id));
            $db->query('update post set forward_num = forward_num + 1 where id = :pid',
                        array('pid'=>$pid));
            $db->query('update today set laoshi_sum = laoshi_sum + 1');
      break;
    }

    if(strstr($content,"@")){ //判断@
        $reg = "/@([^@\s]+)/";                 
        $match = array();
        preg_match_all($reg,$content,$match);  
        $users_array = array_unique($match[1]); 
        if($users_array){
            $count = count($users_array);        
            /**查看@用户是否存在，如果存在写入at表**/
            for($i = 0;$i < $count; $i++){
                $select_sql = "select id from user where username = '".$users_array[$i]."'";
                $user_id    = $db->single($select_sql,MYSQL_ASSOC);
                if($user_id){
                	$add= time();
                    $insert_sql = "insert into at (user_id,friend_id) values ( :user_id , :post_id)";
                    $db->query($insert_sql,array('user_id'=>$user_id,'post_id'=>$post_id));
                }
            }
        }
    }



