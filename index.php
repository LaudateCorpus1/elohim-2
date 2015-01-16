<?php
include 'init.inc.php';
include INCLUDES_PATH.'header.inc.php';



mysql_connect('localhost', 'mdcore_user', 'G3RjyH4/&oQ}?Oc');
mysql_select_db('md_v3');
$result = mysql_query('select meritFlawName from merit_flaw where meritFlawIsUniversal=true');
//$result = mysql_query('select venueName, meritFlawName from venue natural join venue_has_merit_flaw natural join merit_flaw');
echo '<pre>';
while ($row = mysql_fetch_assoc($result)) {
    $mfid = preg_replace('/[^\da-z_]/i', '', preg_replace('/[\W]/i', '_', strtolower($row['meritFlawName'])));
    //$vnid = preg_replace('/[^\da-z_]/i', '', preg_replace('/[\W]/i', '_', strtolower($row['venueName'])));
    //$vmf[$vnid][] = $mfid;
    echo '"'.$mfid.'": "'.$mfid.'",'."\n";

}

//foreach ($vmf as $k => $r) {
    //echo '"'.$k.'": {';

    //foreach($r as $i)
    //echo '},'."\n";
//






include INCLUDES_PATH.'footer.inc.php';

