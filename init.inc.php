<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($__DIR))
    $__DIR = '/';

include '/conf/vars.php';
include CLASS_PATH.'/classes.inc.php';

$modules = new Modules();

$user = new User();
