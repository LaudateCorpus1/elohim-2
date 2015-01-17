<?php

$__DIR = '../';

include '../init.inc.php';

$db = new Database();

$params = explode('/', $_REQUEST['page']);

if (count($params) == 0) {
    exit;
}

switch ($params[0]) {
    case 'user':
        include 'user/index.php';
        break;
}


function response($success, $message = false) {
    echo json_encode(array('success'=>$success, 'message'=>$message));
    exit;
}