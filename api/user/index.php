<?php

if (!isset($params[1]))
    response(false, 'NO_REQUEST');

if (!file_exists('user/'.$params[1]."User.php"))
    response(false, 'INVALID_REQUEST');

include 'user/'.$params[1].'User.php';
