<?php
include_once('common.php');
class AddAds extends common {
    protected $id,
              $ext;

    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'add.advertisement.view.php';  // set page view file name
    }

    protected function _init() {
        parent::_init();
        $this->id = $this->get->intVal('id') | 0;
    }
    
    protected function _load() {
        if($this->id){
            $this["#btn span"]->text("Update");
            $this["#panel-heading"]->text("Update");
            $rs = $this->db->table('advertisement', 'id=?', $this->id);
            //To solve string int issue
            $rs[0]['enabled'] = (string)$rs[0]['enabled'];
            $this["#frm"]->inputValues($rs[0]);
            if($rs[0]['banner']){
                $ext = substr($rs[0]['banner'], strlen($rs[0]['banner'])-4);
                $this["#gallery"]->attr('src',API_PATH.'images/'.str_replace($ext, '_480'.$ext, $rs[0]['banner']));
            }
        }
    }
    
    public function sumbit_data() {   
        $data['title']      = $this->post->textVal('title');
        $data['details']    = $this->post->htmlVal('details');
        $data['start_date'] = $this->post->dateVal('start_date', 'Y-m-d');
        $data['end_date']   = $this->post->dateVal('end_date', 'Y-m-d');
        $data['enabled']    = $this->post->textVal('enabled') | 0;
        $img                = $this->uploadImage('ads');
        if($img){$data['banner'] = $img;}
                     
        if($this->id)
        {
            if($img){
                $rs = $this->db->table('view_get_advertisement', 'id=?', $this->id);
                if($rs[0]['banner']){
                    $this->delImage($rs[0]['banner']);
                }
            }
            $this->db->tableUpdate('advertisement', $data, 'id=?', $this->id);
            $this->writeApi(API_ADS);
            $this->callScriptFn('callModal');
        }else{
            $data['date_added'] = $this->dateNow;
            $this->db->tableInsert('advertisement', $data);
            $this->writeApi(API_ADS);
            $this->redirectTo("ads.php");
        }
    }
}

if($_POST){
    $obj = new AddAds();
    $obj->sumbit_data();
}
?>