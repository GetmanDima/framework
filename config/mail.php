<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Configured to send messages locally
return [
    'isSMTP' => false,
    'SMTPDebug' => SMTP::DEBUG_OFF, //Enable verbose debug output
    'host' => 'smtp.example.com', //Set the SMTP server to send through
    'SMTPAuth' => true, //Enable SMTP authentication
    'username' => '', //SMTP username
    'password' => '', //SMTP password
    'SMTPSecure' => PHPMailer::ENCRYPTION_STARTTLS, //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    'port' => 587, //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    'from' => ['email' => 'framework@example.com', 'name' => 'Framework Mailer']
];