<?php
include_once("config/ps_config.php");

$userId  = filter_input(INPUT_POST, 'user_id');
if(empty($userId)){ echo '_NO_INPUT_'; return null; }

$sql = "SELECT 
        (SELECT TRIM(traveldesc) FROM traveltypes WHERE traveltype = MIN(bk.traveltype)) AS traveldesc,
        TRIM(inv.destination) AS destination,
        TRIM(inv.route) AS route,
        inv.issuedate,
        inv.invoicenum,
        coalesce(inv.currency_key,'') AS currency_key, 
        inv.ja_to_us,
        CASE WHEN trim(inv.branch_key) IN ('GEM','POS','EWT')
            THEN SUM(bk.calcbasefa) + SUM(bk.totaltaxes) + SUM(bk.vatamt)
            ELSE SUM(bk.calcbasefa) + SUM(bk.totaltaxes)
        END AS total
        FROM invoice inv 
        INNER JOIN profile pr ON inv.dk_number = pr.dk_number 
        INNER JOIN booking bk ON inv.invoiceno = bk.invoice_li    
        WHERE pr.dk_number = ?
        GROUP BY inv.route, inv.issuedate, inv.invoicenum,inv.currency_key, 
        inv.ja_to_us,inv.branch_key, inv.destination 
        ORDER BY inv.issuedate DESC";

try{
    $sth = $db->prepare($sql);
    $sth->execute(array($userId));
    $data = $sth->fetchAll(PDO::FETCH_NAMED);
    
    foreach($data as $key => $row){
        $data[$key]['issuedate'] = date('F d, Y', strtotime($row['issuedate']));
        if($data[$key]['traveldesc'] == 'Intl Air'){
            $ex = explode('/', $data[$key]['route']);
            $data[$key]['route'] = trim($ex[0]). ' to ' . $data[$key]['destination'];
        }else{
            $data[$key]['route'] = $data[$key]['traveldesc'];
        }
    }
    
    if($data){
        echo json_encode(array('list' => $data));
    }else{
        echo '_NO_DATA_'; 
    }
}catch(Exception $ex){
    echo '_SYS_ERROR_';
}