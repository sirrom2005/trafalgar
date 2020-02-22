<?php
include_once('common.php');
class AddDestination extends common {
    protected $id,
              $ext;

    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'add.destination.view.php';  // set page view file name
    }

    protected function _init() {
        parent::_init();
        $this->id = $this->get->intVal('id') | 0;
    }
    
    protected function _load() {
        if($this->id){
            $this["#btn span"]->text("Update");
            $this["#panel-heading"]->text("Update");
            $rs = $this->db->table('destination', 'id=?', $this->id);
            //To solve string int issue
            $rs[0]['enabled'] = (string)$rs[0]['enabled'];     
            $this["#frm"]->inputValues($rs[0]);
            if($rs[0]['image']){
                $ext = substr($rs[0]['image'], strlen($rs[0]['image'])-4);
                $this["#gallery"]->attr('src',API_PATH.'images/'.str_replace($ext, '_480'.$ext, $rs[0]['image']));
            }
        }
    }
    
    public function sumbit_data() {   
        $data['title']      = $this->post->textVal('title');
        $data['sub_title']  = $this->post->textVal('sub_title');
        $data['phone']      = $this->post->textVal('phone');
        $data['body']       = $this->post->htmlVal('body');
        $data['enabled']    = $this->post->textVal('enabled') | 0;
        $img                = $this->uploadImage('location');
        if($img){$data['image'] = $img;}
                     
        if($this->id)
        {
            if($img){
                $rs = $this->db->table('view_get_location', 'id=?', $this->id);
                if($rs[0]['image']){
                    $this->delImage($rs[0]['image']);
                }
            }
            $this->db->tableUpdate('destination', $data, 'id=?', $this->id);
            $this->writeApi(API_DESTINATION);
            $this->callScriptFn('callModal');
        }else{
            $data['date_added'] = $this->dateNow;
            $this->db->tableInsert('destination', $data);
            $this->writeApi(API_DESTINATION);
            $this->redirectTo("destinations.php");
        }
    }
    
}

if($_POST){
    $obj = new AddDestination();
    $obj->sumbit_data();
}
?>