<?php header('Access-Control-Allow-Origin: *');

include("main.php");

if ($_GET["email"]){
	// clean string
	$email = mysql_real_escape_string($_GET["email"]);
	// ver si existe
	$checkemail = mysql_query("SELECT * FROM `usuario` WHERE `email`='$email'");
	if (mysql_num_rows($checkemail)==1) {
		// buscar llos datos del usuario
		$d = mysql_fetch_assoc($checkemail);
		// send email con la contraseña
		$msj="Modo Sibaris\n\n
Pedido de recuperación de contraseña: \n
................................................ \n
Usuario: ".$d["nombre"]." \n\n
Email: ".$d["email"]." \n
Contraseña: ".$d["password"]." \n
................................................ \n";

		if(mail($email, "SIBARIS, su contraseña",$msj)){
			$return = "Le enviamos su contrase al mail introducido.";
		}
	}else{
			$return = "Error: no existe ese email en nuestros registros";
	}
}else{
	$return = "Error: intente de nuevo.";
}
echo $return;
?>