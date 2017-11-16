<?php 

$msg = "";
if(isset($_GET['msg'])){
	$msg = $_GET['msg'];
	$msg = strip_tags($msg);
	$msg = addslashes($msg);
}
/*
$f = mysql_query("SELECT @flag;");
$row=mysql_fetch_assoc($f);
echo intval($row['@flag']);

if ($f == 1) {
  mysql_query("DELETE FROM user WHERE email = '$email';");
}
*/
?>
<!doctype html>
<html lang="en">
<head>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

<style type="text/css">
.body {

  background-image: url(background.png);

}
.msg {
   float: center;
    margin-top: 250px;
    margin-bottom: 100px;
    margin-right: 200px;
    margin-left: 500px;

}
.button2 {
   background-color: #4CAF50;
   font-size: 10px;
   border: 2px solid #4CAF50;
   padding: 8px 20px;
   color: white;
   border-radius: 5px;
   margin-left:220px;
   cursor: pointer;	
 }
.button {
  background-color: #4CAF50;
  font-size: 10px;
  border: 2px solid #4CAF50;
  color: white;
  border-radius: 5px;
  cursor: pointer;  
  padding: 8px 20px;
  margin-left:1220px;

}
	

</style>
<meta charset="utf-8">
<title>Quiz Tut</title>
<script>
function startQuiz(url){
	window.location = url;
}
function AddQuestion(url) {
  window.location = url;
}
</script>

</head>
<body class=body>
  <button class="button" onclick="AddQuestion('addQuestions.php')">ADDQuestion</button>
<div class=msg>
<?php echo $msg; ?>
<h3>Click below when you are ready to start the quiz</h3>
<button class="button2" onClick="startQuiz('quiz.php?question=1')">Click Here To Begin</button>

</div>
</body>
</html>