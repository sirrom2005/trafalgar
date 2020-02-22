<?php
require_once('config/send_mail.php');

$to         =  "iceman <sirrom2005@gmail.com>";
    $subject    = "New Account open";
    $body       = '<h2>Dear rohan,</h2>
                                    Thank you for registering to use Guinep from Trafalgar Travel Ltd, you can use the information below to log into the app.
                                    <p><table cellpadding="0" cellspacing="0">
                                    <tr><td>Your email</td><td>:&nbsp;</td><td>ffff</td></tr>
                                    <tr><td>Password</td><td>:&nbsp;</td><td>ffff</td></tr>
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
    }