<?php
include_once("config/ps_config.php");

$user =  trim(filter_input(INPUT_POST, 'user'));
$pass =  trim(filter_input(INPUT_POST, 'pass'));

if(empty($user) || empty($pass)){
    echo '_NOT_FOUND_';
    return;
}

$sql = "SELECT
        p.dk_number as id,
        initcap(p.firstname || ' ' || p.lastname) AS fullname,
        p.agent_link as agent_id,
        p.email
        from profile p 
        INNER JOIN mobile_login m ON m.user_id = p.dk_number
        where lower(trim(m.email)) = ? and m.password = md5(?)
        LIMIT 1";

try{
    $sth = $db->prepare($sql);
    $sth->execute(array(strtolower($user),$pass));
    $rs = $sth->fetchObject();

    if($rs){
        echo json_encode($rs);
    }else{
        echo '_NOT_FOUND_';
    }
}catch(Exception $ex){
    echo '_SYS_ERROR_';
}     