<?php

if(isset($_POST['desc'])){
	if(!isset($_POST['iscorrect']) || $_POST['iscorrect'] == ""){
		echo "Sorry, important data to submit your question is missing. Please press back in your browser and try again and make sure you select a correct answer for the question.";
		exit();
	}
	if(!isset($_POST['type']) || $_POST['type'] == ""){
		echo "Sorry, there was an error parsing the form. Please press back in your browser and try again";
		exit();
	}
	require_once("scripts/connect_db.php");
	$question = $_POST['desc'];
	$answer1 = $_POST['answer1'];
	$answer2 = $_POST['answer2'];
	$answer3 = $_POST['answer3'];
	$answer4 = $_POST['answer4'];
	$type = $_POST['type'];
	$type = preg_replace('/[^a-z]/', "", $type);
	$isCorrect = preg_replace('/[^0-9a-z]/', "", $_POST['iscorrect']);
	$answer1 = strip_tags($answer1);
	$answer1 = mysql_real_escape_string($answer1);
	$answer2 = strip_tags($answer2);
	$answer2 = mysql_real_escape_string($answer2);
	$answer3 = strip_tags($answer3);
	$answer3 = mysql_real_escape_string($answer3);
	$answer4 = strip_tags($answer4);
	$answer4 = mysql_real_escape_string($answer4);
	$question = strip_tags($question);
	$question = mysql_real_escape_string($question);
	if($type == 'tf'){
	if((!$question) || (!$answer1) || (!$answer2) || (!$isCorrect)){
		echo "Sorry, All fields must be filled in to add a new question to the quiz. Please press back in your browser and try again.";
		exit();
		}
	}
	if($type == 'mc'){
	if((!$question) || (!$answer1) || (!$answer2) || (!$answer3) || (!$answer4) || (!$isCorrect)){
		echo "Sorry, All fields must be filled in to add a new question to the quiz. Please press back in your browser and try again.";
		exit();
		}
	}
	$sql = mysql_query("INSERT INTO questions (question, type) VALUES ('$question', '$type')")or die(mysql_error());
		$lastId = mysql_insert_id();
		mysql_query("UPDATE questions SET question_id='$lastId' WHERE id='$lastId' LIMIT 1")or die(mysql_error());
	//// Update answers based on which is correct //////////
	if($type == 'tf'){
		if($isCorrect == "answer1"){
		$sql2 = mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer1', '1')")or die(mysql_error());
		mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer2', '0')")or die(mysql_error());
		$msg = 'Thanks, your question has been added';
	  header('location: addQuestions.php?msg='.$msg.'');
	exit();
	}
	if($isCorrect == "answer2"){
		$sql2 = mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer2', '1')")or die(mysql_error());
		mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer1', '0')")or die(mysql_error());
		$msg = 'Thanks, your question has been added';
	  header('location: addQuestions.php?msg='.$msg.'');
	exit();
		}	
	}
	if($type == 'mc'){
		if($isCorrect == "answer1"){
		$sql2 = mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer1', '1')")or die(mysql_error());
		mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer2', '0')")or die(mysql_error());
		mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer3', '0')")or die(mysql_error());
		mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer4', '0')")or die(mysql_error());
		$msg = 'Thanks, your question has been added';
	  header('location: addQuestions.php?msg='.$msg.'');
	exit();
	}
	if($isCorrect == "answer2"){
		$sql2 = mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer2', '1')")or die(mysql_error());
		mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer1', '0')")or die(mysql_error());
		mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer3', '0')")or die(mysql_error());
		mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer4', '0')")or die(mysql_error());
		$msg = 'Thanks, your question has been added';
	  header('location: addQuestions.php?msg='.$msg.'');
	exit();
	}
	if($isCorrect == "answer3"){
		$sql2 = mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer3', '1')")or die(mysql_error());
		mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer1', '0')")or die(mysql_error());
		mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer2', '0')")or die(mysql_error());
		mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer4', '0')")or die(mysql_error());
		$msg = 'Thanks, your question has been added';
	  header('location: addQuestions.php?msg='.$msg.'');
	exit();
	}
	if($isCorrect == "answer4"){
		$sql2 = mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer4', '1')")or die(mysql_error());
		mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer1', '0')")or die(mysql_error());
		mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer2', '0')")or die(mysql_error());
		mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer3', '0')")or die(mysql_error());
		$msg = 'Thanks, your question has been added';
	  header('location: addQuestions.php?msg='.$msg.'');
	exit();
		}
	}
}
?>
<?php 
$msg = "";
if(isset($_GET['msg'])){
	$msg = $_GET['msg'];
}
?>
<?php 
if(isset($_POST['reset']) && $_POST['reset'] != ""){
	$reset = preg_replace('/^[a-z]/', "", $_POST['reset']);
	require_once("scripts/connect_db.php");
	mysql_query("TRUNCATE TABLE questions")or die(mysql_error());
	mysql_query("TRUNCATE TABLE answers")or die(mysql_error());
	$sql1 = mysql_query("SELECT id FROM questions LIMIT 1")or die(mysql_error());
	$sql2 = mysql_query("SELECT id FROM answers LIMIT 1")or die(mysql_error());
	$numQuestions = mysql_num_rows($sql1);
	$numAnswers = mysql_num_rows($sql2);
	if($numQuestions > 0 || $numAnswers > 0){
		echo "Sorry, there was a problem reseting the quiz. Please try again later.";
		exit();
	}else{
		echo "Thanks! The quiz has now been reset back to 0 questions.";
		exit();
	}
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Create A Quiz</title>
<script>
function showDiv(el1,el2){
	document.getElementById(el1).style.display = 'block';
	document.getElementById(el2).style.display = 'none';
}
</script>
<script>
function resetQuiz(){
	var x = new XMLHttpRequest();
			var url = "addQuestions.php";
			var vars = 'reset=yes';
			x.open("POST", url, true);
			x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			x.onreadystatechange = function() {
		if(x.readyState == 4 && x.status == 200) {
			document.getElementById("resetBtn").innerHTML = x.responseText;
			
	}
}
x.send(vars);
document.getElementById("resetBtn").innerHTML = "processing...";
	
}
</script>
<style type="text/css">
.content{
	margin-top:48px;
	margin-left:auto;
	margin-right:auto;
	width:780px;
	border:#333 1px solid;
	border-radius:12px;
	-moz-border-radius:12px;
	padding:12px;
	display:none;
}
body{
background-image: url(background.png);
}
button{
   background-color: #4CAF50;
   font-size: 10px;
   border: 2px solid #4CAF50;
   padding: 8px 20px;
   color: white;
   border-radius: 5px;
   cursor: pointer;
}
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>

<body>
   <div style="width:700px;margin-left:auto;margin-right:auto;text-align:center;">
   <p style="color:#06F;"><?php echo $msg; ?></p>
	<h2>What type of question would you like to create?</h2>
    <button onClick="showDiv('tf', 'mc')">True/False</button>&nbsp;&nbsp;<button onClick="showDiv('mc', 'tf')">Multiple Choice</button>&nbsp;&nbsp;
    <span id="resetBtn"><button onclick="resetQuiz()">Reset quiz to zero</button></span>
   </div>
  <div class="content" id="tf">
  	<h3>True or false</h3>
    	<form action="addQuestions.php" name="addQuestion" method="post">
    <strong>Please type your new question here</strong>
    	<br />
    		<textarea id="tfDesc" name="desc" style="width:400px;height:95px;"></textarea>
    	  <br />
    	<br />
    	<strong>Please select whether true or false is the correct answer</strong>
    	<br />
            <input type="text" id="answer1" name="answer1" value="True" readonly>&nbsp;
              <label style="cursor:pointer; color:#06F;">
            <input type="radio" name="iscorrect" value="answer1">Correct Answer?</label>
    	  <br />
   		<br />
            <input type="text" id="answer2" name="answer2" value="False" readonly>&nbsp;
              <label style="cursor:pointer; color:#06F;">
              <input type="radio" name="iscorrect" value="answer2">Correct Answer?
            </label>
    	  <br />
    	<br />
    	<input type="hidden" value="tf" name="type">
    	<input type="submit" value="Add To Quiz">
    </form>
 </div>
 <div class="content" id="mc">
  	<h3>Multiple Choice</h3>
    <form action="addQuestions.php" name="addMcQuestion" method="post">
    <strong>Please type your new question here</strong>
        <br />
        <textarea id="mcdesc" name="desc" style="width:400px;height:95px;"></textarea>
        <br />
      <br />
    <strong>Please create the first answer for the question</strong>
    	<br />
        <input type="text" id="mcanswer1" name="answer1">&nbsp;
          <label style="cursor:pointer; color:#06F;">
          <input type="radio" name="iscorrect" value="answer1">Correct Answer?
        </label>
      <br />
    <br />
    <strong>Please create the second answer for the question</strong>
    <br />
        <input type="text" id="mcanswer2" name="answer2">&nbsp;
          <label style="cursor:pointer; color:#06F;">
          <input type="radio" name="iscorrect" value="answer2">Correct Answer?
        </label>
      <br />
    <br />
    <strong>Please create the third answer for the question</strong>
    <br />
        <input type="text" id="mcanswer3" name="answer3">&nbsp;
          <label style="cursor:pointer; color:#06F;">
          <input type="radio" name="iscorrect" value="answer3">Correct Answer?
        </label>
      <br />
    <br />
    <strong>Please create the fourth answer for the question</strong>
    <br />
        <input type="text" id="mcanswer4" name="answer4">&nbsp;
          <label style="cursor:pointer; color:#06F;">
          <input type="radio" name="iscorrect" value="answer4">Correct Answer?
        </label>
      <br />
    <br />
    <input type="hidden" value="mc" name="type">
    <input type="submit" value="Add To Quiz">
    </form>
 </div>
</body>
</html>