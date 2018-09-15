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

	<!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.1/css/materialize.min.css">

  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.1/js/materialize.min.js"></script>
  
  <script src = "https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.8/ace.js" ></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
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
<div class="container">
    <center><h4><b>LEADERBOARD</b></h4></center>
          <ul class="collection" >

    <?php
    $db = DB::getInstance();
    $data = $db->getAll('leaderboard');
    $cnt = 1;
    foreach ($data as $val) {
      $imgNum =1;
      $colSize = 0;
      if($cnt>3){
        echo "<li class=\"collection-item avatar p".$cnt++."\" style=\"border: solid black 1px;min-height:58px\"><img src='4.png' class='circle'><span 
        class=\"badge\">".$val->score." points</span>".$val->name."</li>";
      }
      else{
        echo "<li class=\"collection-item avatar p".$cnt++."\" style=\"border: solid black 1px;\"><img src='".($cnt-1).".png' class='circle'><span class=\"badge\">".$val->score." points</span><span style='margin-left: 4%;font-size: 2em;padding-top: 6%;'>".$val->name."</span></li>";
      }
       
    }
    ?>
    </ul>
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
            var ht = "";
            console.log(index);
            if(index >= 3){
              ht = "<img src='4.png' class='circle'><span class=\"badge\">"+ele.score+" points</span>"+ele.name;
            }else {
              ht =  "<img src='"+(index+1)+".png' class='circle'><span   class=\"badge\">"+ele.score+" points</span><span style='margin-left: 4%;font-size: 2em;padding-top: 6%;'>"+ele.name+"</span>";
            }
            $(this). html(ht);
            $(this).removeClass(animationName);
                    var animation = 'animated flipInY';
                    $(".p"+(index+1)).addClass(animation).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
                    $(this).removeClass(animation);});
          });
            });
    };
    </script>

</div>
</body>
</html>