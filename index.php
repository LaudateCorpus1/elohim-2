<?php
include 'init.inc.php';

$controller = new Controller();

include THEME_INCLUDES_PATH . 'header.inc.php';
?>
    <div class="container" id="mainContainer">
        <div class="wrapper">
            <?php
            $controller->getPageContent();
            ?>
        </div>
    </div>
<?php
/*
echo "<pre>";
print_r($session->get());
echo "</pre>";
*/
include THEME_INCLUDES_PATH . 'footer.inc.php';
