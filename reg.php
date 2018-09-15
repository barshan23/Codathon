<?php
require_once 'core/init.php';
if (Input::exists ()) {
	if (/*Token::check(Input::get('token'))*/1) {
		//var_dump($_POST);
		$validate = new Validate ();
		$validation = $validate->check ( $_POST, array (
				'username' => array (
						'required' => true,
						'min' => 2,
						'max' => 20,
						'unique' => 'users' 
				),
				'email' => array(
						'required' => true,
						'min' => 5,
						'max' => 49,
						'unique' => 'users'
				),
				'password' => array (
						'required' => true,
						'min' => 6,
						'max' => 20 
				),
				'cpassword' => array (
						'required' => true,
						'matches' => 'password' 
				),
				'name' => array (
						'required' => true,
						'min' => 2,
						'max' => 50 
				) 
		) );
		
		if ($validate->passed ()) {
			//echo "passed";
			//header ( 'location:index.php' );
			$user = new User ();
			$db = DB::getInstance();
			$salt = Hash::salt ();
			
			try {
				$user->create ( array (
						'username' => Input::get ( 'username' ),
						'email' => Input::get('email'),
						'rollnumber' => Input::get('roll'),
						'phone' => Input::get('phone'),
						'password' => Hash::make ( Input::get ( 'password' ), $salt ),
						'salt' => $salt,
						'name' => Input::get ( 'name' ),
						'joined' => date ( 'Y-m-d H:i:s' ),
						'groups' => 1,
						'unique_id' => md5 ( uniqid () )  // it is a unique id that is used for stopping a hacker to view another users profile
								) );
				
				Session::flash ( 'home', 'You have been registered successfully' );
				//$user = new User();
				//$remember = (Input::get('remember') === 'on') ? true : false;
				//$login = $user-> login(Input::get('username'),Input::get('email'),Input::get('password'),$remember);
				echo json_encode(["success"=>true]);
				Redirect::to("login.php");
			} catch ( Exception $e ) {
				die ( $e->getMessage () );
			}
		} else {
			echo json_encode( $validate->errors ());
		}
	}
}
?>


<!DOCTYPE html>

<html>
<head>
    <title>Registration</title>

    <link href="Content/bootstrap.min.css" rel="stylesheet">
    <link href="Content/mdb.min.css" rel="stylesheet">
    <link href="Content/style.css" rel="stylesheet">
    <script src="Content/bootstrap.min.js"></script>
    <script src="Content/jquery-2.2.3.min.js"></script>
    <script src="Content/tether.min.js"></script>
    <script src="Content/mdb.min.js"></script>
    <link href="Content/add.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://use.fontawesome.com/fbdc988716.js"></script><link href="https://use.fontawesome.com/fbdc988716.css" media="all" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


   
</head>
<body style="background-image: url(./pics/6.png);">
    

<div class="container white register-form">

<form   class="col s6 l6 m6 offset-s3 offset-l3 offset-m3">
	<div class="row">
	<div class="input-field col s6">
		<input type="text" name="name" id="student_name" class="validate">
		<label for="student_name">Name</label>
	</div>
	<div class="input-field col s6">
		<input type="text" name="roll" id="student_roll" class="validate">
		<label for="student_roll">Roll Number</label>
	</div>
	</div>
	<div class="row">
	<div class="input-field col s12">
		<input type="email" name="email" id="student_email" class="validate">
		<label  data-error="enter valid url" for="student_email">Email</label>
	</div>
	</div>
	<div class="row">
		<div class="input-field col s4">
		    <select class="stream" id="stream">
		      <option value="aeie" >AEIE</option>
		      <option value="cse">CSE</option>
		      <option value="ee">EE</option>
		      <option value="ece">ECE</option>
		      <option value="it">IT</option>
		    </select>
    <label>Choose Stream</label>
    </div>
    <div class="input-field col s4">
		    <select class="year" id="year">
		      <option value="1" selected>1st</option>
		      <option value="2">2nd</option>
		      <option value="3">3rd</option>
		      <option value="4">4th</option>
		    </select>
    <label>Choose Year</label>
    </div>
    <div class="input-field col s4">
		    <select class="sec" id="sec">
		      <option value="A" selected>A</option>
		      <option value="B">B</option>
		    </select>
    <label>Choose Section</label>
  </div>
	</div>
	<div class="row">
	<div class="input-field col s6">
		<input type="password" name="password" id="student_password" class="validate">
		<label for="student_password">Password</label>
	</div>
	<div class="input-field col s6">
		<input type="password" name="cpassword" id="student_cpassword" class="validate">
		<label for="student_cpassword">Confirm Password</label>
	</div>
	</div>
	
	<div class="row">
		<div class="col s6 offset-s3">
			<button class="btn waves-effect waves-light" type="submit"   name="action">Register
			    <i class="material-icons right">send</i>
			  </button>
		</div>
	</div>
</form>
</div>
</body>
</html>

