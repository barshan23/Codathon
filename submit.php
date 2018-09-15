<?php
require_once 'core/init.php';

// the score array containing the score of the questions
$score = array(1000, 1000, 2000, 2000, 3000);

$user = new User();
$db = DB::getInstance();
if($user->isLoggedIn()){

    if(Input::exists("get")){
        if((Input::get("code")) != null){
            $myfile=fopen("./".$user->data()->unique_id."/q".Input::get('question_number').".".Input::get('extension'),"w");
            fwrite($myfile,Input::get("code"));
            fclose($myfile);
            $path = "./".$user->data()->unique_id;
            $ext = Input::get('extension');
            $fileName = Input::get('question_number').".".Input::get('extension');
            $testin = './Questions/'.Input::get('question_number').".testin";
            $testout = './Questions/'.Input::get('question_number').".testout";
            exec("java CodeJudge ".$path." q".$fileName." ".$ext." ".$testin." ".$testout.' 2> output',$v);
            //var_dump($v[0]);
            $status = json_decode($v[0]);
            if($status->status == "2"){
            	$solved = $user->getSolved();
            	//var_dump($solved);
                if($user->getTimeRemaining() > 0){
                	if(!strchr($solved,(string)Input::get('question_number'))){
                		$curScore =(int) $user->getScore();
                		$user->setScore(($curScore + $score[Input::get('question_number')-1])+(int)$user->getTimeRemaining());
                		$user->setSolved($solved." ".(string)Input::get('question_number'));
                	}
                }

            }
            //var_dump($status);
            echo json_encode(json_decode($v[0]));

        }
    }else if (!empty($_FILES["file"]['tmp_name'])) {
	//var_dump($_FILES);
        $path = "./".$user->data()->unique_id."/";
        $fileName = $_FILES["file"]["name"];
        //var_dump($fileName);
        move_uploaded_file($_FILES['file']['tmp_name'], $path.$_FILES["file"]["name"]);
        $ext = Input::get('extension');
        $testin = './Questions/'.Input::get('question_number').".testin";
        $testout = './Questions/'.Input::get('question_number').".testout";
        exec("java CodeJudge ".$path." ".$fileName." ".$ext." ".$testin." ".$testout.' 2> output',$v);
        //var_dump($v[0]);
        $status = json_decode($v[0]);
        if($status->status == "2"){
         	$solved = $user->getSolved();
            if($user->getTimeRemaining() > 0){
               	if(!strchr($solved,(string)Input::get('question_number'))){
               		$curScore =(int) $user->getScore();
               		$user->setScore(($curScore + $score[Input::get('question_number')-1])+(int)$user->getTimeRemaining());
               		$user->setSolved($solved." ".(string)Input::get('question_number'));
               	}
           }
        }

        echo json_encode(json_decode($v[0]));
    }
}

?>
