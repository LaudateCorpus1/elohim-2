<?php
$user = new User();

if (!isset($_REQUEST['password']) || !isset($_REQUEST['passwordNew']) || !isset($_REQUEST['passwordConfirm']) || !isset($_REQUEST['timezone']) || !isset($_REQUEST['email']) || !isset($_REQUEST['emailConfirm']))
    response(false, 'INVALID_PARAMETER_COUNT');

$result = $user->editUser($_REQUEST['password'], trim($_REQUEST['passwordNew']), trim($_REQUEST['passwordConfirm']), trim($_REQUEST['timezone']), trim($_REQUEST['email']), trim($_REQUEST['emailConfirm']));

response($result[0], $result[1], isset($result[2])?$result[2]:false);