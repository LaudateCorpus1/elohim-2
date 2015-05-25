<?php

class Modules {
    public function import($path) {
        if (file_exists(MODULES_PATH.$path.'.module.php')) {
            include(MODULES_PATH.$path.'.module.php');
        }
    }
}