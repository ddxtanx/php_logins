<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require 'password.php';
$link = mysqli_connect("****")
if(mysqli_connect_error()){
  die("Error: Not Connected to Server");
} else{
  #echo "Server is working...\n";
}

function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

function register(){
$link = mysqli_connect("localhost", "cl51-login-xxy", "form", "cl51-login-xxy");
$user_ip = getUserIP();
$email = mysqli_real_escape_string($link,$_POST['email']);
$id = mt_rand(1,10000);
$username= mysqli_real_escape_string($link,$_POST['username']);
$options = array('cost' => 11);
$pword = mysqli_real_escape_string($link,$_POST['password']);
if($email!="" && $username!=""&&$pword!=""){
$pass = password_hash($pword, PASSWORD_BCRYPT);
$query = "SELECT * FROM logins where username='$username' or email='$email' or ip='$user_ip';";
if(mysqli_query($link, $query)&&mysqli_num_rows(mysqli_query($link, $query))>0){
  echo "You have already registered!";
} else{  
  $query = "SELECT * FROM logins where id=$id;";
  $r = mysqli_query($link,$query);
  while(mysqli_num_rows($r)>0){
      $id=mt_rand(1,10000);
      $query = "SELECT * FROM logins where id=$id;";
      $r = mysqli_query($link,$query);
  }   
    $st = mysqli_real_escape_string($link,$_POST['username'])."_stories";
    $query = "CREATE TABLE $st (user TEXT, story TEXT, stid INT, numindex INT PRIMARY KEY, timestamp TEXT)";
    if($v = mysqli_query($link, $query)){
        echo "TABLE IS UP.";
        $query = "INSERT INTO `logins` (`username`, `email`, `password`, `id`, `ip`) VALUES('$username', '$email', '$pass', $id, '$user_ip')";
        if($result=mysqli_query($link, $query)){
        echo "It worked!"; 
        $_SESSION["loggedin"]=1;
        $_SESSION["user"]=mysqli_real_escape_string($link,$username);  
        header("Location: loggedin.php");  
        } else{
        echo "It failed";
        }
    } else{ 
        echo mysqli_error($link);
    }
}
} else{
    echo "Please enter in the fields below";
}
}
if($_SESSION["loggedin"]==1){
    echo "\n \n Dude, you're already logged in, no need to register again...";
}
if(isset($_POST['sub'])){
    register();
}
?>

<!DOCTYPE html>
<html>
<head>
  
</head>
<body>
  <form action="index.php" method="POST">
    <label for='email'>Email:</label>
    <input name='email' type='text' required>
    <label for='username'>Username:</label>
    <input name='username' type='text' required>
    <label for='password'>Password:</label>
    <input name='password' type='password' required>
    <input type='submit' name='sub'>
    <a href='login.php'>Login</a>
  </form>
</body>
</html>
