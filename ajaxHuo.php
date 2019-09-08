<?php
	require('library/Db.class.php');//连接数据库
    require("library/function.php");        //自定义函数
    
    $db = new Db(); //实例化
    $pageSize=$_POST['size'];//遍历多少条
    $dang=$_POST['conn'];//从哪条开始遍历
    $sql="select * from post where post_type != 1 order by addtime desc limit ".$dang.",".$pageSize;
    $chaxun = $db->query($sql);
    
    if($chaxun!=null){
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
			//对数据的处理
			$avatar = $db->single('select avatar from user where id = :user_id',
								array('user_id'=>$vo['user_id']));
			$vo['img']=get_cover_path($avatar);
			$vo['addtime']=tranTime($vo['addtime']);
			if($vo['post_type'] == 2){
				$vo['content']=$vo['content'].'//'.$vo['sub']['content'];
			}else{
				$vo['content']=ubbReplace($vo['content']);
			}
			if(isset($vo['pid']) && $vo['post_type'] == 2){
				$vo['sub']['parent']['addtime']=tranTime($vo['sub']['parent']['addtime']);
				$vo['sub']['parent']['content']=ubbReplace($vo['sub']['parent']['content']);
			}
			//end
	        $lists[] = $vo;
		}
	    $jsdata=json_encode($lists);
	    echo $jsdata;
    }else{
    	echo 0;//表示没有信息
    }
	    
?>

