<?php
$db = new PDO("pgsql:dbname=mobile;host=192.168.0.8", 'postgres', 'tRafalger1');

$image	= filter_input(INPUT_POST, 'image');
$title	= filter_input(INPUT_POST, 'title');
$user_id= filter_input(INPUT_POST, 'user_id');

if(empty($image) || empty($title) || empty($user_id)){ echo '_SYS_ERROR_'; return; }

$size       = array(300);
$newWidth   = $size[rand(0, count($size)-1)];
$file_ext   = ".jpg";
$filename   = date('Y_m_d_Gis');
$thumb      = $filename."_w".$newWidth.$file_ext;
$folder     = "gallery/";
$path       = $folder.$filename.$file_ext;
$handle     = fopen($path, "w");
//write large image file
if(fwrite($handle, base64_decode($image))){
    fclose($handle);
    $img = imagecreatefromjpeg($path);
    list($width, $height) = getimagesize($path);
    $newHeight = ($height/$width) * $newWidth;
    $tmp = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    //Create thumnail
    if(imagejpeg($tmp, $folder.$thumb)){
        $sql = "INSERT INTO photo_gallery(image,title,user_id,date_added) VALUES(?,?,?,?)";
        $sth = $db->prepare($sql);
        $sth->execute(array($thumb,$title,$user_id,date('Y-m-d')));
        writeJson();  
    }else{
        if(file_exists($path)){ unlink($path); }
        echo '_UPLOAD_ERROR_';
    }
}else{
    echo '_UPLOAD_ERROR_';
}

function writeJson(){
    global $db;
    $sth = $db->prepare("SELECT id,image,title FROM photo_gallery ORDER BY date_added DESC LIMIT 200");
    $sth->execute();
    $data = $sth->fetchAll(PDO::FETCH_NAMED);
    
    if($data){
        $handle = fopen("gallery.json", "w");
        $txtFile = json_encode(array('list' => $data));
        fwrite($handle,$txtFile);
        echo $txtFile;
        notifDevice();
    }  
}

function notifDevice(){
    $data   = array('data' => 'gallery');
    $fields = array('to' => '/topics/gcm_main_data',
                    'data' => $data);
    $header = array('Authorization: key=AAAA05JPn6I:APA91bFLr40DekfJKICHSsVX73yPSIpgGsRlOgNXme-6xIY1hbw8NXjp3erxdjFTij9BuGZWDwCibp06eTIw8d2__z8PrKEJYZJ0fCMi19Ii6XJR67ccbYAPYKqdRkO9DjXSh8AW2bMN',
                    'Content-Type: application/json'); 
    //Send Reponse To FireBase Server   
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $header );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    json_decode(curl_exec($ch),true);
    curl_close( $ch );
}
?>