
<div class="col2">
    <div class="cuadro main_wide menuSec">
    	 <? include("r/menuSec.php");
			 				
			 ?>
    </div>
    
    <div class="cuadro main_wide">
    <form id="formFilter" action="<?="?q=".$_GET["q"]."&a=list"?>" method="post">
            <select id="select" name="q" class="chosen-select">
            	<?
                foreach($secciones[$_GET["q"]]["c"] as $val){
					echo '<option value="'.$val["db"].'">'.$val["t"].'</option>';
				}
				?>
            </select>
            <input name="d" />
            <input type="submit" value="Buscar" />
    </form>
    <div id="results">
    	<?
		if ($_POST["q"]!="" && $_POST["d"]!="") {
		$q=mysql_real_escape_string($_POST["q"]);
		$d=mysql_real_escape_string($_POST["d"]);
		$condicion = "`$q` LIKE '%$d%'";
		}else{
			$condicion = "1";
		}
		$rqg=mysql_query("SELECT * FROM `".$secciones[$_GET["q"]]["db"]."` WHERE $condicion ORDER BY `id` DESC");
		$rng=mysql_num_rows($rqg);
		
		$rq=mysql_query("SELECT * FROM `".$secciones[$_GET["q"]]["db"]."` WHERE $condicion ORDER BY `id` DESC $limit");
		$rn=mysql_num_rows($rq);
		
		$txt="Mostrando <span>$rng</span> registros";
		
		if ($_POST){
			$txt.=", buscando $q: <span>$d</span>";
		}
		
		if ($_GET["p"]){
			$p=$_GET["p"];
			$a=$p*10-10;
			$b=$p*10;
			$limit="LIMIT $a,10";
			$txt.= " (P&aacute;gina $p de ".ceil($rng/10).")";
			}else{
			$limit="LIMIT 0,10";
				
		}
		
		echo "<p>$txt</p>";
		
		
		?>
    </div>
    <table class="listaWide" cellpadding="0" cellspacing="0">
    <?
	// estados 0:espera - 1:llegó - 2:cancelada app - 3:cancelada autogestion
	if ($_POST["q"]!="" && $_POST["d"]!="") {
		$q=mysql_real_escape_string($_POST["q"]);
		$d=mysql_real_escape_string($_POST["d"]);
		
		if ($secciones[$_GET["q"]]["c"][$q]["type"]=="select") {
			$d=trim(strtolower(array_search($d,$secciones[$_GET["q"]]["c"][$q]["options"])));
		} 
		
		$condicion = "`$q` LIKE '%$d%'";
		$from="`".$secciones[$_GET["q"]]["db"]."`";
		$orderby="ORDER BY `id`";
		if (isset($secciones[$_GET["q"]]["c"][$q]["get"])){
			
			$tabla1=$secciones[$secciones[$_GET["q"]]["c"][$q]["get"]]["db"];
			$tabla2=$secciones[$_GET["q"]]["db"];
			
			$from ="`".$tabla1."`, `".$tabla2."`";
			$key=key($secciones[$secciones[$_GET["q"]]["c"][$q]["get"]]["c"]);
			$condicion = "`".$tabla1."`.`id`=`".$tabla2."`.`$q` AND `$tabla1`.`".$secciones[$secciones[$_GET["q"]]["c"][$q]["get"]]["c"][$key]["db"]."` LIKE '%$d%'";
			$orderby="ORDER BY `".$tabla1."`.`id`";
		}
		
	}else{
		$condicion = "1";
		$from="`".$secciones[$_GET["q"]]["db"]."`";
		$orderby="ORDER BY `id`";
	}
	
	$rqt="SELECT * FROM $from WHERE $condicion $orderby DESC";
	$rq=mysql_query($rqt);
	if (mysql_num_rows($rq)>0){
			
		while($rd=mysql_fetch_assoc($rq)){
			echo "<tr class='estado".$rd["estado"]."'>";
			echo "<td class='avatarHold'>
					<img class='avatar' src='http://restosibaris.com.ar/app/data/uploads/".$rd["img"]."'>
				</td>
				<td class='nombre'>";
				foreach($secciones[$_GET["q"]]["c"] as $val){
					
					if ($val["type"]=="select") {$rd[$val["db"]]=$val["options"][$rd[$val["db"]]];}
					if ($val["get"]){
						debug_to_console("esta");
						$xxx=mysql_fetch_assoc(mysql_query("SELECT * FROM `".$secciones[$val["get"]]["db"]."` WHERE `id`='".$rd[$val["db"]]."'"));
						$key=key($secciones[$val["get"]]["c"]);
						$rd[$val["db"]]=$xxx[$secciones[$val["get"]]["c"][$key]["db"]];}
					
					if ($val["type"]!="password"){
						echo "<p class='ag_field_line'><span class='ag_field_list'>".$val["t"].":</span> ".
							str_replace(
								array  ("[h1]","[/h1]"),
								array  ("<strong>","</strong>"),
										$rd[$val["db"]]
							)."</p>";
					}else{
						echo "<p class='ag_field_line'><span class='ag_field_list'>".$val["t"].":</span> ***** </p>";
					}
				}
			echo "</td>
				<td class='editBtns'>
					<a href='./?q=".$_GET["q"]."&a=edit&i=".$rd["id"]."'>Editar</a>
					<a class='eliminarelemeto' href='./?q=".$_GET["q"]."&a=eliminar&i=".$rd["id"]."'>Eliminar</a>
				</td>
			</tr>";
		}
	}else{
		echo "<p>No hay ".$secciones[$_GET["q"]]["t"]." para mostrar en este momento.</p>";
	}
    ?>
    </table>
    <div id="paginas">
    <?
	if ($rng>10){
		$url=$_SERVER['REQUEST_URI'];
		$pn=ceil($rng/10);
		for ($p=1;$p<=$pn;$p++) {
			$strpos=strpos($url,"&p=");
			if ($strpos){
				$url=substr($url,0,$strpos);
			}
			echo "<a href='$url&p=$p'>$p</a>";
		}
	}
	?>
    </div>
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
$('#select').chosen();
</script>