<?
include("main.php");
$getId = $_GET["ide"];
$q="SELECT `id` FROM `asignaciones` WHERE `usrid`='$getId' AND `visto`='0'";
$ud=mysql_num_rows(mysql_query($q));
$return=$ud;
echo $return;
?>