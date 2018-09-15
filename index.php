<?php
require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()){
    echo "Not logged in";
    Redirect::to("login.php");
}else{
    //echo "Logged in";
}

?>

<!doctype html>
<html>
<head>
	<title>Codathon</title>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" type="text/css"  href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.0/TweenMax.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.2/underscore-min.js"></script>

	<!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.1/css/materialize.min.css">

  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.1/js/materialize.min.js"></script>
  
  <script src = "https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.8/ace.js" ></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <script src="script/script.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
<div class="row">
<div class="navbar-fixed col s12" style="padding: 0">
  <nav>
    <div class="nav-wrapper">
      <a href="#" class="brand-logo"><img src="./codathon.png" /></a>
      <a href="#" id="timer" class="brand-logo right" style="margin-right:1%"></a>
    </div>
  </nav>
 </div>
</div>
<div class="row">

<div class ="side-nav fixed col s2" style = "margin-top:10%">
    <a class="subheader caption" ><b>Questions</b></a>
	<ul id="questions" class="collection">
		<li class="collection-item"><a href="#" id="ql1" onclick="openQuestion(1)">Question 1</a></li>
		<li class="collection-item"><a href="#" id="ql2" onclick="openQuestion(2)">Question 2</a></li>
		<li class="collection-item"><a href="#" id="ql3" onclick="openQuestion(3)">Question 3</a></li>
        <li class="collection-item"><a href="#" id="ql4" onclick="openQuestion(4)">Question 4</a></li>
        <li class="collection-item"><a href="#" id="ql5" onclick="openQuestion(5)">Question 5</a></li>

	</ul>
</div>
</div>
<div>
<div class = "row">
<div class="col s7 offset-s2">
    <div class="row" >
        <pre id="question_container" >
        </pre>
        <pre id="sample_container"></pre>
    
    </div>
    <div class="row">
    	<div class="row">
    			<div class="col s4">
    				<b><i>PASTE YOUR CODE :-</i></b>
    			</div>
    		</div>
        <div id = "editor"  style=" height: 50vh;">
        </div>
        
    </div>
    <div class="row ">
    	<form class="col s12" enctype="multipart/form-data">
    		<div class="row">
    			<div class="input-field file-field col s8 ">
		          <div class="btn">
			        <span>Upload file</span>
			        <input type="file" id="code_file">
			      </div>
			      <div class="file-path-wrapper">
			        <input class="file-path validate" type="text" placeholder="Upload one or more files">
			      </div>
		        </div>
		        <div class="col s4"  style="background-color:#f6f6f6;margin-top:2%">
			    		<select id="language">
					      <option value="1" selected>JAVA</option>
					      <option value="2">C</option>
					      <option value="3">C++</option>
					      <option value="4">PYTHON 2.7</option>
					      <option value="5">PYTHON 3</option>
					    </select>
			    </div>
		        
    		</div>
    		
    	</form>
    </div>
    <div class="row">
    	<div class="col s4"  style="float:right;padding:0 0 0 0" >
		    <button class="btn waves-effect waves-light light-green accent-4" onclick="sendCode()" name="action">Submit
		    <i class="material-icons right">send</i></button>
	    </div>
    </div>
    <div class="row">
    	<div class="col s12">
    		<h5>Status</h5>
    		<div id = "code_message" style="background-color:#f6f6f6">
    		</div>
    	</div>
    </div>
    </div>
	<div class = "col s3">
		<div class="row" id="score">
			<h5><b>Your Score </b> : <?php echo $user->data()->score ?> </h5>
		</div>
        <a class="subheader caption" ><b><a class="modal-trigger"" href="#modal_leaderboard"><span class="new badge" data-badge-caption="">View Full</span></a>LEADERBOARD</b></a>
        <ul class="collection" >

<?php

$db = DB::getInstance();
$data = $db->getAll('leaderboard');
/*foreach ($data as $key => $value) {
    echo "<li class=\"collection-item\" id=\"p".$key+1."\"><a href=\"\"><span class=\"badge\">".$value->score." points</span>Position ".$key+1."</a></li>";
}*/
$cnt = 1;
foreach ($data as $val) {
    if ($cnt > 10){
        break;
    }
    echo "<li class=\"collection-item p".$cnt++."\"style=\"border: solid black 1px;\"><a href=\"#\"><span 
    class=\"badge\">".$val->score." points</span>".$val->name."</a></li>";
}
//var_dump($data[1]);
?>
        
 	</ul>
	</div>
