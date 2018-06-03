<?php

require_once './endpoint.php';
if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}
if(array_key_exists('REMOTE_ADDR',$_SERVER)){
    $remoteHost = $_SERVER['REMOTE_ADDR'];
}
try{
    $api = new EndPoint($_REQUEST['request'], $_SERVER['HTTP_ORIGIN'],$remoteHost);
    echo $api->processAPI();
}catch (Exception $e){
    echo json_encode(array('error'=>$e->getMessage()));
}
