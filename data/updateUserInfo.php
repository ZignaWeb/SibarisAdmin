<?
include("main.php");
$getId=addslashes($_GET["ide"]);
$return="";

if ($_GET["nom"] && $_GET["psw"] && $_GET["ema"] && $_GET["are"] && $_GET["tel"] && $_GET["year"] && $_GET["mes"] && $_GET["dia"]){
	$usr = addslashes($_GET["nom"]);
	$psw = addslashes($_GET["psw"]);
	$ema = addslashes($_GET["ema"]);
	$are = addslashes($_GET["are"]);
	$tel = addslashes($_GET["tel"]);
	$nac = addslashes($_GET["year"]).'-'.addslashes($_GET["mes"]).'-'.addslashes($_GET["dia"]);
	$hoy = date("Y-n-j");
	$aho = date("Y-n-j h:i:s");
	
	$q = "UPDATE `usuario` SET `nombre`='$nom', `email`='$ema', `password`='$psw', `area`='$are', `telefono`='$tel', `cumple`='$nac', `signupdate`='$hoy', `lastlogin`='$aho' WHERE `id`='$getId'";
	
	if (!ereg("^[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[@]{1}[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[.]{1}[A-Za-z]{2,5}$",$ema)){
		$return="Error: El email ingresado no es válido.";
	}elseif(mysql_query($q)){
		$return= "Datos actualizados correctamente.";
	}else{
		$return="Error: no se pudo actualizar el perfil.";
	}
	
}else{
	$return= "Error: Todos los campos son obligatorios.";
}
echo $return;
?>