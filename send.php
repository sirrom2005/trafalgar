<?php
//require_once('config/send_mail.php');

$to         = "Rohan Morris <sirrom2005@gmail.com>";
$subject    = "New Account open";
$body       = '<h2>Dear rohan,</h2>
                Thank you for registering to use Guinep from Trafalgar Travel Ltd, you can use the information below to log into the app.
                <p><table cellpadding="0" cellspacing="0">
                	<tr><td>Your email</td><td>:&nbsp;</td><td>asas@sdsds.com</td></tr>
                    <tr><td>Password</td><td>:&nbsp;</td><td>dfgdfgdfgdfg</td></tr>
                </table></p>
                <p>For any additional assistance, feel free to contact us via email at <a href="mailto:social@thetrafalgartravel.com">social@thetrafalgartravel.com</a> or by 				phone by calling the number listed below.</p>
                Sincerely<br>
                The Trafalgar Travel Team.';

ob_start();
require_once('views/EMAIL_TMP.php');
$content=ob_get_contents();
ob_end_clean();

echo $body = str_replace('_CONTENT_', $body, $content);
//sendMail($to, $subject, $body);