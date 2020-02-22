<?php
###################################SQL CONNECTION#############################################
    session_start();
    error_reporting(E_ALL); // when you finish testing you should change this to E_NONE
    define("DBUSERNAME", "root",  true);
    define("DBPASSWORD", "" ,  true);
    define("DBHOST", "localhost", true);
    define("DBDATABASE", "trafalgar",  true); 
    define("API_NEWS",   "news", true);
    define("API_DESTINATION", "location", true);
    define("API_SPECIALS", "specials", true);
    define("API_ADS", "ads", true);
    define("DB_DATA_ERROR", str_replace('_config', '', 'Data Error :: '.__FUNCTION__), true);
    define("API_FOLDER", 'api/',  true);
    define("API_IMAGE_FOLDER", API_FOLDER.'images/',  true);
    define("API_PATH", 'api/',  true);
    define('API_ACCESS_KEY', 'AAAAMPnjEs0:APA91bEvIqssa78IKx0w-4wpB13e0sPkXgK6ia-pCEpPOyEncxBRa3CXVYnI1JY-PFKeLJrNkopgSWMfO2WpCsMYoQv4btXySV-GxuxCs2lg5brEfnxQyhJFF90i1OSQo7gi_DPFJvwb', true);
##############################################################################################
    /*define("DOMAIN", 'http://'.$_SERVER['HTTP_HOST']."/jaschool_ver2/",  true);	
    define("IMG_DATA", "http://".$_SERVER['HTTP_HOST']."/nova/data/userpics/",  true);	
    define("SITE_NAME", "My-Schools.com",  true);
    define("NEEDTOLOGIN", "To view this area <a href='".DOMAIN."includes/login.php' rel='facebox'>click</a> here to login...",  true);*/
    
?>