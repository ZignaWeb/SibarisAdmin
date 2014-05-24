<?php 
include("../data/main.php");

$id = addslashes($_GET["id"]);
$d=mysql_fetch_assoc(mysql_query("SELECT `estado` FROM `reservas` WHERE `id`='$id'"));
if ($d["estado"]!=2){$estado=2;}elseif ($d["estado"]==2){$estado=0;}
$q="UPDATE `reservas` SET `estado`='$estado' WHERE `id`='$id'";

mysql_query($q);
header("Location:./");
?>