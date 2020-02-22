<?php
include_once("config/ps_config.php");

$userId  = filter_input(INPUT_POST, 'user_id');

if(empty($userId)){ echo '_NO_INPUT_'; return null; }

$sql = "SELECT 
        invoiceno,
        issuedate,
        trim(recordloca) as itinerary_code,
        trim(departcityname) as departcityname,
        trim(destination) as destination,
        departdate,
        departtime
        FROM invoice as inv, itinerary as it 
        WHERE 
        inv.invoiceno = it.invoicenum AND dk_number = ? AND indexno = 1
        ORDER BY issuedate desc, recordloca";

try{
    $sth = $db->prepare($sql);
    $sth->execute(array($userId));
    $data = $sth->fetchAll(PDO::FETCH_NAMED);
    
    foreach($data as $key => $row){
        $data[$key]['departdate'] =  date('F d, Y', strtotime($row['departdate']));
        $data[$key]['departtime'] =  date('g:i a', strtotime($row['departtime']));
    }
    
    if($data){
        echo json_encode(array('list' => $data));
    }else{
        echo '_NO_DATA_'; 
    }
}catch(Exception $ex){
    echo '_SYS_ERROR_';
}