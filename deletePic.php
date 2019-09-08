<?php

$pic = $_POST['pic'];
if(file_exists($pic)){
    unlink($pic);
}
