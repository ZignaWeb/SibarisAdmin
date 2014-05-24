<?php
include("main.php");
$error="";
$aho = date("Y-n-j h:i:s");
// ide nom are tel nro fec hor prf
$getP=array("ide","nom","are","tel","nro","fec","hor","prf");
foreach($getP as $key){
	$val=addslashes($_GET[$key]);
	$d[$key]=$val;
	if ($key!="prf" && $val == ""){
		$error.=" Todos los campos con la excepción de \"preferencias\" son obligatorios.";
		break;
	}
}
$hor=trim(strtolower($d["hor"]));

$hor = explode(":",str_replace(array(":"," ",".",","),":",$hor));

$hor[0]=trim($hor[0]);
$hor[1]=trim($hor[1]);
$hor[2]=trim($hor[2]);

if ($hor[2]=="pm" || $hor[1]=="pm"  ){if ($hor[0]+12 < 24) {$hor[0]=$hor[0]+12;}}
if ($hor[1]=="pm" || $hor[1]=="am" || !$hor[1]) {$hor[1]="00";}
if ($hor[1]=="hs") {$hor[1]="00";}
$hor=$hor[0].':'.$hor[1];

if (!strtotime($hor)){
	$error.= " Formato de hora incorrecto. $hor .";
}

$fech=explode("/",$d["fec"]);
$fyh = $fech[2]."-".$fech[0]."-".$fech[1]." ".$hor;

if ($error!=""){
	$return = "Error: ".$error;
}else{
	$q="INSERT INTO 
			`reservas` 
		SET `userid`='".$d["ide"]."',
			`nombre`='".$d["nom"]."', 
			`area`='".$d["are"]."', 
			`telefono`='".$d["tel"]."', 
			`comenzales`='".$d["nro"]."', 
			`fechahora`='".$fyh."', 
			`preferencias`='".$d["prf"]."', 
			`creada`='$aho'";
	$dat=mysql_fetch_assoc(mysql_query("SELECT `email` FROM `usuario` WHERE `id`='".$d["ide"]."'"));
	$d["email"]=$dat["email"];
	if(mysql_query($q)){
		$return = "Muchas Gracias. Solicitud de reserva sujeta a  disponibilidad. Le confirmaremos a la brevedad.";
		// datos reserva
		/*
		$usuario=mysql_fetch_assoc(mysql_query("SELECT * FROM `usuario` WHERE `id`='".$d["ide"]."'"));
		$un=$usuario["nombre"];
		$ue=$usuario["email"];
		*/
		$to=$email_reservas;
		$subject="NUEVA RESERVA - Modo Sibaris";
		$msj="Reserva mediante Modo Sibaris \n\n
Informacion de la reserva: \n
................................................ \n
A nombre de: ".$d["nom"]." \n
Número comensales: ".$d["nro"]." \n
Fecha y hora: ".$fyh." \n
Preferencias: ".$d["prf"]." \n\n
Informacion de contacto \n
................................................ \n
Teléfono: (".$d["are"].")".$d["tel"]." \n
Email: ".$d["email"]." \n";

		// al usuario
		mail($to,$subject,$msj);
		// al administrador
	}else{
		$return = "No se pudo crear la reserva.";
	}

}
	
echo $return;
?>