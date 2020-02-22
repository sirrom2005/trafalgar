<?php
require_once 'raxan/pdi/autostart.php';
include_once('config/config.php');

class Login extends RaxanWebPage {
    protected $db;

    protected function _config() {
        $this->masterTemplate = "views/login.view.php"; 
        $this->icon = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
    }

    protected function _init() {
        //$this->connectToBD();
        $this->connectToPostgres();
    }

    protected function _load() { 
        /*if ($this->post->textVal('email')) {
            $this->loginAction();
        }*/
        //$this->delegate('#btn', 'click', array('callback' => '.loginAction'));
    }
    
    public function loginAction() {
        $pass  = $this->post->textVal('password');
        $email = $this->post->textVal('email');

        try{
            //"CALL sp_login('".$email."', '".$pass."')"
            $sql = "SELECT a.id, a.name FROM mobile.public.admin a                                                                                                                                                                                                                                                                                            
                    WHERE a.username = ? AND a.password = md5(?) AND allow_login = 1                                                                                                                                                                                                                         
                    LIMIT 1";
            $rt = $this->db->execQuery($sql, array($email,$pass));  

            if($rt){ 
                $this->Raxan->data('GUINEP_ADMIN',true);
                $this->Raxan->data('GUINEP_ADMIN_ID',   $rt[0]['id']);
                $this->Raxan->data('GUINEP_ADMIN_NAME', $rt[0]['name']);
                $this->redirectTo('index.php');
            }else{
                $msg = "Invalid login!!!";
                $this->flashmsg($this->icon.$msg,'fade','alert alert-danger');
            }
        }catch(Exception $ex){
            $msg = DB_DATA_ERROR.$ex;
            $this->flashmsg($this->icon.$msg,'fade','alert alert-danger');
            $this->Raxan->debug($msg.' '.$ex);
        }
    }
    
    public function connectToBD()
    {
        /*try
        {
            $this->db = $this->Raxan->connect('mysql:host='.DBHOST.'; dbname='.DBDATABASE,DBUSERNAME,DBPASSWORD,true);
            return $this->db;
        }
        catch(Exception $ex)
        {
            $msg = "Connection Error...";
            $this->flashmsg($this->icon.$msg,'fade','alert alert-danger');
            $this->Raxan->debug($msg.' '.$ex);
        }*/
    }
    
    public function connectToPostgres()
    {   
        try
        {
            /*C:\wamp\bin\apache\Apache2.2.17\bin\libpq.dll <- for it to work*/
            $this->db = $this->Raxan->connect('pgsql:host=192.168.0.8;port=5432;dbname=mobile;user=postgres;password=tRafalger1');
            return $this->db;
        }
        catch(PDOException  $e)
        {
            $msg = "Connection Error..";
            $this->flashmsg($this->icon.$msg,'fade','alert alert-danger');
            $this->Raxan->debug($msg.' '.$ex);
        }
    }
}

if($_POST){
    $obj = new Login();
    $obj->loginAction();
}
