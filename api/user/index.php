<?php

if (!isset($params[1]))
    response(false, 'NO_REQUEST');

if (!file_exists('user/'.$params[1]."User.php"))
    response(false, 'INVALID_REQUEST');

include 'user/'.$params[1].'User.php';


function validateUsernameCharacters($username) {
    return preg_match('/^[a-z0-9 ._-]{3,}$/i', $username);
}

function validatePasswordLength($password) {
    return strlen($password) >= 8;
}

function validateEmailAddress($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function generatePasswordSeed() {
    return md5($_SERVER['HTTP_USER_AGENT'].":".time().":".mt_rand(1,100000));
}

function encryptPassword($password) {
    $_seed = generatePasswordSeed();
    return hash('SHA256', $password.$_seed).":".$_seed;
}

function verifyPassword($password, $_enc) {
    $parts = explode(':', $_enc);
    return hash('SHA256', $password.$parts[1]) == $parts[0];
}

function generateActivationCode() {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $str = "";
    for ($i = 0; $i < 8; $i++)
        $str .= $chars[mt_rand(0,strlen($chars) - 1)];
    return $str;
}