</div>


<div class="modal" id="success">
    <div class="modal-content" style="height: 50vh; width: 50vw;">
        <div id='congrats'>
            <h1 id='title'>Great job!</h1>
        </div>
    </div>
</div>

<div class="row">
	<div class="col s10 offset-s2">
		
	</div>
</div>
	</div>
	<div id="modal_leaderboard" class="modal">
		<div class="modal-content">
		<h4>LEADERBOARD</h4>
			<ul class="collection" >
<?php
$cnt = 1;
foreach ($data as $val) {
    echo "<li class=\"collection-item p".$cnt++."\" style=\"border: solid black 1px;\"><a href=\"#\"><span 
    class=\"badge\">".$val->score." points</span>".$val->name."</a></li>";
}
?>

	</ul>
		</div>
	</div>
  	<script type = "text/javascript">
        /*editor.setTheme("ace/theme/monokai");
		editor.getSession().setMode("ace/mode/c_cpp");
		$("button").click(function(){
			console.log(editor.getValue());	
		});*/

			var evtSource = new EventSource('leaderBoard.php');
			evtSource.onmessage = function(e){
			//console.log(e.data);
            var data = JSON.parse(e.data);
            //console.log(data[0].name);
			var animationName = 'animated flipOutY';
            var division = 0.08;
            var time = .1;

            data.forEach(function(ele, index, data){
                time += division;
                console.log(ele);
    			$(".p"+(index+1)).css({"-moz-animation-delay":" "+(time)+"s"}).addClass(animationName).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
    				$(this). html("<a href=\"#\"><span \
                    class=\"badge\">"+ele.score+" points<\/span>"+ele.name+"<\/a>");
    				$(this).removeClass(animationName);
                    var animation = 'animated flipInY';
                    $(".p"+(index+1)).addClass(animation).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
                
                    $(this).removeClass(animation);});
    			});
            });
		};

            // Click "Congratulations!" to play animation
var particles = ['.blob', '.star'],
     $congratsSection = $('#congrats'),
     $title = $('#title');

$(function() {
    init({
        numberOfStars: 20,
        numberOfBlobs: 10
    });
         
    fancyPopIn();
});

$congratsSection.click(fancyPopIn);

function fancyPopIn() {
    reset();
    animateText();
    
    for (var i = 0, l = particles.length; i < l; i++) {
        animateParticles(particles[i]);
    }
}

function animateText() {
    TweenMax.from($title, 0.65, {
        scale: 0.4,
        opacity: 0,
        rotation: 15,
        ease: Back.easeOut.config(5),
    });
}

function animateParticles(selector) {
    var xSeed = _.random(350, 380);
    var ySeed = _.random(120, 170);
    
    $.each($(selector), function(i) {
        var $particle = $(this);
        var speed = _.random(1, 4);
        var rotation = _.random(20, 100);
        var scale = _.random(0.8, 1.5);
        var x = _.random(-xSeed, xSeed);
        var y = _.random(-ySeed, ySeed);

        TweenMax.to($particle, speed, {
            x: x,
            y: y,
            ease: Power1.easeOut,
            opacity: 0,
            rotation: rotation,
            scale: scale,
            onStartParams: [$particle],
            onStart: function($element) {
                $element.css('display', 'block');
            },
            onCompleteParams: [$particle],
            onComplete: function($element) {
                $element.css('display', 'none');
            }
        });
    });
}

function reset() {
    for (var i = 0, l = particles.length; i < l; i++) {
        $.each($(particles[i]), function() {
            TweenMax.set($(this), { x: 0, y: 0, opacity: 1 });
        });
    }
    
    TweenMax.set($title, { scale: 1, opacity: 1, rotation: 0 });
}

function init(properties) {
    for (var i = 0; i < properties.numberOfStars; i++) {
      $congratsSection.append('<div class="particle star fa fa-star ' + i + '"></div>');
    }
    
    for (var i = 0; i < properties.numberOfBlobs; i++) {
      $congratsSection.append('<div class="particle blob ' + i + '"></div>');
    }   
}
		
	</script>
    </body>
</html>