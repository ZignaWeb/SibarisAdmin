<?
include("main.php");
$ide=addslashes($_GET["ide"]);
$q=mysql_query("SELECT * FROM `receta` WHERE `id`='$ide'");
$ud=mysql_fetch_assoc($q);
foreach($ud as $key => $val){
	$ud[$key]=htmlentities(utf8_decode($val));
}
echo '<div class="itm">
		<img src="http://restosibaris.com.ar/app/data/uploads/portrait/'.$ud["img"].'" class="thumb" />
		<h2>'.$ud["titulo"].'</h2>';
echo nl2br(str_replace(
					   array("[h1]","[/h1]"),
					   array("<h2>","</h2>"),
					   $ud["descripcion"]));	
echo '</div>
	<img src="r/sombraPost.png" class="thumb shadow" />';

?>