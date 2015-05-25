<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($__DIR))
    $__DIR = './';

include $__DIR.'conf/vars.php';
include $__DIR.'classes/classes.inc.php';

$modules = new Modules();

$user = new User();
