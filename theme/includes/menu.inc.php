<?php
$menu = json_decode(file_get_contents('./conf/menu.json'), true);

function buildMenu($menu, $parent = false) {
    echo "<ul>";
    foreach ($menu as $k => $v) {
        echo "<li class='" . (isset($v['class'])?$v['class']:'') . "'><a href='".($parent?$parent:"").$v['link']."'>".$v['label']."</a>";
        if (isset($v['dependents']))
            buildMenu($v['dependents'], ($parent?$parent:"").$v['link']);
        echo "</li>";
    }
    echo "</ul>";
}

?>

<div id="menu">
    <div class="wrapper">
    <?php buildMenu($menu); ?>
    </div>
</div>

