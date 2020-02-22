<?php
include_once('config/config.php');
include_once('common-function.php');

class common extends commonFunction
{
    public  $db;

    protected function _config() {
        $this->connectToPostgres();
    }

    protected function _init(){
    }

    protected function _load(){}

    protected function _prerender(){}
    
    protected function  _postrender(){}

    protected function _authorize(){return true;}
    
    protected function generatePassword(){
        return 'pass1234';
    }
}