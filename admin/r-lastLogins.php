<div class="col1">
	<div class="cuadro main_wide"><h2><img src="r/modosibarisheader.png"></h2></div>
    <div class="cuadro main_wide">
    <table class="listaWide" cellpadding="0" cellspacing="0">
    <?
	$start=date("Y-m-d H:i:s");
	// estados 0:espera - 1:llegó - 2:cancelada app - 3:cancelada autogestion
	$rq=mysql_query("SELECT * FROM `usuario` WHERE 1 ORDER BY  `lastlogin` DESC LIMIT 20");
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