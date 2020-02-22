<?php
include_once('common.php');
// Quickstart - Sample page class
class News extends common {
    
    protected $updateList;

    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'news.view.php';  //set page view file name
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
            $rs = $this->db->table('view_get_news');            
            $this["#data_table tbody"]->bind($rs);
        }
    }

    protected function remove($e) {
        $rs = $this->db->table('view_get_news', 'id=?', $e->value);
        if($rs[0]['image']){      
            $this->delImage($rs[0]['image']);
        }
    
        $this->db->tableDelete('news_article', 'id=?', $e->value);
        
        $this->writeApi(API_NEWS);
        //$this->updateList = true;
        //$this["#data_table tbody"]->updateClient();
        $this->redirectTo("news.php");
    }
}
?>