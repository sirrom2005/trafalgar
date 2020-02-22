<?php
include_once('common.php');
// Quickstart - Sample page class
class Specails extends common {
    
    protected $updateList;

    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'specials.view.php';  //set page view file name
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
            $rs = $this->db->table('view_get_special');            
            $this["#data_table tbody"]->bind($rs);
        }
    }

    protected function remove($e) {
        $rs = $this->db->table('view_get_special', 'id=?', $e->value);
        if($rs[0]['image']){
            $this->delImage($rs[0]['image']);
        }
        $this->db->tableDelete('specials', 'id=?', $e->value);
        $this->writeApi(API_SPECIALS);
        $this->redirectTo("specials.php");
    }
}
?>