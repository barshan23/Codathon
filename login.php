<?php 
require_once 'core/init.php';
if(Input::exists()){
	if(/*Token::check(Input::get('token'))*/true){
		$validate = new Validate();
		$validation = $validate->check($_POST,array(
			'email' => array('required' => true),
			'password' => array('required' => true)
		));
		
		if($validation-> passed()){
			$user = new User();
			$remember = (Input::get('remember') === 'on') ? true : false;
			$login = $user-> login(Input::get('email'),Input::get('password'),$remember);
			if($login){
				//$mark = createDashboard();
				if(!file_exists($user->data()->unique_id)){
					mkdir($user->data()->unique_id, 0777, true);
				}
				print json_encode(["success"=>""]);
				Redirect::to("type.php");
			}else {
				print json_encode(['fail'=>'<p><b> Sorry failed to login. Incorrect Credentials.</b></p>']);
			}
			
		}else {
			/*foreach ($validation -> errors() as $error){
				print $error.'<br />';*/
				print json_encode($validation->errors());
			}
		}
	}
?>

<html class="fa-events-icons-ready"><head>
    <title>Login</title>
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
<body>
<h1 style="color: #F8EDED;margin-left: 35%;">Codathon is
  <span class="typer" id="main" data-words="fun,exciting,amazing!" data-colors="#EE6E73" data-delay="100" data-deletedelay="1000" style="color: rgb(238, 110, 115);"></span>
  <span class="cursor" data-owner="main" style="transition: all 0.1s ease 0s; opacity: 0;">_</span>
</h1>
    <form method="post" action="">

        <div class="home">
            <div class="item">
                <div class="content">

                    <div class="card" style="width: 450px; border-radius: 10px">
                         
                        <div class="card-block">

                            <br>

                            <input name="email" id="email" class="form-control" placeholder="Email..." required="required" type="text"><br>
                            <input name="password" id="password" class="form-control" placeholder="Password..." required="required" type="password">
                            <br>
                            <label id="Label1" font-underline="True" forecolor="Red" font-bold="True" font-names="Arial"></label>
                            <center><button type="submit" id="Button1" class="btn btn-default btn-lg" onclick="">Login</button></center>
                             <br>
                            <center><a href="register.php" class="link">I want to join the competition</a></center>
                            

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

</body></html>