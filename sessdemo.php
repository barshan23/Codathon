<?php
require_once 'core/init.php';
date_default_timezone_set("America/New_York");
header("Content-Type: text/event-stream\n\n");

$db = DB::getInstance();

$counter = rand(1, 10);
//while (1) {
  // Every second, send a "ping" event.

  
  // Send a simple message at random intervals.
  
  
  $counter--;
  //if (!$counter) {
    $data = $db->getAll('leaderboard');
    $flag = $data[0]->flag;
    if($flag){
      echo 'data:'. json_encode($data) . "\n\n";
    }else{
      echo 'data: '.$flag."\n\n ";
    }
    $counter = rand(1, 10);
  //}
    //$lastId = $data[0]->unique_id;
  
  ob_end_flush();
  flush();
  sleep(1);
//}
?>     