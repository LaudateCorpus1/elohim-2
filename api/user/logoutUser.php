<?php

$user = new User();

if ($user->logoutUser())
    response(true, "LOGOUT_SUCCESSFUL", false);

response(false, "LOGOUT_FAILED", false);
