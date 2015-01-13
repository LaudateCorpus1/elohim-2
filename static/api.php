<?php
$__DIR = '../';
include $__DIR.'init.inc.php';
print_r($_REQUEST);
if ($_REQUEST['request'] == "set") {
    setcookie('namebo', 'abcdefghijkl', time() + (86400 * 120), "/");
} else {
    print_r($_COOKIE);
}