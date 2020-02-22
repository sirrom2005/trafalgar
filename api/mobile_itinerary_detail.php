<?php
include_once("config/ps_config.php");

$key  = filter_input(INPUT_POST, 'key');

if(empty($key)){ echo '_NOT_DATA_'; return null; }

$sql = "SELECT 
        invoiceno,
        trim(recordloca) AS recordloca,
        trim(inv.classofsvc) AS classofsvc,
        dap.a_name AS dap_airport,
        dap.latitude_deg  AS d_latitude,	
        dap.longitude_deg AS d_longitude,
        aap.a_name AS a_airport,
        aap.latitude_deg  AS a_latitude,	
        aap.longitude_deg AS a_longitude,
        trim(destination) AS destination,
        trim(flightno) AS flightno,
        trim(departcityname) AS departcityname,
        departdate,
        departtime,
        trim(arrivecity) AS arrivecity,
        trim(cityname) AS cityname,
        arrivedate, 
        arrivetime,
        airlinename,
        trim(mileage) AS mileage 
        FROM invoice inv 
        INNER JOIN itinerary it ON it.invoicenum = inv.invoiceno 
        INNER JOIN airline air ON air.validal = airline 
        INNER JOIN airports_iata dap ON trim(dap.iata_code) = trim(departcity)
        INNER JOIN airports_iata aap ON trim(aap.iata_code) = trim(arrivecity)
        WHERE invoiceno = ?
        ORDER BY indexno";
//1759923
try{
    $sth = $db->prepare($sql);
    $sth->execute(array($key));
    $data = $sth->fetchAll(PDO::FETCH_NAMED);

    foreach($data as $key => $row){
        $data[$key]['departdate'] =  date('F d, Y', strtotime($row['departdate']));
        $data[$key]['departtime'] =  date('g:i a', strtotime($row['departtime']));
        $data[$key]['arrivedate'] =  date('F d, Y', strtotime($row['arrivedate']));
        $data[$key]['arrivetime'] =  date('g:i a', strtotime($row['arrivetime']));
        $data[$key]['airlinename'] = (substr_count($row['airlinename'], 'air')==0)? $row['airlinename']. ' Airline' : $row['airlinename'];
        $data[$key]['classofsvc']  = (substr_count($row['classofsvc'],'class')==0)? $row['classofsvc'] . ' Class'   : $row['classofsvc'];
    }
    
    if($data){
        echo json_encode(array('list' => $data));
    }else{
        echo '_NOT_DATA_'; 
    }
}catch(Exception $ex){
    echo '_SYS_ERROR_';
}