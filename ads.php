<?php
include_once('common.php');
// Quickstart - Sample page class
class News extends common {
    
    protected $updateList;

    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'ads.view.php';
    }

    protected function _init() {
        parent::_init();
    }
    
    protected function _load() {
        $this->delegate('.delete', '#click',  array('callback' => '.remove'));
    }
    
    protected function _prerender() {
        if(!$this->isCallback || $this->updateList)
        {
            $rs = $this->db->table('view_get_advertisement');            
            $this["#data_table tbody"]->bind($rs);
        }
    }

    protected function remove($e) {
        $rs = $this->db->table('view_get_advertisement', 'id=?', $e->value);
        if($rs[0]['banner']){      
            $this->delImage($rs[0]['banner']);
        }
    
        $this->db->tableDelete('advertisement', 'id=?', $e->value);
        
        $this->writeApi(API_ADS);
        //$this->updateList = true;
        //$this["#data_table tbody"]->updateClient();
        $this->redirectTo("ads.php");
    }
}
?>