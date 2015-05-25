<?php

$user = new User();

if (!isset($_REQUEST['username']) || !isset($_REQUEST['password']) || !isset($_REQUEST['email']))
    response(false, 'INVALID_PARAMETER_COUNT');

$result = $user->registerUser($_REQUEST['username'], $_REQUEST['password'], $_REQUEST['email']);

response($result[0], $result[1], isset($result[2])?$result[2]:'');
