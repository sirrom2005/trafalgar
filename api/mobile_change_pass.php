<?php
include_once("config/ps_config.php");

$old_pass   = trim(filter_input(INPUT_POST, 'old_pass'));
$new_pass   = trim(filter_input(INPUT_POST, 'new_pass'));
$user_id    = trim(filter_input(INPUT_POST, 'user_id'));

if(empty($old_pass) || empty($new_pass) || empty($user_id)){ 
    echo '_SYS_ERROR_'; return; 
}

$sth = $db->prepare("UPDATE ttms.public.mobile_login SET password = md5(?) WHERE password = md5(?) AND user_id = ?");
$sth->execute(array($new_pass,$old_pass,$user_id));

if($sth->rowCount()){
    echo '_CHANGED_';
}else{
    echo '_NOT_CHANGED_';
}
