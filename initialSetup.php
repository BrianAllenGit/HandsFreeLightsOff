<?php
include('global.php');

$i = 0;
$stateInfo;

$db = new MyDB();
if(!$db){
   echo $db->lastErrorMsg();
}

$sql =<<<EOF
      SELECT * from light;
EOF;

//get all states that lights are currently in
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
   $stateInfo[$i] = $row['STATE'];
   $i = $i + 1;
}

$db->close();

//send it over to front end as json
echo json_encode($stateInfo);
?>
