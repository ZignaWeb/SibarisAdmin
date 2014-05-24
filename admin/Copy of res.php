<div class="col2">
    <div class="cuadro main_wide">
        <h2>Reservas</h2>
        <p id="fechaAhora"><?=date("Y-n-j")?></p>
        <p id="horaAhora"><?=date("H:i:s")?></p>
    </div>
    
    <div class="cuadro main_wide">
    <table class="listaWide" cellpadding="0" cellspacing="0">
    <?
	$start=date("Y-m-d H:i:s", strtotime($ya . ' -  1 hour'));
	$end=date("Y-m-d H:i:s", strtotime($ya . ' +  2 hour'));
	// estados 0:espera - 1:llegó - 2:cancelada app - 3:cancelada autogestion
	$rq=mysql_query("SELECT * FROM `reservas` WHERE `fechahora`>'$start' AND `fechahora`<'$end' AND `estado`<'2' ORDER BY  `estado` ASC, `fechahora` ASC");
	if (mysql_num_rows($rq)>0){
		while($rd=mysql_fetch_assoc($rq)){
			echo "<tr class='estado".$rd["estado"]."'>";
			$dh=explode(" ",$rd["fechahora"]);
			echo "<td class='avatarHold'>
					<img class='avatar' src='http://restosibaris.com.ar/app/r/h_thumb.png'>
				</td><td class='nombre'>".$rd["nombre"]."<span>".$rd["preferencias"]."</span></td><td class='resPara'><span>PARA</span><br>".$rd["comenzales"]."</td><td class='beneficio'><span>BENEFICIO</span><br>Postre helado</td><td class='hora'><a title='".$dh[1]."' class='cuadro' href='llego.php?id=".$rd["id"]."'><span>".$dh[1]."</span></a></td>";
			echo "</tr>";
		}
	}else{
		echo "<p>No hay reservas en este momento.</p>";
	}
    ?>
    </table>
    </div>
    
    <div class="cuadro main_wide">
    <p>Pr&oacute;ximas reservas:</p>
    <table class="listaWide" cellpadding="0" cellspacing="0">
    <?
	$start=date("Y-m-d H:i:s", strtotime($ya . ' +  3 hour'));
	// estados 0:espera - 1:llegó - 2:cancelada app - 3:cancelada autogestion
	$rq=mysql_query("SELECT * FROM `reservas` WHERE `fechahora`>'$start' AND `estado`<'2' ORDER BY  `estado` ASC, `fechahora` ASC");
	while($rd=mysql_fetch_assoc($rq)){
		echo "<tr class='estado".$rd["estado"]."'>";
		$dh=explode(" ",$rd["fechahora"]);
		echo "<td class='avatarHold'>
				<img class='avatar' src='http://restosibaris.com.ar/app/r/h_thumb.png'>
			</td><td class='nombre'>".$dh[0]."<br>".$rd["nombre"]."<span>".$rd["preferencias"]."</span></td><td class='resPara'><span>PARA</span><br>".$rd["comenzales"]."</td><td class='beneficio'><span>BENEFICIO</span><br>Postre helado</td><td class='hora'><a title='".$dh[1]."' class='cuadro' href='#'><span>".$dh[1]."</span></a></td>";
		echo "</tr>";
	}
    ?>
    </table>
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
setInterval("location.reload();", 30000);
</script>