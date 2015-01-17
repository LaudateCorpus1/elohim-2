<?php
error_reporting(E_ALL & ~E_STRICT);
class Mail {

    private static function getConf() {
        return json_decode(file_get_contents(CLASS_PATH."mail/mail.conf.json"), true);
    }

    public static function sendMail($to, $params)
    {
        require_once "Mail.php";

        $conf = self::getConf();

        $headers = array(
            'From' => $conf['EMAIL_FROM'],
            'To' => $to,
            'Subject' => $params['subject']
        );

// ssl://smtp.gmail.com
// 465
// true

        $smtp = Mail::factory('smtp', array(
            'host' => $conf['EMAIL_SERVER'],
            'port' => $conf['EMAIL_PORT'],
            'auth' => $conf['EMAIL_AUTH'],
            'username' => $conf['EMAIL_USERNAME'],
            'password' => $conf['EMAIL_PASSWORD']
        ));

        $mail = $smtp->send($to, $headers, $params['message']);

        if (PEAR::isError($mail)) {
            echo('<p>' . $mail->getMessage() . '</p>');
        } else {
            echo('<p>Message successfully sent!</p>');
        }
        return true;
    }

    public static function sendHTMLMail($to, $params) {
        include('Mail.php');
        include('Mail/mime.php');

        // Constructing the email
        $subject = $params['subject'];                                            // Subject for the email
        $crlf = "\n";
        $headers = array(
            'From'          => EMAIL_FROM." <".EMAIL_FROM_ADDRESS.">",
            'Return-Path'   => EMAIL_FROM_ADDRESS,
            'Subject'       => $subject
        );

        // Creating the Mime message
        $mime = new Mail_mime($crlf);

        // Setting the body of the email
        $mime->setTXTBody($params['text_message']);
        $mime->setHTMLBody($params['html_message']);

        $headers = $mime->headers($headers);

        // Sending the email
        $smtp = Mail::factory('smtp', array(
            'host' => 'ssl://smtp.gmail.com',
            'port' => '465',
            'auth' => true,
            'username' => EMAIL_USERNAME,
            'password' => EMAIL_PASSWORD
        ));

        $mail = $smtp->send($to, $headers, $mime->get());

        if (PEAR::isError($mail)) {
            return false;
        } else {
            return true;
        }
    }

    public static function sendAdminEmail($cause)
    {
        return true;
    }
}

