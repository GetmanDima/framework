<?php


namespace Core;

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    /**
     * @var PHPMailer $mail
     */
    protected PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->setConfigData();
    }

    /**
     * @param bool $isHtml
     * @param string $subject
     * @param string $body
     * @param string $altBody
     */
    public function setMessageData(bool $isHtml = true, string $subject = '', string $body = '', string $altBody = '')
    {
        $mail = $this->mail;

        $mail->isHTML($isHtml);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = $altBody;
    }

    /**
     * @param string $recipientEmail
     * @param string $recipientName
     */
    public function send(string $recipientEmail, string $recipientName = '')
    {
        $mail = $this->mail;

        try {
            if ($recipientName === '') {
                $mail->addAddress($recipientEmail);
            } else {
                $mail->addAddress($recipientEmail, $recipientName);
            }

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    private function setConfigData()
    {
        $mail = $this->mail;
        $config = require_once CONFIG_DIR . '/mail.php';

        //Server settings
        if ($config['isSMTP']) {
            $mail->isSMTP(); //Send using SMTP
        }

        $mail->SMTPDebug = $config['SMTPDebug'];
        $mail->Host       = $config['host'];
        $mail->SMTPAuth   = $config['SMTPAuth'];
        $mail->Username   = $config['username'];
        $mail->Password   = $config['password'];
        $mail->SMTPSecure = $config['SMTPSecure'];
        $mail->Port       = $config['port'];

        $mail->setFrom($config['from']['email'], $config['from']['name']);
    }
}