<?php

$_pageContent = false;
/*
if (isset($_REQUEST['page'])) {
    $comp = explode('/', $_REQUEST['page']);

    $dir = PAGES_PATH . $comp[0];
    if (is_dir($dir)) {
        if (isset($comp[1])) {
            if (is_dir($dir."/".$comp[1])) {
                if (isset($comp[2]) && is_file($dir."/".$comp[1]."/".$comp[2].".php")) {
                    controllerInclude ($dir."/".$comp[1]."/".$comp[2].".php");
                } else {
                    controllerInclude ($dir."/".$comp[1]."/".$comp[1].".php");
                }
            } else if (is_file($dir . "/" . $comp[1] . ".php")) {
                controllerInclude ($dir . "/" . $comp[1] . ".php");
            } else {
                controllerInclude ($dir . "/" . $comp[0] . ".php");
            }
        } else {
            controllerInclude ($dir . "/" . $comp[0] . ".php");
        }
    } else {
        throwPageNotFound();
    }
} else {
    controllerInclude (PAGES_PATH."home.php");
}/*/