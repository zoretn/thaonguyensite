<?php
$to      = 'tvkarch@gmail.com';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: tvkarch@gmail.com' . "\r\n" .
    'Reply-To: tvkarch@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

$ret = mail($to, $subject, $message, $headers);
if ($ret) {
	echo "OK";
} else {
	echo "Fail";
}

?> 