<?
include("main.php");
$caracteres=array("Ã¡","Ã©","Ã*","Ã³","Ãº","Ã","Ã‰","Ã","Ã“","Ãš","Ã±","Ã‘","Âº","Âª","Â¿");
$acentos=array("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","Ñ","º","ª","¿");

$ide=addslashes($_GET["ide"]);
$q=mysql_query("SELECT * FROM `receta` WHERE `id`='$ide'");
$ud=mysql_fetch_assoc($q);
foreach($ud as $key => $val){
	$ud[$key]=$val;
}
$descripcion=str_replace($caracteres,$acentos,$ud["descripcion"]);
echo '<div class="itm">
		<img src="http://restosibaris.com.ar/app/data/uploads/portrait/'.$ud["img"].'" class="thumb" />
		<h2>'.$ud["titulo"].'</h2>';
echo nl2br(str_replace(
					   array("[h1]","[/h1]"),
					   array("<h2>","</h2>"),
					   $descripcion));	
echo '</div>
	<img src="r/sombraPost.png" class="thumb shadow" />';

?>