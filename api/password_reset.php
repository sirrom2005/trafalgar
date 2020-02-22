<?php
include_once("config/ps_config.php");
require_once('config/send_mail.php');

$email  = base64_decode(trim(filter_input(INPUT_GET, 'q')));
$userId = base64_decode(trim(filter_input(INPUT_GET, 'k')));
$name   = base64_decode(trim(filter_input(INPUT_GET, 'u')));

$pass = generatePassword();

$sth = $db->prepare('UPDATE ttms.public.mobile_login SET password = ? WHERE user_id = ?');
$sth->execute(array(md5($pass), $userId));
$row = $sth->rowCount();

if(empty($row)){
    $sql = "INSERT INTO ttms.public.mobile_login "
            . "(user_id,"
            . "email,"
            . "password,"
            . "last_login,"
            . "date_added) "
            . "VALUES(?,?,?,?,?)";

    $sth = $db->prepare($sql);
    $sth->execute(array($userId,
                        $email,
                        md5($pass),
                        date("Y-m-d"),
                        date("Y-m-d")));
    $row = $sth->rowCount();
}

if($row){
    $to         = "{$name} <{$email}>";
    $subject    = "Guinep New Login";
    $body       = '<h2>Dear '.$name.',</h2>
                    You can use the information below to log into the Guinep Mobile App.
                    <p><table cellpadding="0" cellspacing="0">
                    <tr><td>Your email</td><td>:&nbsp;</td><td>'.$email.'</td></tr>
                    <tr><td>Password</td><td>:&nbsp;</td><td>'.$pass.'</td></tr>
                    </table></p>
                    <p>For any additional assistance, feel free to contact us via email at <a href="mailto:social@thetrafalgartravel.com">social@thetrafalgartravel.com</a> or by phone by calling the number listed below.</p>
                    Sincerely<br>
                    The Trafalgar Travel Team.';

    ob_start();
    require_once('../guinep-cms/views/EMAIL_TMP.php');
    $content = ob_get_contents();
    ob_end_clean();

    $body = str_replace('_CONTENT_', $body, $content);
    if(sendMail($to, $subject, $body) == "_MSG_SENT_"){ 
        header('location: https://www.trafalgaronline.com/');
    }else{
        echo "_EMAIL_ERROR_";
    }
}
echo "_ERROR_";
