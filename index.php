<?php
include 'init.inc.php';
include INCLUDES_PATH.'header.inc.php';



mysql_connect('localhost', 'mdcore_user', 'G3RjyH4/&oQ}?Oc');
mysql_select_db('md_v3');
$result = mysql_query('select * from merit_flaw where meritFlawStatus="restricted"');
echo '<pre>';
while ($row = mysql_fetch_assoc($result)) {
    $id = preg_replace('/[^\da-z-]/i', '', preg_replace('/[\W]/i', '-', strtolower($row['meritFlawName'])));
    echo '"'.$id.'": "'.$id.'"'.",\n";
}






include INCLUDES_PATH.'footer.inc.php';

