<?php

if (!isset($_REQUEST['username']) || !isset($_REQUEST['password']) || !isset($_REQUEST['email']))
    response(false, 'INVALID_PARAMETER_COUNT');

if (!validateUsernameCharacters($_REQUEST['username']))
    response(false, 'INVALID_USERNAME_CHARACTERS_OR_LENGTH');

if (!validatePasswordLength($_REQUEST['password']))
    response(false, 'INVALID_PASSWORD_LENGTH');

if (!validateEmailAddress($_REQUEST['email']))
    response(false, 'INVALID_EMAIL_ADDRESS');

if ($db->query('select userID from user where loginName=:loginName', array(':loginName'=>$_REQUEST['username'])) > 0)
    response(false, 'USERNAME_IN_USE');

if ($db->query('select emailAddress from user where emailAddress=:emailAddress', array(':emailAddress'=>$_REQUEST['email'])) > 0)
    response(false, 'EMAIL_ADDRESS_IN_USE');

$params = array(
    ':loginName' => $_REQUEST['username'],
    ':emailAddress' => $_REQUEST['email'],
    ':encPassword' => encryptPassword($_REQUEST['password']),
    ':signupDate' => time(),
    ':accountActivation' => generateActivationCode(),
    ':timezoneOffset' => isset($_REQUEST['timezone'])?(int)$_REQUEST['timezone']:'0',
    ':userEnabled' => 0
);

if (!registerUser($params))
    response(false, 'ERROR_CREATING_USER');

response(true, 'USER_CREATED');


function registerUser($params) {
    $db = new Database();
    return $db->query('insert into user (loginName, emailAddress, encPassword, signupDate, accountActivation, timezoneOffset, userEnabled) values (:loginName, :emailAddress, :encPassword, :signupDate, :accountActivation, :timezoneOffset, :userEnabled)', $params) == 1;

}