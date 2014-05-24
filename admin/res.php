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
	$end=date("Y-m-d H:i:s", strtotime($ya . ' +  3 hour'));
	// estados 0:espera - 1:llegó - 2:cancelada app - 3:cancelada autogestion
	$q="SELECT * FROM `reservas` WHERE `fechahora`>'$start' AND `fechahora`<'$end' AND `estado`<='2' ORDER BY  `estado` ASC, `fechahora` ASC";
	$rq=mysql_query($q);
	if (mysql_num_rows($rq)>0){
		while($rd=mysql_fetch_assoc($rq)){
			echo "<tr class='estado".$rd["estado"]."'>";
			$dh=explode(" ",$rd["fechahora"]);
			$beneficio="";
			$bq="SELECT `asignaciones`.`id` AS `asigId`, `beneficio`.`id` AS `id`, `beneficio`.`titulo` AS `titulo`
					FROM `asignaciones`, `beneficio`
					WHERE 
					(
					  `asignaciones`.`benId` = `beneficio`.`id`
					AND
					  `asignaciones`.`usrId` = '".$rd["userid"]."'
					AND
					  `asignaciones`.`estado`='0'
					AND
					  `beneficio`.`hasta`>='".$hoy."'
					)";
			$bq=mysql_query($bq);
			$bs=mysql_query("SELECT * FROM `beneficio` WHERE `tipo`='1'");
			$obs=mysql_fetch_assoc(mysql_query("SELECT `observaciones` FROM `usuario` WHERE `id`='".$rd["userid"]."'"));
			for($k=0;$k<mysql_num_rows($bs);$k++){
				$bsd=mysql_fetch_assoc($bs);
				$beneficio.=" ".$bsd["titulo"]." ";
			}
			$bn=mysql_num_rows($bq);
			for ($j=0;$j<$bn;$j++){
				$bd=mysql_fetch_assoc($bq);
				$beneficio.="<a class='benLink' href='benPedido.php?id=".$bd["asigId"]."'> ".$bd["titulo"]."</a>";
			}
			// mostrar estado si no llegó
			if ($rd["estado"]<2){
				$confLnk = "(<a class='benLink' href='confirmar.php?id=".$rd["id"]."'>".$secciones["res"]["c"]["estado"]["options"][$rd["estado"]]."</a>)";
			}else{
				$confLnk = "";	
			}
			echo "<td class='avatarHold'>
					<img class='avatar' src='http://restosibaris.com.ar/app/r/h_thumb.png'>
				</td>
				<td class='nombre'>".$rd["nombre"]." $confLnk<span>
				<a href='?q=res&a=edit&i=".$rd["id"]."'>Editar</a> | 
				<a class='eliminarelemeto' href='?q=res&a=eliminar&i=".$rd["id"]."'>Eliminar</a> | 
				(".$rd["area"].")".$rd["telefono"]." <br /> ".$rd["preferencias"]." - ".$obs["observaciones"]."</span></td><td class='resPara'><span>PARA</span><br>".$rd["comenzales"]."</td><td class='beneficio'><span>BENEFICIO</span><br>$beneficio</td><td class='hora'><a title='".$dh[1]."' class='cuadro' href='llego.php?id=".$rd["id"]."'><span>".$dh[1]."</span></a></td>";
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
	$q="SELECT * FROM `reservas` WHERE `fechahora`>='$start' AND `estado`<'2' ORDER BY  `estado` ASC, `fechahora` ASC";
	$rq=mysql_query($q);
	$i=0;
	while($rd=mysql_fetch_assoc($rq)){
		$i++;
		$beneficio="";
		$bq=mysql_query("SELECT * FROM `asignaciones` WHERE `usrId`='".$rd["userid"]."' AND `estado`='0'");
		$bs=mysql_query("SELECT * FROM `beneficio` WHERE `tipo`='1'");
		$obs=mysql_fetch_assoc(mysql_query("SELECT `observaciones` FROM `usuario` WHERE `id`='".$rd["userid"]."'"));
		for($k=0;$k<mysql_num_rows($bs);$k++){
			$bsd=mysql_fetch_assoc($bs);
			$beneficio.=" ".$bsd["titulo"]." ";
		}
		$bn=mysql_num_rows($bq);
		for ($j=0;$j<$bn;$j++){
			$bd=mysql_fetch_assoc($bq);
			$be=mysql_fetch_assoc(mysql_query("SELECT * FROM `beneficio` WHERE `id`='".$bd["benId"]."'"));
			$beneficio.="<a class='benLink' href='benPedido.php?id=".$bd["id"]."'> ".$be["titulo"]."</a>";
		}
		// mostrar estado si no llegó
		if ($rd["estado"]<2){
			$confLnk = "(<a class='benLink' href='confirmar.php?id=".$rd["id"]."'>".$secciones["res"]["c"]["estado"]["options"][$rd["estado"]]."</a>)";
		}else{
			$confLnk = "";	
		}
		echo "<tr class='estado".$rd["estado"]."'>";
		$dh=explode(" ",$rd["fechahora"]);
		echo "<td class='avatarHold'>
				<img class='avatar' src='http://restosibaris.com.ar/app/r/h_thumb.png'>
			</td><td class='nombre'>".$dh[0]." $confLnk <br>".$rd["nombre"]."<span>
				<a href='?q=res&a=edit&i=".$rd["id"]."'>Editar</a> | 
				<a class='eliminarelemeto' href='?q=res&a=eliminar&i=".$rd["id"]."'>Eliminar</a> | 
(".$rd["area"].")".$rd["telefono"]." <br /> ".$rd["preferencias"]." - ".$obs["observaciones"]."</span></td><td class='resPara'><span>PARA</span><br>".$rd["comenzales"]."</td><td class='beneficio'><span>BENEFICIO</span><br>$beneficio</td><td class='hora'><a title='".$dh[1]."' class='cuadro' href='#'><span>".$dh[1]."</span></a></td>";
		echo "</tr>";
	}
	if ($i==0) {
		echo "<tr><td>No hay entradas para mostar.</td></tr>";
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
$("a.eliminarelemeto").click(function(event){
	event.preventDefault();			 
	var txt = "Esta acci\u00F3n no se puede revertir. \u00BFContinuar?";
	var r=confirm(txt);
	if (r==true) {
		window.location.assign($(this).attr("href"));
	} 
});
</script>