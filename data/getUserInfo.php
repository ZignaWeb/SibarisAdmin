<?
include("main.php");
$getId = $_GET["id"];
$ud=mysql_fetch_assoc(mysql_query("SELECT `nombre`,`area`,`telefono` FROM `usuario` WHERE `id`='$getId'"));
$return=$ud["nombre"]."|".$ud["area"]."|".$ud["telefono"];
echo $return;
?>