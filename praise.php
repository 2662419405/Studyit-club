<?php
    require('library/Db.class.php');
    require("library/function.php");   
    is_login();     
    $db = new Db(); 
    $user_id = $_SESSION['user']['id']; 
    $post_id = $_POST['post_id'];  

    $praise    = $db->row('select * from praise where user_id = :user_id and post_id = :post_id',
                           array('user_id'=>$user_id,'post_id'=>$post_id));
    if(!$praise){  
        $sql    = 'insert into praise (user_id,post_id) value (:user_id,:post_id)';
        $insert = $db->query($sql,array("user_id"=>$user_id,"post_id"=>$post_id));
        $db->query('update post set praise_num   = praise_num + 1 where id = :post_id',array('post_id'=>$post_id));
        echo 1;
    }else{     
        echo 0;
    }

