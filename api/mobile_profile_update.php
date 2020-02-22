<?php
include_once("config/ps_config.php");

$userId     = filter_input(INPUT_POST, 'user_id');
$firstname  = filter_input(INPUT_POST, 'firstname');
$middlename = filter_input(INPUT_POST, 'middlename');
$lastname   = filter_input(INPUT_POST, 'lastname');
$email      = filter_input(INPUT_POST, 'email');
$dob        = filter_input(INPUT_POST, 'dob');
$gender     = filter_input(INPUT_POST, 'gender');
$cell       = filter_input(INPUT_POST, 'cell');
$telephone1 = filter_input(INPUT_POST, 'telephone1');
$telephone2 = filter_input(INPUT_POST, 'telephone2');
$address1   = filter_input(INPUT_POST, 'address1');
$address2   = filter_input(INPUT_POST, 'address2');
$address3   = filter_input(INPUT_POST, 'address3');
$job_key    = filter_input(INPUT_POST, 'occupation_key');

if(empty($userId) || empty($firstname) || empty($cell) || empty($email) || empty($job_key)){
    echo '_NO_INPUT_'; return;
}

try{
    $sql = "UPDATE profile SET 
            firstname = :firstname,
            middlename = :middlename,
            lastname = :lastname,
            email = :email,
            dob = :dob,
            gender = :gender,
            cell = :cell,
            telephone1 = :telephone1,
            telephone2 = :telephone2,
            address1 = :address1,
            address2 = :address2,
            address3 = :address3,
            last_updateby = 'MOBILE_APP',
            occupation_key = :job_key 
            WHERE dk_number = :user_id";

    $stmt = $db->prepare($sql);                                 
    $stmt->bindParam(':firstname',  $firstname, PDO::PARAM_STR);       
    $stmt->bindParam(':middlename', $middlename, PDO::PARAM_STR); 
    $stmt->bindParam(':lastname',   $lastname, PDO::PARAM_STR);
    $stmt->bindParam(':email',      $email, PDO::PARAM_STR); 
    $stmt->bindParam(':dob',        $dob, PDO::PARAM_STR); 
    $stmt->bindParam(':gender',     $gender, PDO::PARAM_STR);       
    $stmt->bindParam(':cell',       $cell, PDO::PARAM_STR); 
    $stmt->bindParam(':telephone1', $telephone1, PDO::PARAM_STR);
    $stmt->bindParam(':telephone2', $telephone2, PDO::PARAM_STR); 
    $stmt->bindParam(':address1',   $address1, PDO::PARAM_STR); 
    $stmt->bindParam(':address2',   $address2, PDO::PARAM_STR); 
    $stmt->bindParam(':address3',   $address3, PDO::PARAM_STR); 
    $stmt->bindParam(':job_key',    $job_key, PDO::PARAM_INT);
    $stmt->bindParam(':user_id',    $userId, PDO::PARAM_INT);

    echo ($stmt->execute())? "_PASS_" : "_FAIL_";
}catch(Exception $ex){
    echo '_SYS_ERROR_';
}    