<?php
    require('library/Db.class.php');//连接数据库
    require("library/function.php");        //自定义函数

    $db = new Db(); //实例化

    $pid  = isset($_POST['pid']) ? $_POST['pid'] : 0; //获取父id
    $sql  = 'select * from post where post_type = 1 and pid = '.$pid.' order by addtime desc limit 5';
    $post = $db->query($sql);//筛选出该条微博的所有评论

    foreach($post as $vo){
        $vo['addtime'] = tranTime($vo['addtime']); //转换日期
        //获取用户头像
        $avatar = $db->single('select avatar from user where id = :user_id',
                                array('user_id'=>$vo['user_id']));
        $vo['avatar'] = get_cover_path($avatar);//获取头像路径
        $lists[] = $vo;
    }

    $jsdata=json_encode($lists);
    echo $jsdata;




