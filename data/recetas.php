<?
include("main.php");
$q=mysql_query("SELECT * FROM `receta` WHERE 1 ORDER BY `id` DESC");
$n=mysql_num_rows($q);
for ($i=0;$i<$n;$i++){
	$ud=mysql_fetch_assoc($q);
	foreach($ud as $key => $val){
		$ud[$key]=htmlentities(utf8_decode($val));
	}
	echo '<div class="itm">
            <a href="receta.html?ide='.$ud["id"].'"><img src="http://restosibaris.com.ar/app/data/uploads/portrait/'.$ud["img"].'" class="thumb" /></a>
            <h2><a href="receta.html?ide='.$ud["id"].'">'.$ud["titulo"].'</a></h2>
		</div>
        <img src="r/sombraPost.png" class="thumb shadow" />';
}

?>