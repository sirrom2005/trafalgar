<?php
include_once("config/ps_config.php");
require_once('config/send_mail.php');

$name  = trim(filter_input(INPUT_POST, 'name'));
$email = trim(filter_input(INPUT_POST, 'email'));

if(empty($name) || empty($email)){echo '_NOT_CREATED_'; return null;}

$email = strtolower($email);

try{
    $sth = $db->prepare("SELECT dk_number FROM ttms.public.profile WHERE lower(trim(email)) = ?");
    $sth->execute(array($email));

    if($sth->fetchColumn()){
        echo '_ACCOUNT_EXIST_';
        return null;
    }

    $namePrt = explode(" ", $name);
    $data['lastname']   = (count($namePrt)>1) ? $namePrt[count($namePrt)-1] : "";
    $data['firstname']  = (count($namePrt)>1) ? str_replace($data['lastname'], "", $name) : $name;
    $data['agent_link'] = 125710;
    $data['ind_compy']  = "I";
    $data['email']      = $email;
    $data['enter_date'] = date("Y-m-d");
    $data['created_by_appointment_system'] = 'false';
    $data['createdate'] = date("Y-m-d");
    $data['newrecord']  = "Y";
    $data['send_survey']= 0;

    $sth = $db->prepare('INSERT INTO ttms.public.profile ('
                            . 'lastname,'
                            . 'firstname,'
                            . 'agent_link,'
                            . 'ind_compy,'
                            . 'email,'
                            . 'enter_date,'
                            . 'created_by_appointment_system,'
                            . 'createdate,'
                            . 'newrecord,'
                            . 'send_survey,'
                            . 'last_updateby) VALUES(?,?,?,?,?,?,?,?,?,?,?)');
    
    $sth->execute(array($data['lastname'],  $data['firstname'], $data['agent_link'],
                        $data['ind_compy'], $data['email'],     $data['enter_date'],
                        $data['created_by_appointment_system'],$data['createdate'],
                        $data['newrecord'],$data['send_survey'],'MOBILE_APP'));
    
    $sth = $db->prepare("SELECT lastval()");
    $sth->execute();
    $rs = $sth->fetchObject();

    if($rs->lastval){              
        $sth = $db->prepare('INSERT INTO ttms.public.mobile_login ('
                            . 'user_id,'
                            . 'email,'
                            . 'password,'
                            . 'last_login,'
                            . 'date_added) VALUES(?,?,?,?,?)');
        
	$pass = generatePassword();
        
        $sth->execute(array($rs->lastval,
                            $email,
                            md5($pass),
                            date("Y-m-d"),
                            date("Y-m-d")));
    
        if($sth->rowCount()){
            $data =  array( 'name'      => $name, 
                            'email'     => $email,
                            'pass'      => $pass,
                            'insert_id' => $rs->lastval);
            sendEmail($data);
        }else{
            echo '_NOT_CREATED_';
        }
    }else{
        echo '_NOT_CREATED_';
    }
}catch(Exception $ex){
    echo '_SYS_ERROR_';
}
    
function sendEmail($data){
    $to         =  "{$data['name']} <{$data['email']}>";
    $subject    = "New Account open";
    $body       = '<h2>Dear '.$data['name'].',</h2>
                                    Thank you for registering to use Guinep from Trafalgar Travel Ltd, you can use the information below to log into the app.
                                    <p><table cellpadding="0" cellspacing="0">
                                    <tr><td>Your email</td><td>:&nbsp;</td><td>'.$data['email'].'</td></tr>
                                    <tr><td>Password</td><td>:&nbsp;</td><td>'.$data['pass'].'</td></tr>
                                    </table></p>
                                    <p>For any additional assistance, feel free to contact us via email at <a href="mailto:social@thetrafalgartravel.com">social@thetrafalgartravel.com</a> or by phone by calling the number listed below.</p>
                                    Sincerely<br>
                                    The Trafalgar Travel Team.';

    ob_start();
    require_once('../guinep-cms/views/EMAIL_TMP.php');
    $content=ob_get_contents();
    ob_end_clean();

    $body = str_replace('_CONTENT_', $body, $content);
    if(sendMail($to, $subject, $body) == "_MSG_SENT_"){
        echo '_CREATED_';

        //Send email to trafalgar.
        sendMail('social@thetrafalgartravel.com', 
                "Guinep - New registration", 
                "New account was registred from the Guinep Mobile App<br>"
                . "{$data['name']} - {$data['email']}");
    }else{
        echo '_EMAIL_ERROR_';
    }
}

