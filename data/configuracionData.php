<?php header('Access-Control-Allow-Origin: *');
include("main.php");
$get=explode("|",addslashes($_GET["u"]));
$id = $get[0];
$q=mysql_query("SELECT * FROM `usuario` WHERE `id`='$id'");
$d=mysql_fetch_assoc($q);
$d["c"]=explode("-",$d["cumple"]);
?>
<form id="form" action="http://restosibaris.com.ar/app/data/updateUserInfo.php" method="get">
		<input type="hidden" name="ide" id="ide" value="<?=$d["id"]?>" placeholder="ide"/>
        <input type="text" name="nom" id="username" value="<?=$d["nombre"]?>" placeholder="Nombre y apellido"/>
        <input type="text" name="ema" id="email" value="<?=$d["email"]?>" placeholder="Correo electr&oacute;nico"/>
        <input name="psw" placeholder="Contrase&ntilde;a" value="<?=$d["password"]?>" type="password" />
        <span class="tel">Tel&eacute;fono</span>
        <input type="text" name="are" id="area" value="<?=$d["area"]?>" placeholder="Area"/>
        <input type="text" name="tel" id="tel" value="<?=$d["telefono"]?>" placeholder="Tel&eacute;fono"/>
        <span class="nac">Nacimiento</span>
        <input name="dia" value="<?=$d["c"][2]?>" placeholder="DD">
        <input name="mes" value="<?=$d["c"][1]?>"  placeholder="MM">
        <input name="year" value="<?=$d["c"][0]?>" placeholder="YYYY">
        <input type="submit" value="Actualizar cuenta" />
    </form>
    <script type="text/javascript">
	$("#form").submit(function(event) {
	    event.preventDefault();
	    var url = $(this).attr('action');
		var datos = $(this).serialize();
	  
		$.get(url, datos, function(resultado) {
			if (resultado.search('Error:') == -1){
				alert(resultado);
				location.reload();
			}else{
				alert(resultado);
			}
		});
	});
	</script>