<?php 
include("../data/main.php");

$id = addslashes($_GET["id"]);
$d=mysql_fetch_assoc(mysql_query("SELECT `estado` FROM `asignaciones` WHERE `id`='$id'"));
if ($d["estado"]==0){$estado=1;}elseif ($d["estado"]==1){$estado=0;}
$q="UPDATE `asignaciones` SET `estado`='$estado' WHERE `id`='$id'";

mysql_query($q);
header("Location:./");
?>