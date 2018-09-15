                        <!DOCTYPE html>
<html>
<body>
  <form>
	<h4>Question 1</h4>
    <textarea cols="100" rows="10" id = "t1">
    </textarea>
	<!--<button id = "b1g">Get</button><br>-->
    <input type="button" value="Submit">
  </form>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
var question = {"q":"John"};
$(document).ready(function(){
    $(":button").on("click",function(){
        $("#t1").append(question.q);
    });
});
</script>
</html>