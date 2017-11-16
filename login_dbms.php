
<?php 
   session_start();

   if(isset($_POST['Sign']))
   {
   	require_once("scripts/connect_db.php");
   	$uname=$_POST['name'];
   	$pwd=$_POST['password'];
   	$email=$_POST['email'];

   	/*
   	$result=mysql_query("SELECT * from user where email='$email'");
   	

   	if(mysqli_num_rows($result) > 0){
   		
   	    echo '<script language="javascript">';
        echo 'alert("This email already exist")';
        echo '</script>';
        exit(); 
   		
   	}
   	*/
   	//mysql_query("CREATE TRIGGER MysqlTrigger Before INSERT ON user FOR EACH ROW begin call aprocedure('$email') end;");
   	
   	mysql_query("INSERT INTO user(username,email) values('$uname','$email')") or die(mysql_error());
   	$f = mysql_query("SELECT @flag;");
   	$row=mysql_fetch_assoc($f);
    $id=intval($row['@flag']);

    if ($id == 1) {
      mysql_query("DELETE FROM user WHERE email = '$email';");
    }

   	$lastId = mysql_insert_id();
   	mysql_query("UPDATE user set u_id='$lastId' where u_id='$lastId' LIMIT 1") or die(mysql_error());
   	mysql_query("INSERT INTO password(u_id,password) values('$lastId','$pwd')") or die(mysql_error());
   	header('location: index.php');
   
}



?>

<html>
<head>
	<title>Login</title>
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
input[type=text], input[type=email], input[type=password] {
    width: 40%;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    background-color: white;
    background-image: url('p.png');
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 12px 20px 12px 40px;
}
input[type=submit] {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 10px 67px;
    text-decoration: none;
    margin: 4px 2px;
    cursor: pointer;
}
</style>
<script type="text/javascript">
	
</script>
</head>
<body class=body>
	<div class=msg>
	<form action="login_dbms.php" method="post">
    <input type="text" name="name" placeholder="First and Last Name" required><br>
    <input  type="email" name="email" placeholder="Email" required=""><br>
    <input type="password" name="password" placeholder="password" required><br>
    <input type="submit" value="Sign Up & Start Quiz" name="Sign" >
    </form> 
</div>
</body>
</html>
