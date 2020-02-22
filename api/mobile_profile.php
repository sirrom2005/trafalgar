<?php
include_once("config/ps_config.php");

$userid =  trim(filter_input(INPUT_POST, 'user_id'));
if(empty($userid)){echo '_NOT_FOUND_'; return;}

$sql = "SELECT occupation_key, trim(occupation_name) as occupation_name FROM occupation ORDER BY occupation_name";
try{
    $sth = $db->prepare($sql);
    $sth->execute();
    $occ =  $sth->fetchAll(PDO::FETCH_NAMED);

    if($occ){
        $sql = "select 
        coalesce(TRIM(firstname),'') AS firstname,
        coalesce(TRIM(middlename),'') AS middlename,
        coalesce(TRIM(lastname),'') AS lastname,
        coalesce(TRIM(email),'') AS email,
        coalesce(TRIM(dob),'1960-01-01') AS dob,
        coalesce(TRIM(gender),'') AS gender,
        coalesce(TRIM(cell),'') AS cell,
        coalesce(TRIM(telephone1),'') AS telephone1,
        coalesce(TRIM(telephone2),'') AS telephone2,
        coalesce(TRIM(address1),'') AS address1,
        coalesce(TRIM(address2),'') AS address2,
        coalesce(TRIM(address3),'') AS address3,
        coalesce(occupation_key,0) AS occupation_key
        from profile
        where dk_number = ?
        LIMIT 1";

        try{
            $sth = $db->prepare($sql);
            $sth->execute(array($userid));
            $rs = $sth->fetchObject();
            
            if($rs){
                $rs->occ = $occ;
                echo json_encode($rs);
            }else{
                echo '_NOT_FOUND_';
            }
        }catch(Exception $ex){
            echo '_SYS_ERROR_';
        } 
    }else{
        echo '_NOT_FOUND_';
    }
}catch(Exception $ex){
    echo '_SYS_ERROR_';
}    