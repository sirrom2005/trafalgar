<?php
include_once('common.php');
// Quickstart - Sample page class
class Index extends common {
    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'index.view.php';  // set page view file name
    }

    protected function _init() {
        parent::_init();
          /*$dev_db_info = array(
        "host" => "192.168.0.8",
        "port" => 5432,
        "username" => "postgres",
        "password" => "tRafalger1",
        "dbname" => "ttms");*/
    }
    
    protected function _load() {
        $this->delegate('#btn', '#click',  array('callback' => '.sendNotification'));
        $this->loadInfo();
    }
    
    protected function loadInfo() {
        try{
            $rs = $this->db->table('view_home_page_summary');
            $this["#news_count"]->html($rs[0]['news_count']);
            $this["#des_count"]->html($rs[0]['des_count']);
            $this["#spec_count"]->html($rs[0]['spec_count']);
            $this["#ad_count"]->html($rs[0]['ad_count']);
        }
        catch(Exception $ex)
        {
            $msg = DB_DATA_ERROR;
            $this->flashmsg($this->icon.$ex,'fade','alert alert-danger');
            $this->Raxan->debug($msg.' '.$ex);
        }
    }
    
    
    protected function sendNotification() { 
        //API access key from Google API's Console
        //$registrationIds = $this->getDeviceIds();
        //prep the bundle
        $msg = array
          (
            'body'  => $this->post->textVal('message'),
            'title' => $this->post->textVal('subject')
          );
        //'registration_ids' => $registrationIds 'to' => '/topics/gcm_main_data'
        $fields = array('to' => '/topics/gcm_main_data', 'notification'  => $msg);
        $headers = array(   'Authorization: key=' . API_ACCESS_KEY,
                            'Content-Type: application/json'); 
        //Send Reponse To FireBase Server   
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        json_decode(curl_exec($ch),true);
        curl_close( $ch );
        //C("#msg_body")->html("Message submitted<br/>Success: ".$result['success']." Failure: ".$result['failure']);
        C("#msg_body")->html("Message submitted");
        C('#frm')->trigger("reset");
        $this->callScriptFn('callModal');
    }
    
    protected function getDeviceIds() { 
        try{
            $rs = $this->db->execQuery('SELECT device_id FROM device group by device_id');
            $token = array();
            foreach($rs as $key => $value){
                $token[] = $value['device_id'];
            }
            return $token;
        }
        catch(Exception $ex)
        {
            $msg = DB_DATA_ERROR;
            $this->flashmsg($this->icon.$ex,'fade','alert alert-danger');
            $this->Raxan->debug($msg.' '.$ex);
        }
    }
}
