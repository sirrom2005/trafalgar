<?php
include_once('common.php');
// Quickstart - Sample page class
class Index extends common {
    protected function _config() {
        parent::_config();
    }

    protected function _init() {
        parent::_init();
    }
    
    protected function _prerender() {
        $this->Raxan->removeData('GUINEP_ADMIN');
        $this->redirectTo('index.php');
    }
}
?>