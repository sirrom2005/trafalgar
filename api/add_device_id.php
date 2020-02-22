<?php
include_once '../cms/config/config.php'; 

if(!filter_input(INPUT_POST, 'device_id')){ echo '-'; return; }

$conn = mysqli_connect(DBHOST, DBUSERNAME, DBPASSWORD, DBDATABASE);
// Check connection
if(mysqli_connect_errno()){
    die("Connection failed: " . mysqli_connect_error());
}

$user_id    = filter_input(INPUT_POST, 'user_id');
$device_id  = filter_input(INPUT_POST, 'device_id');
$dated_added= date('Y-m-d');

if($stmt = mysqli_prepare($conn, "INSERT INTO device (user_id, device_id, dated_added) VALUES (?, ?, ?)")){
    mysqli_stmt_bind_param($stmt, "sss", $user_id, $device_id, $dated_added);
    
    if(mysqli_stmt_execute($stmt)){
        echo 1;
    }else{
       echo 0; 
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);