<?php
require_once 'core/init.php';
//date_default_timezone_set("America/New_York");
header("Content-Type: text/event-stream\n\n");

$db = DB::getInstance();
$user = new User();
if($user->isLoggedIn()){
  //echo "Logged in";
  //echo $user->data()->unique_id;
}else{
  //echo "Not logged in";
}
$counter = rand(1, 3);
  //if (!$counter) {
    $data = $db->getFlag('leaderboard',$user->data()->unique_id);
    //var_dump($data);
    $flag = $data[0]->flag;

    //var_dump($flag);
    if($flag != '0' /*|| $counter == 2*/){
		  $data = $db->getAll('leaderboard');
    	echo 'data:'. json_encode($data) . "\n\n";
      $db->setFlag('leaderboard',0,$user->data()->unique_id);
    }
  
  ob_end_flush();
  flush();
  sleep(1);
//}
?>