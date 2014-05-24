<?php header('Access-Control-Allow-Origin: *');

include("main.php");
session_start();

$appema = addslashes($_GET["ema"]);
$apppsw = addslashes($_GET["psw"]);

$q=mysql_query("SELECT `id`,`nombre` FROM `usuario` WHERE `email`='$appema' AND `password`='$apppsw'");
$d=mysql_fetch_assoc($q);
$count=mysql_num_rows($q);

$aho = date("Y-n-j h:i:s");

if ($count>0) {
	mysql_query("UPDATE `usuario` SET `lastlogin`='$aho' WHERE `email`='$appema' AND `password`='$apppsw'");
	echo $d["id"].'|'.$d["nombre"];
}else{
	echo "Denied";
}
?>