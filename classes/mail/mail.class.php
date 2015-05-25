<?php
//error_reporting(E_ALL);
error_reporting(E_ALL & ~E_STRICT);

/*  DEMO
Sendmail::sendHTMLMail('devolutionary@devolutionary.net', array(
    'subject' => "This is a test",
    'text_message' => "Hey here's some text",
    'html_message' => "<h1>Hey!</h1><strong>Here</strong> <em>is </em><p>some text</p>"

));
*/

class Sendmail {

    private static function getConf() {
        return json_decode(file_get_contents(CLASS_PATH."mail/mail.conf.json"), true);
    }

    public static function sendHTMLMail($to, $params) {
        include('Mail.php');
        include('Mail/mime.php');


        $conf = self::getConf();

        // Constructing the email
        $subject = $params['subject'];
        $crlf = "\n";
        $headers = array(
            'From'          => $conf['EMAIL_FROM']." <".$conf["EMAIL_FROM_ADDRESS"].">",
            'Return-Path'   => $conf["EMAIL_FROM_ADDRESS"],
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
            'host' => $conf['EMAIL_SERVER'],
            'port' => $conf['EMAIL_PORT'],
            'auth' => $conf['EMAIL_AUTH'],
            'username' => $conf['EMAIL_USERNAME'],
            'password' => $conf['EMAIL_PASSWORD']
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

