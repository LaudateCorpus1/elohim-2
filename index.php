<?php
include 'init.inc.php';

include THEME_INCLUDES_PATH.'header.inc.php';

$modules->import('userLogin');
$modules->import('userRegister');
$modules->import('userEdit');

echo "<pre>";
($user->userIsLoggedIn())?"LOGGED IN":"LOGGED OUT";
//print_r(DateTimeZone::listAbbreviations());
//print_r(DateTimeZone::listIdentifiers());
//$s = Session::getInstance();
//$s->put('test2', "hello2");
print_r($session->get());
echo "</pre>";

include THEME_INCLUDES_PATH.'footer.inc.php';
