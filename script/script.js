var editor;
var currentQuestion=1;
var question_data = {};
var question_sample = {};
var question_solution_data = {};
var question_status = {};
var contestTime = 2;
var number_of_question = 5;
$(document).ready(function(){
    if (typeof(Storage) !== "undefined") {
        for(var i= 1;i<=number_of_question;i++){
            if(localStorage.hasOwnProperty("status_"+i)){
                $("#ql"+i).addClass(localStorage.getItem("status_"+i));
            }
        }
    }
    openQuestion(1);
     editor=ace.edit("editor");
            editor.setTheme("ace/theme/monokai");
            editor.getSession().setMode("ace/mode/javascript");
            document.getElementById('editor').style.fontSize='16px';

        $('select').material_select();
    $('select').on('change',function(){
        var lang = $("#language").val();
        var mode = "";
        if(lang == 1){
            mode = "java";
        }else if (lang == 2 || lang == 3 ){
            mode = "c_cpp";
        }else if (lang == 3 || lang == 4){
            mode = "python";
        }
        editor.getSession().setMode("ace/mode/"+mode);
    });
    $(".modal").modal();

    $.get("timeRemaining.php",function(data){
        data = parseInt(data);
        //var endTime = new Date(new Date().getTime()+(contestTime*60*1000)).getTime();
    var timeLeft = data;
    var minLeft = Math.floor(data/60);
    var secLeft = data%60;

    var countdown = setInterval(function(){
        var secLeftString = ""+secLeft;
        var minLeftString = ""+minLeft;
        if(secLeft<10)secLeftString = "0"+secLeftString;
        if(minLeft<10) minLeftString = "0"+minLeftString;
        $("#timer").html("<b>"+minLeftString+" : "+secLeftString+"</b>");
        //console.log(minLeft+" : "+secLeft);
        if(secLeft-1<0){
            secLeft = 59;
            minLeft-=1;
        }
        else{
           secLeft-=1;
            
        } 
        timeLeft-=1;
        if(timeLeft<0){
            clearInterval(countdown);
            $("#success").modal("open");
            $("#title").html("Time up!");
            fancyPopIn();
            setTimeout(function(){
                localStorage.clear();
                window.location = "showLeaderboard.php";
            }, 3000);
                
        }
    },1000);
}); 
    });

function sendCode(){
    var extension ;
    var extVal = $("#language").val();
    if(extVal == "1"){
        extension = 'java';
    }
    else if(extVal == "2"){
        extension = 'c';
    }
    else if(extVal == "3"){
        extension = 'cpp';
    }
    else if(extVal == "4"){
        extension = 'py2';
    }
    else{
        extension = "py3";
    }
    var file = $("input[type=file]")[0].files[0];
    if(file){
        var data = new FormData();
        data.append('file',file);
        data.append('extension',extension);
        data.append('question_number',currentQuestion);
        addStatusLoading();
        $.ajax({
            url: 'submit.php',
            type: 'POST',
            contentType:false,
            data: data,
            enctype: 'multipart/form-data',
            processData:false,
        }).done(function(data) {
            console.log(data);

            //data = JSON.parse(data);
            $("input[type=file]").val("");
            $(".file-path").val("");
            try{
                data = JSON.parse(data);
                if(data.status == '0'){
                   $("#code_message").html("<b ><i style='color:#ff8f00' class='material-icons'>report_problem</i>Compilation error <\/b>");
                   $("#code_message").append("<br/><code>"+data.mssg+"</code>");
                }
                else if(data.status == '2'){
                    question_status[currentQuestion]="solved";
                    $("#ql"+currentQuestion).addClass(question_status[currentQuestion]);
                    localStorage.setItem("status_"+currentQuestion,"solved");
                    $.ajax({
                        url:'getScore.php?score=1', 
                        success:function(result) {
                            console.log(result);
                            $("#score").html("<h5><b>Your Score </b> :- "+result+" points</h5>")
                        }
                    });
                    congrats();
                  $("#code_message").html("<b style='color:green;font-size:2em'><i class='material-icons'>check_circle</i>Correct Answer<\/b>");  

                }
                else if(data.status == '3'){
                    $("#code_message").html("<b ><i style='color:#ff8f00' class='material-icons'>report_problem</i>Runtime error <\/b>");
                   $("#code_message").append("<br/><code>"+data.mssg+"</code>");
                }
                else if(data.status == '4'){
                    $("#code_message").html("<b style='color:#ff8f00;font-size:2em'><i class=\"material-icons\">schedule</i>Time Limit Exceeded<\/b>");  
                }
                else if(data.status == '1'){
                    $("#code_message").html("<b style='color:red;font-size:2em'><i class='material-icons'>highlight_off</i>Wrong Answer<\/b>");  
                }
            }
            catch(e){
                console.log(e);
                $("#code_message").html("<b style='color:red;font-size:2em'><i class='material-icons'>highlight_off</i>Wrong Answer<\/b>");  
            }
        });
    }else{
        addStatusLoading()
        $.get("submit.php",{code:editor.getValue(),question_number:currentQuestion,extension:extension}).done(function(data){
            console.log(data);
            try{
                data = JSON.parse(data);
                if(data.status == '0'){
                   $("#code_message").html("<b ><i style='color:#ff8f00' class='material-icons'>report_problem</i>Compilation error <\/b>");
                   $("#code_message").append("<br/><code>"+data.mssg+"</code>");
                }
                else if(data.status == '2'){
                    question_status[currentQuestion]="solved";
                    localStorage.setItem("status_"+currentQuestion,"solved");
                    $("#ql"+currentQuestion).addClass(question_status[currentQuestion]);
                    $.ajax({
                        url:'getScore.php?score=1', 
                        success:function(result) {
                            console.log(result);
                            $("#score").html("<h5><b>Your Score </b> :- "+result+" points</h5>")
                        }
                    });
                    congrats();
                  $("#code_message").html("<b style='color:green;font-size:2em'><i class='material-icons'>check_circle</i>Correct Answer<\/b>");  
                }
                else if(data.status == '3'){
                    $("#code_message").html("<b ><i style='color:#ff8f00' class='material-icons'>report_problem</i>Runtime error <\/b>");
                   $("#code_message").append("<br/><code>"+data.mssg+"</code>");
                }
                else if(data.status == '4'){
                    $("#code_message").html("<b style='color:#ff8f00;font-size:2em'><i class=\"material-icons\">schedule</i>Time Limit Exceeded<\/b>");  
                }
                else if(data.status == '1'){
                    $("#code_message").html("<b style='color:red;font-size:2em'><i class='material-icons'>highlight_off</i>Wrong Answer<\/b>");  
                }
            }
            catch(e){
                $("#code_message").html("<b style='color:red;font-size:2em'><i class='material-icons'>highlight_off</i>Wrong Answer<\/b>");  
            }
        });
    }
}


