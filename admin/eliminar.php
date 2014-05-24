<div class="col2">
    <div class="cuadro main_wide menuSec">
    	 <? include("r/menuSec.php");?>
    </div>
    
    <div class="cuadro main_wide">
    <?
	$que=mysql_real_escape_string($_GET["q"]);
	$ide=mysql_real_escape_string($_GET["i"]);
	
		if (borrar($secciones[$que]["db"],$ide)){
			echo '<p>¡Eliminado: '.ucfirst($secciones[$que]["t"]).'!</p>';
		}else{
			echo '<p>Error al eliminar el '.$secciones[$que]["t"].', inténtelo de nuevo.</p>';
		}
		
		function borrar($table, $idregistro){
			if (mysql_query("DELETE FROM `".$table."` WHERE `id`='".$idregistro."'")){
				return true;
			}else{
				return false;
			}
		}
	?>
    </div>
</div>
<div class="col1">
	<div class="cuadro main_wide"><h2><img src="r/modosibarisheader.png"></h2></div>
    <div class="cuadro main_wide">
    <table class="listaWide" cellpadding="0" cellspacing="0">
    <?
	$start=date("Y-m-d H:i:s");
	// estados 0:espera - 1:llegó - 2:cancelada app - 3:cancelada autogestion
	$rq=mysql_query("SELECT * FROM `usuario` WHERE 1 ORDER BY  `lastlogin` DESC");
	while($rd=mysql_fetch_assoc($rq)){
		echo "<tr>";
		echo "<td class='avatarHold'>
				<img class='avatar' src='http://restosibaris.com.ar/app/r/h_thumb.png'>
			</td><td class='nombre'>".$rd["nombre"]."<br>".$rd["lastlogin"]."</td>";
		echo "</tr>";
	}
    ?>
    </table>
    </div>
</div>
<script type="text/javascript">
setTimeout(function(){history.go(-1)},1000);
</script>