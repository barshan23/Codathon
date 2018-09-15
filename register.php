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

    <link href="Content/bootstrap.min.css" rel="stylesheet" />
    <link href="Content/mdb.min.css" rel="stylesheet" />
    <link href="Content/style.css" rel="stylesheet" />
    <script src="Content/bootstrap.min.js"></script>
    <script src="Content/jquery-2.2.3.min.js"></script>
    <script src="Content/tether.min.js"></script>
    <script src="Content/mdb.min.js"></script>
    <link href="Content/myaddition2.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <script src="https://use.fontawesome.com/fbdc988716.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>


   
</head>
<body >
<h1 style="color: #F8EDED;margin-left: 35%;">Codathon is
  <span class="typer" id="main" data-words="fun,exciting,amazing" data-colors="#EE6E73" data-delay="100" data-deletedelay="1000" style="color: rgb(238, 110, 115);"></span>
  <span class="cursor" data-owner="main" style="transition: all 0.1s ease 0s; opacity: 0;">_</span>
</h1>
    <form style="margin-top: 10%" method="post" action="">

        <div class="home">
            <div class="item">
                <div class="content">
                    <div class="card" style="width: 450px; border-radius: 10px;margin-top: -20%;">
 
                        <div class="card-block">

                            <input type="text" name="username" id="username" class="form-control" placeholder="Username..." required="required">
                            <input type="password" name="password" id="pass" class="form-control " placeholder="Password..." required="required" MaxLength="10" BackColor="White">
                            <input name="cpassword" type="password" id="cpass" class="form-control " placeholder="Confirm Password..." required="required" MaxLength="10" BackColor="White">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name..." required="required">
                            <input type="text" name="email" id="email" class="form-control" placeholder="Email..." required="required">
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone..." required="required">
                            <input type="text" name="roll" id="roll" class="form-control" placeholder="Roll Number..." required="required">
                            <br>
                            <center><button ID="Button2" class="btn btn-default btn-lg" >Submit</button></center>
                            <br>
                            <center> <center><a href="login.php" class="link">I have already joined the competition</a></center></center>
                       
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </form>
<div style="background-image: url(./pics/6.png); -moz-filter: blur(5px); filter: blur(5px);  width: 100%;
  height: 100%;  position: fixed;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  z-index: -1;">
</div>
    <script type="text/javascript" src="script/typer.js"></script>
</body>

</html>

