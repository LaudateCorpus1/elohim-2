<?php

if (!isset($_REQUEST['username']) || !isset($_REQUEST['password']))
    response(false, 'INVALID_PARAMETER_COUNT');
