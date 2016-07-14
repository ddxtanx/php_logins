<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require 'password.php';
function escape($d){
    return htmlspecialchars($d, ENT_QUOTES, 'UTF-8');
}
$link = mysqli_connect("***");
$st = mysqli_real_escape_string($link, $_SESSION['user'])."_stories";
$query  = "SELECT * FROM $st";
$q = mysqli_query($link, $query);
$rows = mysqli_num_rows($q);
for($x = $rows; $x>0; $x--){
    $link = mysqli_connect("localhost", "cl51-login-xxy", "form", "cl51-login-xxy");
    $query  = "SELECT * FROM $st where numindex=$x";
    $q = mysqli_query($link, $query);
    $a = mysqli_fetch_assoc($q);
    echo "<div id='thing'>";
    $u = $a['user'];
    $s = html_entity_decode($a['story'], ENT_QUOTES);
    $t = $a['timestamp'];
    echo escape($u)."<br />".escape($s)."<br />".escape($t)."<br /> <br />";
    echo "</div>";
}
?>

<!DOCTYPE html>
<style>
    div{
        border-style: solid;
        border-width:5px;
        margin-bottom: 10px;
    }

</style>
<html>
<head>
    
</head>
<body>
    <a href="loggedin.php">Post</a>
</body>
</html>