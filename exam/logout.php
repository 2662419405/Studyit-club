<?php

    session_start();
    unset($_SESSION['user']);

    $result_dest = session_destroy();
    setcookie('username','',0);
    setcookie('password','',0);
    if($result_dest){
        echo "<script>window.location.href='login.php'</script>";
    }else{
        echo "退出失败";
    }

?>

