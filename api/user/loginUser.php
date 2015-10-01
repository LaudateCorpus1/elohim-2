<?php

$user = new User();

if (!isset($_REQUEST['username']) || !isset($_REQUEST['password']))
    response(false, 'INVALID_PARAMETER_COUNT');


$result = $user->loginUser($_REQUEST['username'], $_REQUEST['password']);


$session = new Session();

response($result[0], $result[1], $session->get('user.ban'));