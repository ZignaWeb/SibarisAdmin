<div class="col2">
    <div class="cuadro main_wide menuSec">
        <? include("r/menuSec.php");?>
    </div>
    
    <div class="cuadro main_wide">
    <?
	if (!$_POST) {
	?>
    	<form id="adminForm" action="?q=<?=$_GET["q"]?>&a=cargar" method="post" enctype="multipart/form-data">
        	<?
			foreach ($secciones[$_GET["q"]]["c"] as $val) {
				if ($val["val"]=="date") {
					$palceholder=$val["t"]." YYYY-MM-DD";
				}else{
					$palceholder=$val["t"];
				}
				
				if (isset($val["autofill"])) {
					$valor=$val["autofill"];
					}else{
					$valor="";
				}
				if ($val["force"]==1) {$clase=" force";$char="<span class='asterisco'>*</span>";}else{$clase=""; $char="";}
				echo "<p>$palceholder $char</p>";
				if ($val["type"]=="input"){
					echo "<input class='".$val["val"]."$clase' placeholder='".$palceholder."' name='".$val["db"]."' value='$valor'/>";
				}if ($val["type"]=="password"){
					echo "<input class='".$val["val"]."$clase' type='password' placeholder='".$palceholder."' name='".$val["db"]."' value='$valor'/>";
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
					echo "<input class='$clase' placeholder='".$palceholder."' name='".$val["db"]."' type='file' />";
				}elseif($val["type"]=="select"){
					echo "<div class='optGroup $clase'>";
					$i=0;
					foreach($val["options"] as $key => $text){
						if ($i==0) { $selected="checked='checked'";}else{$selected="";}
						echo "<label>$text <input type='radio' $selected name='".$val["db"]."' value='$key'></label>";
						$i++;
					}
					echo "</div>";
				}elseif($val["type"]=="drop"){
					$tabla=$secciones[$val["get"]]["db"];
					$key=key($secciones[$val["get"]]["c"]);
					$field=$secciones[$val["get"]]["c"][$key]["db"];
					echo "<select class='$clase' name='".$val["db"]."'><option value=' '>Sin definir</option>";
					$gq=mysql_query("SELECT * FROM `$tabla` WHERE 1 ORDER BY `$field` ASC");
					while ($gd=mysql_fetch_assoc($gq)){
						echo "<option value='".$gd["id"]."'>".$gd[$field]."</option>";
					}
					echo "</select>";
				}
			}
			?>
            <input type="submit" />
        </form>
    <?
	}else{
		$q="INSERT INTO `".$secciones[$_GET["q"]]["db"]."` SET ";
		$e="";
		$i=0;
		$imgs=array();
		foreach ($secciones[$_GET["q"]]["c"] as $val) {
			$i++;
			if ($val["val"]!="date") {
				$postv = $_POST[$val["db"]];
			}else{
				$postv = date('Y-n-j H:i:s', strtotime(str_replace('-', '/', $_POST[$val["db"]])));
			}
			
			if ($postv!="" && $val["val"]!="file") {
				if ($i>1){$q.=",";}
			/*$lacento=array("<",">","&","¡","¿","®","©","€","á","é","í","ó","ú","ñ","ü","Á","É","Í","Ó","Ú","Ñ","Ü");
			$cespeciales=array("&lt","&gt","&amp","&iexcl","&iquest","&reg","&copy","&euro","&aacute","&eacute","&iacute","&oacute","&uacute","&ntilde","&uuml","&Aacute","&Eacute","&Iacute","&Oacute","&Uacute","&Ntilde","&Uuml");
			$clean=str_replace($lacento,$cespeciales,$postv);*/
				$q.=" `".$val["db"]."`='".$postv."'";//8
			}elseif($val["val"]=="file"){
				array_push($imgs,$val["db"]);
			}elseif($postv=="" && $val["force"]==1){
				$e.=" <p>El campo <strong>".$val["t"]."</strong> es obligatorio</p>";
			}
			
		}
		if ($e!=""){
			echo $e;
		}else{
			if (mysql_query($q)){
				$lastid=mysql_insert_id();
				echo "Elemento cargado a :".ucfirst($secciones[$_GET["q"]]["t"]);
			}else{
				echo ucfirst(" Error. No se pudo cargar: ".$secciones[$_GET["q"]]["c"]);
			}
			foreach($imgs as $val){
				$tabla=$secciones[$_GET["q"]]["db"];
				subirImg ($val,$img_dir,$tabla,$lastid);
			}
		}
		?>
        <script type="text/javascript">
			setTimeout(function(){history.go(-1)},1000);
		</script>
        <?
	}
	?>
    </div>
    
</div>

<? include("r-lastLogins.php");?>
<script type="text/javascript">
	$('select').chosen();
	$(document).ready(function(){
		$( ".date" ).datetimepicker({ dateFormat: "yy-mm-dd" });
	});
</script>