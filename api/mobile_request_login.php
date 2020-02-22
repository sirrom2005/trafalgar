<?php
include_once("config/ps_config.php");
require_once('config/send_mail.php');

$email = trim(filter_input(INPUT_POST, 'email'));
if(empty($email)){echo '_NOT_FOUND_'; return;}

$email = strtolower($email);

try{
    $sth = $db->prepare("SELECT dk_number, p.firstname || ' ' || p.lastname AS fullname FROM ttms.public.profile p WHERE lower(trim(email)) = ? LIMIT 1");
    $sth->execute(array($email));
    $rs = $sth->fetchObject();
 
    if(isset($rs->dk_number)){
        $user_id = $rs->dk_number;
        if($user_id){
            $data =  array( 'name' => $rs->fullname, 
                            'email' => $email,
                            'insert_id' => $user_id);
            sendEmail($data);
        }else{
            echo '_NOT_CREATED_';
        }
    }else{
        echo "_NOT_FOUND_";
    }
}catch(Exception $ex){
    echo '_SYS_ERROR_';
}

function sendEmail($data){ 
    $to         =  "{$data['name']} <{$data['email']}>";
    $link       = 'http://api.trafalgartmc.com/password_reset.php?q='.base64_encode($data['email']).'&k='.base64_encode($data['insert_id']).'&u='.base64_encode($data['name']);
    $subject    = "Guinep Password reset";
    $body       = '<h2>Dear '.$data['name'].',</h2>
                        A requested was made for a new password form your Guinep mobile app. If this was you, you can click the link below and a password will be email to you.
                        <p><a href="'.$link.'">'.$link.'</a></p>
                        <p>If you don\'t make this request or want to change your password, just ignore and delete this message.</p>
                        <p>To keep your account secure, please don\'t forward this email to anyone.</p>

                        Sincerely<br>
                        The Trafalgar Travel Team.';

    ob_start();
    require_once('../guinep-cms/views/EMAIL_TMP.php');
    $content=ob_get_contents();
    ob_end_clean();

    $body = str_replace('_CONTENT_', $body, $content);
    if(sendMail($to, $subject, $body) == "_MSG_SENT_"){
       echo '_CREATED_';
    }else{
        echo '_EMAIL_ERROR_';
    }
}

