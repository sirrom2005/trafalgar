<?php
include_once("config/ps_config.php");

$image	= filter_input(INPUT_POST, 'image');
$user_id= filter_input(INPUT_POST, 'user_id');

if(empty($image) || empty($user_id)){ echo '_NO_INPUT_'; return; }

$filename   = $user_id.'.jpg';
$folder     = "profile_photo/";
$path       = $folder.$filename;
$handle     = fopen($path, "w");

if(fwrite($handle, base64_decode($image))){
    fclose($handle);
    if(file_exists($path)){ 
        echo '_UPLOADED_';
    }
}else{
    echo '_UPLOAD_ERROR_';
}
?>