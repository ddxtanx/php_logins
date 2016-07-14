<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require 'password.php';
if(mysqli_connect_error()){
  die("Error: Not Connected to Server");
} else{
  echo "Server is working...\n";
}
$user=$_SESSION['user'];
if($_SESSION["loggedin"]!=1){
    header("Location: login.php");
} else{
    echo "<b> Welcome "."$user"."</b>";
};
function logout(){
    $_SESSION["loggedin"]=0;
    $_SESSION["user"]="";
    header("Location: login.php");
    $_SESSION["justloggedout"]=1;
}
function post(){
    $link = mysqli_connect("*****");
    $user=mysqli_real_escape_string($link, $_SESSION['user']);
    $story = htmlentities(mysqli_real_escape_string($link, $_POST["poster"]), ENT_QUOTES);
    $date = date('d:m:Y G:i:s');
    $stid = mt_rand(1,10000);
    $st = mysqli_real_escape_string($link, $_SESSION['user'])."_stories";
    $query = "SELECT * FROM $st where stid=$stid;";
    $r = mysqli_query($link,$query);
  while(mysqli_num_rows($r)>0){
      $stid=mt_rand(1,10000);
      $query = "SELECT * FROM $st where stid=$stid;";
      $r = mysqli_query($link,$query);
  }  
    $query = "SELECT * FROM $st";
    $a = mysqli_query($link, $query);
    $numrows = mysqli_num_rows($a)+1;
    $query = "INSERT INTO $st (`user`, `story`, `stid`, `timestamp`, `numindex`) VALUES('$user', '$story', $stid, '$date', $numrows);";
    if($r = mysqli_query($link, $query)){
        echo " It worked!";
    } else {
        echo mysqli_error($link);
    }
}
if(isset($_POST['logout']))
{
   logout();
} 
if(isset($_POST['submit-story']))
{
   post();
} 
?>
<!DOCTYPE html>
<html>
<head>
    
</head>
    
<body>
    <form name='diarysubmit' method="post" action="loggedin.php">
        <label for="poster">Submit story</label>
        <textarea name="poster" placeholder="Put story here"></textarea>
        <input name="submit-story" type="submit" value="Post">
        <a href="stories.php">Stories</a>
    </form>
    <form name = 'logout' method="post" action="loggedin.php">
        <input type="submit" value="Log out" name="logout"/>
    </form>
</body>    

</html>