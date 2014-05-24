<div class="col2">
    <div class="cuadro main_wide menuSec">
        <? include("r/menuSec.php");?>
    </div>
    
    <div class="cuadro main_wide">
<?


/*
*opcionDia=0=Completo 
*opcionDia=1=Almuerzo
*opcionDia=2=Cena
*
*/
//$odV
$fecha=mysql_real_escape_string($_POST["date"]);
$odN=$_POST["opcionDia"];
$acc=$_POST["accion"];

$qt="SELECT * FROM `calendario` WHERE `fecha` = '$fecha'";
$qq=mysql_query($qt);
$n=mysql_num_rows($qq);


if($acc=='off'){//Deshabilitar  fecha
		if($n>0){//existe la fecha en la BD
		$qd=mysql_fetch_assoc($qq);
		$odV=mysql_real_escape_string($qd["dayoff"]);
		if(($odN==$odV)&&$odN==0){echo "Nada Para Deshabilitar";
			}	else { 
						 if(($odV==1 && $odN=2) || ($odV==2 && $odN=1) ){
							$odN=0;
						} 
						mysql_query("UPDATE `calendario` SET  `dayoff`='$odN'  WHERE `fecha` = '$fecha'"); 
				echo "<p>Fecha deshabilitada correctamente </p>";
			}
				}else{//no existe la fecha en la BD
							mysql_query("INSERT INTO `calendario` SET`fecha` = '$fecha' , `dayoff`='$odN' ");
							echo "<p>Fecha deshabilitada correctamente</p>";
				}	
}else{//$acc=='on' Habilitar fecha
			if($n>0){//existe la fecha en la BD
			$qd=mysql_fetch_assoc($qq);
			$odV=mysql_real_escape_string($qd["dayoff"]);
				if(($odN==0)||($odN==$odV)){
					mysql_query("DELETE FROM `calendario` WHERE `fecha` = '$fecha'");
					echo "<p>Fecha habilitada correctamente </p>";
				}else {
					if(($odN==1)&&($odN!=0)){
					$odN=2;
				}else if(($odN==2)&&($odN!=0)){
					$odN=1;
					}
					mysql_query("UPDATE `calendario` SET  `dayoff`='$odN'  WHERE `fecha` = '$fecha'");
						echo "<p>Fecha habilitada correctamente </p>";
			}
			}else{//no existe la fecha en la BD
				echo"Nada para habilitar";
			}
}




/*if ($_GET["d"]) {
	$fecha=mysql_real_escape_string($_GET["d"]);
	$q="SELECT * FROM `calendario` WHERE `fecha` = '$fecha'";
	$n=mysql_num_rows(mysql_query($q));
	if($n>0){
		mysql_query("DELETE FROM `calendario` WHERE `fecha` = '$fecha'");
		echo "<p>Fecha habilitada correctamente</p>";
	}else{
		mysql_query("INSERT INTO `calendario` SET `fecha` = '$fecha'");
		echo "<p>Fecha deshabilitada correctamente</p>";
	}
}else{
	echo "<p>No se pudo hacer el cambio.</p>";
}*/
?>
	</div>
</div>
<? include("r-lastLogins.php");?>