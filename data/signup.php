<?php
include("main.php");
session_start();
$error="";

if ($_GET["nom"] && $_GET["psw"] && $_GET["ema"] && $_GET["are"] && $_GET["tel"] && $_GET["year"] && $_GET["mes"] && $_GET["dia"]){
	$usr = addslashes($_GET["nom"]);
	$psw = addslashes($_GET["psw"]);
	$ema = addslashes($_GET["ema"]);
	$are = addslashes($_GET["are"]);
	$tel = addslashes($_GET["tel"]);
	$nac = addslashes($_GET["year"]).'-'.addslashes($_GET["mes"]).'-'.addslashes($_GET["dia"]);
	$hoy = date("Y-n-j");
	$aho = date("Y-n-j h:i:s");
	
	if (!ereg("^[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[@]{1}[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[.]{1}[A-Za-z]{2,5}$",$ema)){$error.=" El email ingresado no es v&aacute;lido.";}
	if (mysql_num_rows(mysql_query("SELECT * FROM `usuario` WHERE `email`='$ema'"))>0) {$error.=" Este email ya est&aacute; registrado.";}
	
	if ($error!=""){
		$return="Error: ".$error;
	}else{
		mysql_query("INSERT INTO `usuario` SET `nombre`='$nom', `email`='$ema', `password`='$psw', `area`='$are', `telefono`='$tel', `cumple`='$nac', `signupdate`='$hoy', `lastlogin`='$aho'");
		$id=mysql_insert_id();
		$return= $id.'|'.$nom;
		
		$bq=mysql_query("SELECT `id` FROM `beneficio` WHERE `tipo`='0'");
		$bn=mysql_num_rows($bq);
		for ($i=0;$i<$bn;$i++){
			$bd=mysql_fetch_assoc($bq);
			mysql_query("INSERT INTO `asignaciones` SET `usrId`='$id', `benId`='".$bd["id"]."', `fecha`='$ahora'");
		}
	}
	
}else{
	$return= "Error: Todos los campos son obligatorios.";
}
echo $return;
?>