function congrats(){
    var solved = 0;
    for(var i= 1;i<=number_of_question;i++){
        if(localStorage.hasOwnProperty("status_"+i)){
            if(localStorage.getItem("status_"+i) == 'solved'){
                solved++;
            }
        }
    }
    if(solved >= 4){
        $("#success").modal("open");
        $("#title").html("Great Job!");
        fancyPopIn();
        var count = 0;
        var v = setInterval(function(){
            //fancyPopIn();
            if(count == 1){
                $("#title").html("You are a genius!!");
                fancyPopIn();
            }
            if(count == 2){
                $("#title").html("<br />Welcome to our world!<br /> Keep going!");
                fancyPopIn();
            }
            if(count == 3){
                clearInterval(v);
            }
            count++;
        }, 1000);

    }
}


function openQuestion(quesNum){
    $("#code_file").val("");
    if(question_data.hasOwnProperty(quesNum)){
        //console.log("Hi");
        question_solution_data[currentQuestion] = editor.getValue();
        editor.setValue(question_solution_data[quesNum]);
        $("#question_container").html(question_data[quesNum]);
        $("#sample_container").text(question_sample[quesNum]);
        $("#ql"+quesNum).parent().addClass("active");
        $("#ql"+quesNum).removeClass(question_status[quesNum]);
        
    }
    else{
        //console.log("Hello");
        $.get("getQuestion.php",{data:""+quesNum},function(dat){
            //console.log(dat);
            dat = $.parseJSON(dat);
            question_solution_data[currentQuestion] = editor.getValue();
            question_data[quesNum] = dat["data"];
            question_sample[quesNum] = dat["sample"];
            question_solution_data[quesNum] = "";
            editor.setValue("");
            question_status[quesNum] = "unsolved"
            $("#question_container").html(dat["data"]);
            $("#sample_container").text(dat["sample"]);
            $("#ql"+quesNum).parent().addClass("active");
        })
    }
    
    $("#ql"+currentQuestion).parent().removeClass("active");
    $("#ql"+currentQuestion).addClass(question_status[currentQuestion]);
    $("#code_message").html("");
    currentQuestion = quesNum;
}

function addStatusLoading(){
    //$("#code-message").html("<b><i>Analyzing your solution. Keep Patience......</i></b><br/>");
    $("#code_message").html('<b><i>Analyzing your solution. Keep Patience......</i></b><br/><div style="margin-left:50%" class="preloader-wrapper big active">'+
    '<div class="spinner-layer spinner-green-only">'+
      '<div class="circle-clipper left">'+
       '<div class="circle"></div>'+
      '</div><div class="gap-patch">'+
        '<div class="circle"></div>'+
      '</div><div class="circle-clipper right">'+
        '<div class="circle"></div>'+
      '</div>'+
    '</div>'+
  '</div>')
}