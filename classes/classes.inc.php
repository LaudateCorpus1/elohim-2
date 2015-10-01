<?php
foreach (glob(CLASS_PATH.'*/*.class.php') as $f) {
    if (is_file($f))
        include $f;
}

/* BEGIN SESSION INITIALIZATION */
$session = new Session();
$mailtemplates = new MailTemplates();

ini_set('session.save_handler', 'files');
session_set_save_handler($session, true);
session_save_path(SESSION_PATH);

$session->start();

if (!$session->isValid(5)) {
    $session->forget();
}
/* END SESSION INITIALIZATION */


