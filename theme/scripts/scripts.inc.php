<?php
foreach (glob(".".SCRIPTS_PATH.'*.js') as $file) {
    echo '<script src="'.substr($file, 1).'" type="text/javascript"></script>'."\n";
}

