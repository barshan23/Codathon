<?php
require_once "core/init.php";

$user = new User();

if($user->isLoggedIn()){
	if($user->data()->started == 0){
		$user->setTime();
		$user->setStarted();
		Redirect::to("index.php");
	}else{
		Redirect::to("index.php");
	}
}

?>