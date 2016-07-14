<?php
#ini_set('display_errors', 1);
#ini_set('display_startup_errors', 1);
#error_reporting(E_ALL);
session_start();
require 'password.php';
function login(){
        $link = mysqli_connect("****");
        $username=mysqli_real_escape_string($link, $_POST['username']);
        $options = array('cost' => 11);
        $pword =mysqli_real_escape_string($link, $_POST['password']);  
        $query = "SELECT password FROM logins WHERE username='$username'";
        $q = mysqli_query($link, $query);
        $pass = mysqli_fetch_assoc($q)['password'];
        $query = "SELECT * FROM logins where username='$username'";
        $q = mysqli_query($link, $query);  
        if(mysqli_num_rows($q)>0 && password_verify($pword, $pass) ){
            echo "User found";
            $_SESSION["user"]=mysqli_real_escape_string($link,"$username");
            $_SESSION["loggedin"]=1;
            $_SESSION["justloggedout"]=0;
            header("Location: loggedin.php");
        } else{
            echo "User not found";
        }
}
if(isset($_POST['login']))
{
   login();
} 
if($_SESSION["justloggedout"]==1){
        echo "\n \n <i> Ready to log back in? </i>";
}
 ?>

 <!DOCTYPE html>
 <html>
<head>

</head>
<body>
    <form action="login.php" method="POST">
        <label for='username'>Username:</label>
        <input name='username' type='text' required>
        <label for='password'>Password:</label>
        <input name='password' type='password' required>
        <input type='submit' name="login">
    </form>
    <a href='login.php'>Login</a>
    <a href='index.php'>Register</a>
</body>
</html>
