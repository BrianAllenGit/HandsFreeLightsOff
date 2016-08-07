<?php

include('global.php');

$num     = $_POST['lightNum'];
$opstate = "";
$offCode = "";
$onCode  = "";

$db = new MyDB();
if(!$db){
   echo $db->lastErrorMsg();
} 

   $sql =<<<EOF
      SELECT * from light WHERE ID = $num;
EOF;


$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
   $opstate = !$row['STATE'];//get opposite of current state of light num
   $offCode = $row['OffCode'];//get off-code used to send to receiver for light num
   $onCode  = $row['OnCode'];//get on-code used to send to receiver for light num
}


if($opstate){
  $sql ="UPDATE light set state = 1 where ID = {$num}";
}else{
  $sql ="UPDATE light set state = 0 where ID = {$num}";
}


$ret = $db->exec($sql);
if(!$ret){
  echo $db->lastErrorMsg();
}

$db->close();

$retInfo = array(
    "num"   => $num,
    "state" => $opstate
);

echo json_encode($retInfo);


//change signal to receiver to change state of light num
//send multiple times to ensure signal gets to receiver
if ($opstate){
  $command = "/var/www/rfoutlet/codesend {$onCode}";
  exec($command);
  exec($command);
  exec($command);
}else{
  $command = "/var/www/rfoutlet/codesend {$offCode}";
  exec($command);
  exec($command);
  exec($command);
}


?>
