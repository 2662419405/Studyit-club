<?php
//绘制棋盘行：10 * 列：9，以及棋子所在位置
$c = "";//初始化变量
$c .= '007,005,003,001,000,002,004,006,008,'.
    'blank,blank,blank,blank,blank,blank,blank,blank,blank,'.
    'blank,009,blank,blank,blank,blank,blank,010,blank,'.
    '011,blank,012,blank,013,blank,014,blank,015,'.
    'blank,blank,blank,blank,blank,blank,blank,blank,blank,'.
    'blank,blank,blank,blank,blank,blank,blank,blank,blank,'.
    '111,blank,112,blank,113,blank,114,blank,115,'.
    'blank,109,blank,blank,blank,blank,blank,110,blank,'.
    'blank,blank,blank,blank,blank,blank,blank,blank,blank,'.
    '107,105,103,101,100,102,104,106,108';//定义所有棋子组成的字符串
function GetIP(){                       //获取IP
    if (getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");            //获取客户机的IP地址
    else
        $ip = "Unknown";                     //将IP赋值为字符串"Unknown"
    return $ip;                            //返回IP
}
?>