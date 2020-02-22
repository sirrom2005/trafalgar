<?php
include_once('config/config.php');
include_once('common-function.php');

class common extends commonFunction
{
    public  $db, 
            $imgSize,
            $userId,
            $dateNow;

    protected function _config() {
        $this->masterTemplate = "views/MASTER.php";
        $this->degradable = true;
        $this->preserveFormContent = true;
        $this->Raxan->config('debug',false);
        $this->imgSize = array(240,320,480,640,960);
	
        $this->dateNow = date('Y-m-d G:i:s');
        $this->icon = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
        /*define("DB_DATA_ADD",   "Record added", true);
        define("DB_DATA_EDIT",  "Data record updated", true);
        define("MISSING_FIELDS","Missing Data", true);
        define("NO_RECORD_FOUND","No Record Found", true);
        $this->userId = $this->Raxan->data('RSVP_SYS_ADMIN_ID');         */
    }

    protected function _init(){
        // set the path to the jquery.js file
        /*$this->registerScript('jquery','raxan/ui/javascripts/jquery.min.js');
        /*$this->loadScript('vendor/bootstrap/js/bootstrap.min.js', true);
        $this->loadScript('vendor/metisMenu/metisMenu.min.js', true);
        $this->loadScript('dist/js/sb-admin-2.js', true);*/
        //$this->connectToMySQl();
        $this->connectToPostgres();
    }

    protected function _load(){}

    protected function _prerender(){}
    
    protected function  _postrender(){}

    protected function _authorize()
    {
        $isLogin = $this->Raxan->data('GUINEP_ADMIN');
        if(!$isLogin){
            $this->redirectTo('login.php');
        }else{
            return true;
        }
    }
    
    function resize($newWidth, $targetFile, $originalFile) {
        $info = getimagesize($originalFile);
        $mime = $info['mime'];

        switch ($mime) {
                case 'image/jpeg':
                        $image_create_func = 'imagecreatefromjpeg';
                        $image_save_func = 'imagejpeg';
                        $new_image_ext = 'jpg';
                        break;

                case 'image/png':
                        $image_create_func = 'imagecreatefrompng';
                        $image_save_func = 'imagepng';
                        $new_image_ext = 'png';
                        break;

                case 'image/gif':
                        $image_create_func = 'imagecreatefromgif';
                        $image_save_func = 'imagegif';
                        $new_image_ext = 'gif';
                        break;

                default: 
                        throw new Exception('Unknown image type.');
        }

        $img = $image_create_func($originalFile);
        list($width, $height) = getimagesize($originalFile);

        $newHeight = ($height / $width) * $newWidth;
        $tmp = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        $image_save_func($tmp, "$targetFile.$new_image_ext");
    }
    
    function delImage($image) { 
        $location = API_IMAGE_FOLDER; 
        if(file_exists($location.$image)) {
            unlink($location.$image);
        }

        $parts = explode('.', $image); 
        $name = $parts[0];
        $ext  = $parts[1];
        foreach($this->imgSize as $row => $value){
            if(file_exists($location.$name.'_'.$value.'.'.$ext)) {
                unlink($location.$name.'_'.$value.'.'.$ext);
            }
        }
    }
    
    function writeApi($section) {
        $fileName = $data = $rs = null;
        switch($section){
            case API_NEWS:
                $rs = $this->db->table('view_news_api_data');
                $fileName = "news.json";
            break;
            case API_DESTINATION:
                $rs = $this->db->table('view_destination_api_data');
                $fileName = "destination.json";
            break;
            case API_SPECIALS:
                $rs = $this->db->table('view_specials_api_data');
                $fileName = "specials.json";
            break;
            case API_ADS:
                $rs = $this->db->table('view_ads_api_data');
                $fileName = "ads.json";
            break;
        }

        if($rs){
            $data = base64_encode(json_encode(array('list' => $rs)));
            $this->notifDevice($section);
        }
        
        $handle = fopen(API_FOLDER.$fileName, "w");
        fwrite($handle, $data);
    }
    
    function uploadImage($prefix){
        // check for file upload errors
        $filename = "";
        $err = $this->post->fileUploadError('file_data');
        if ($err) {
            $errors = array(
                0=>"There is no error, the file uploaded with success",
                1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini",
                2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
                3=>"The uploaded file was only partially uploaded",
                4=>"No file was uploaded",
                6=>"Missing a temporary folder"
            );
        }
        
        if($err!=0){return null;}
        
        $parts = explode('.', $this->post->fileOrigName('file_data'));   
        $this->ext = str_replace('jpeg', 'jpg', $parts[count($parts)-1]);
        
        try {
            $filename = $prefix.'_'.date('Y_m_d').time();
            $target = API_IMAGE_FOLDER.$filename.'.'.$this->ext; 
            $this->post->fileMove('file_data',$target);

            foreach($this->imgSize as $row => $imgSize){
                $img = API_IMAGE_FOLDER.$filename.'_'.$imgSize; 
                $this->resize($imgSize, $img, $target);
            }

            return $filename.'.'.$this->ext;
        }catch (Exception $err) {
            echo $msg = 'Unable to process image file. Make sure the folder {/api/images/} is writable. '. $err;
        }
    }
    
    protected function notifDevice($section){
        $data = array('data' => $section);
        $fields = array('to' => '/topics/gcm_main_data',
                        'data' => $data);
        $header = array('Authorization: key=' . API_ACCESS_KEY,
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
}