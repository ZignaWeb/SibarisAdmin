<?
if ($_GET["d"]) {
	$fecha=date("Y-n-j",$_GET["d"]);
	echo $fecha;
}else{
	echo "No se pudo hacer el cmabio.";
}
?>