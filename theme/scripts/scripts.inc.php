<?php

foreach (glob(SCRIPTS_PATH.'*.js') as $file) {
    echo '<script src="'.$file.'" type="text/javascript"></script>'."\n";
}

