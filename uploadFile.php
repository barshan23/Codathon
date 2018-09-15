<?php
require_once '../core/init.php';

$user = new User();

if(true){
	if(Input::exists('get')){
		if(isset(Input::get("code"))){
			$myfile=fopen("meow"."_".Input::get('question_number').".".Input::get('extension'),"w");
    		fwrite($myfile,Input::get("code"));
    		fclose($myfile);
		}
	}
}

?>
