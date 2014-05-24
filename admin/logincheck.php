<?php 
include("../data/main.php");

$myusername = addslashes($_POST["usr"]); 
$mypassword = addslashes($_POST["psw"]);
$q=mysql_query("SELECT * FROM `admins` WHERE `usr`='$myusername' AND `psw`='$mypassword'");
$count=mysql_num_rows($q);
if($count==1){
	$d=mysql_fetch_assoc($q);
	$mypermisos=$d["level"];
	session_register("myusername");
	session_register("mypermisos");
	header("Location:./");
} else {
	header("Location:./?e=usrpsw");
}
?>