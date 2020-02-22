<?php
require_once "Mail.php";

$host = "192.168.0.247";
$port = "25";
$username = "ttsocial";
$password = "Trafalgar";
 
$smtp = Mail::factory(  'smtp',
                        array ( 'host' => $host,
                                'port' => $port,
                                'auth' => FALSE,
                                'username' => $username,
                                'password' => $password));
  
function sendMail($to, $subject, $body){
    global $smtp, $from; 
    $headers = array (  'From' => "Trafalgar Travel <no-replay@thetrafalgartravel.com>",
                        'To' => $to,
                        'Subject' => $subject,
                        'MIME-Version' => 1,
                        'Content-type' => 'text/html;charset=iso-8859-1');
 
    $mail = $smtp->send($to, $headers, $body);
 
    if (PEAR::isError($mail)) {
        return "_EMAIL_ERROR_"; //$mail->getMessage();
    } else {
        return "_MSG_SENT_";
    }
}