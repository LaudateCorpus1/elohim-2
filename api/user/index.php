<?php

if (!isset($params[1])) exit;

switch ($params[1]) {
    case 'register':
        include 'registerUser.php';
        break;
}