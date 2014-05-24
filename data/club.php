<?
include("main.php");
$id=$_GET["ide"];
$q=mysql_query("SELECT `benId` FROM `asignaciones` WHERE `usrId`='$id' AND `estado`='0'");
$n=mysql_num_rows($q);
for ($i=0;$i<$n;$i++){
	$ud=mysql_fetch_assoc($q);
	$pq=mysql_fetch_assoc(mysql_query("SELECT * FROM `beneficio` WHERE `id`='".$ud["benId"]."'"));
	echo '<li>'.$pq["titulo"].'</li>';
}
$q=mysql_query("SELECT * FROM `beneficio` WHERE `tipo`='1'");
$n=mysql_num_rows($q);
for ($i=0;$i<$n;$i++){
	$ud=mysql_fetch_assoc($q);
	echo '<li>'.$ud["titulo"].'</li>';
}
mysql_query("UPDATE `asignaciones` SET `visto`='1' WHERE `usrId`='$id' AND `visto`='0'");
?>