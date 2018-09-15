<?php
require_once 'core/init.php';

$user = new User();

if($user->isLoggedIn()){
	if(Input::exists('get')){
		if(Input::get('score') == 1){
			echo $user->data()->score;
		}
	}
}
?>