<!DOCTYPE html>
<html>
<head>
	<title></title>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">

  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
  <title>Instructions</title>

</head>
<body>
<div class="meow" style="background-color:black;height:100vh;width:100vw;">
	<center><h2 style="color:white"><code><b>Instructions</b></code></h2></center>
	<code style="color:white" >
	<b><pre class="ins" style="font-size:20px" > <span class="typer" id="main" data-delay="20" data-deleteDelay="555555555555555555555555" data-words="
1. Keep your mobile phone switched off in your bag.
2. Contestants may write their programs in whichever language they prefer.
3. The following programming languages will be available. 
   (a) C (b) C++(c) JAVA (d) PYTHON 2.7 (e) PYTHON 3.0.
4. Those who will code in JAVA and will use our online editor to upload code. MAKE SURE THAT THE 
   CLASS NAME is q<question number> i.e. to submit question 1 (one) CLASS NAME SHOULD BE q1.
5. Contestants cannot bring any notes or textbooks to the contest room. 
   Blank sheets of paper  will be supplied.
6. Mobile phones are not allowed.
7. Level of difficulty of question increases as you will proceed from first to last. 
8. Use of internet is strictly prohibited.

Press Enter to start the contest.....
  
" data-colors="white"></span>
<span class="cursor" data-owner="main" style="transition: all 0.1s ease 0s; opacity: 0;">_</span>
		</pre></b>

	</code>
</div>
<div id="modal1" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4 style="color:red">Are you sure to continue?</h4>
      <br/>
      <br/>
      <h5>By agreeing this you sure you could follow this rules. <b>Breaking any of this rules will lead to direct disqualification.</b></h5>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat " onclick="continueStart()">Agree</a>
    </div>
  </div>
<script type="text/javascript">
var count = 1;
$(".modal").modal();
$('body').keypress(function(e){
	if(e.keyCode==13){
		$("#modal1").modal('open');
	}
	
});
function continueStart(){
	window.location="start.php"
}
</script>
<style type="text/css">
</style>
<script src="./script/typer.js"></script>

</body>
</html>