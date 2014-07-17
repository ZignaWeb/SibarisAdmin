<div class="col2">
    <div class="cuadro main_wide menuSec">
        <? include("r/menuSec.php");?>
    </div>
    
    <div class="cuadro main_wide">
    <?
	if (!$_POST) {
	?>
    	<form id="adminForm" action="?q=<?=$_GET["q"]?>&a=edit&i=<?=$_GET["i"]?>" method="post" enctype="multipart/form-data">
        	<?
			$d=mysql_fetch_assoc(mysql_query("SELECT * FROM `".$secciones[$_GET["q"]]["db"]."` WHERE `id`='".$_GET["i"]."'"));
			foreach ($secciones[$_GET["q"]]["c"] as $val) {
				if ($val["val"]=="date") {
					$palceholder=$val["t"]." YYYY-MM-DD";
				}else{
					$palceholder=$val["t"];
				}
				if ($val["force"]==1) {$clase=" force";$char="<span class='asterisco'>*</span>";}else{$clase=""; $char="";}
				$valor=$d[$val["db"]];
				echo "<p>$palceholder $char</p>";
				if ($val["type"]=="input"){
					echo "<input class='".$val["val"]." $clase' placeholder='".$palceholder."' name='".$val["db"]."' value='$valor'/>";
				}if ($val["type"]=="password"){
					echo "<input class='".$val["val"]." $clase' type='password' placeholder='".$palceholder."' name='".$val["db"]."' value='$valor'/>";
				}elseif ($val["type"]=="textarea"){
					echo "<div class='rtfbox' id='".$val["db"]."'>
						<ol class='rtf'>
							<li><a href='#' class='rtfBtn' rel='h1'>Titulo</a></li>
							<li><a href='#' class='rtfBtn' rel='clear'>Borrar tags</a></li>
						</ol>
						<textarea class='$clase' rows='5' placeholder='".$palceholder."' name='".$val["db"]."'>$valor</textarea>
						<script type='text/javascript'>richTextualize('#".$val["db"]."');</script>
					</div>";
				}elseif ($val["type"]=="img"){
					echo "<img class='avatar $clase' src='http://restosibaris.com.ar/app/data/uploads/portrait/$valor'><input placeholder='".$palceholder."' name='".$val["db"]."' type='file' />";
				}elseif($val["type"]=="select"){
					echo "<div class='optGroup $clase'>";
					foreach($val["options"] as $key => $text){
						if ($valor == $key){ $check = "checked";}else{$check="";}
						echo "<label>$text <input type='radio' name='".$val["db"]."' value='$key' $check></label>";
					}
					echo "</div>";
				}elseif($val["type"]=="drop"){
					$tabla=$secciones[$val["get"]]["db"];
					$key=key($secciones[$val["get"]]["c"]);
					$field=$secciones[$val["get"]]["c"][$key]["db"];
					echo "<select class='$clase' name='".$val["db"]."'><option value=' '>Sin definir</option>";
					$gq=mysql_query("SELECT * FROM `$tabla` WHERE 1 ORDER BY `$field` ASC");
					while ($gd=mysql_fetch_assoc($gq)){
						if ($valor == $gd["id"]){ $check = "selected='selected'";}else{$check="";}
						echo "<option value='".$gd["id"]."' $check>".$gd[$field]."</option>";
					}
					echo "</select>";
				}
			}
			?>
            <input type="submit" />
        </form>
    <?
	}else{
		$q="UPDATE `".$secciones[$_GET["q"]]["db"]."` SET ";
		$e="";
		$i=0;
		$imgs=array();
		foreach ($secciones[$_GET["q"]]["c"] as $val) {
			$i++;
			$postv = $_POST[$val["db"]];
			if ($postv!="" && $val["val"]!="file") {
				if ($i>1){$q.=",";}
				$q.=" `".$val["db"]."`='".$postv."'";
			}elseif($val["val"]=="file"){
				array_push($imgs,$val["db"]);
			}elseif($postv=="" && $val["force"]==1){
				$e.=" <p>El campo <strong>".$val["t"]."</strong> es obligatorio</p>";
			}
			
		}
		$q.=" WHERE `id`='".$_GET["i"]."'";
		if ($e!=""){
			echo $e;
		}else{
			if (mysql_query($q)){
				echo "Elemento editado :".ucfirst($secciones[$_GET["q"]]["t"]);
			}else{
				echo ucfirst(" Error. No se pudo editar: ".$secciones[$_GET["q"]]["t"])." $q";
			}
			foreach($imgs as $val){
				$tabla=$secciones[$_GET["q"]]["db"];
				subirImg ($val,$img_dir,$tabla,$_GET["i"]);
			}
		}
		?>
        <script type="text/javascript">
			setTimeout(function(){history.go(-2)},1000);
		</script>
        <?
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
	$(document).ready(function(){
		$( ".date" ).datetimepicker({ dateFormat: "yy-mm-dd" });
	});
</script>