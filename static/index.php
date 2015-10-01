<?php

$__DIR = '../';
$data_path = 'data/';

include '../init.inc.php';

if (!isset($_REQUEST['file']) || count($_REQUEST['file']) < 1 || !is_file($data_path.$_REQUEST['file'].".json")) {
    print_r("{}");
} else {
    print_r(file_get_contents($data_path.$_REQUEST['file'].".json"));
}

exit;
