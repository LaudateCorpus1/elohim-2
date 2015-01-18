API INDEX<br /><?php

$__DIR = '../';

include '../init.inc.php';

$db = new Database();

$params = explode('/', $_REQUEST['page']);

if (count($params) == 0) {
    exit;
}

if (!file_exists($params[0].'/index.php'))
    response(false, 'NO_REQUEST');

include $params[0].'/index.php';

function response($success, $message = false) {
    echo json_encode(array('success'=>$success, 'message'=>$message));
    exit;
}