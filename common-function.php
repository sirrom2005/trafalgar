<?php
require_once 'raxan/pdi/autostart.php';
class commonFunction extends RaxanWebPage
{    
    protected function isValidEmail($email){
	return @eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
    }

    public function connectToMySQl()
    {
        try
        {
            $this->db = $this->Raxan->connect('mysql:host='.DBHOST.'; dbname='.DBDATABASE,DBUSERNAME,DBPASSWORD,true);
            return $this->db;
        }
        catch(Exception $ex)
        {
            echo $msg = "Connection Error..";
            $this->flashmsg($this->icon.$msg,'fade','alert alert-danger');
            $this->Raxan->debug($msg.' '.$ex);
        }
    }
    
    public function connectToPostgres()
    {   
        try
        {
            /*C:\wamp\bin\apache\Apache2.2.17\bin\libpq.dll <- for it to worl*/
            $this->db = $this->Raxan->connect('pgsql:host=192.168.0.8;port=5432;dbname=ttms;user=postgres;password=tRafalger1');
            return $this->db;
        }
        catch(PDOException  $e)
        {
            echo $msg = "Connection Error..";
            $this->flashmsg($this->icon.$msg,'fade','alert alert-danger');
            $this->Raxan->debug($msg.' '.$ex);
        }
    }
}
?>