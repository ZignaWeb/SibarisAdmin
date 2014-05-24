<?
include("main.php");

$qt="SELECT * 
FROM  `sugerencia` 
WHERE  `inicio` <=  '$hoy'
AND  `fin` >  '$hoy'
AND  `estado` =  '0'
ORDER BY  `fecha` DESC 
LIMIT 10";
$q=mysql_query($qt);
$qn=mysql_num_rows($q);

if ($qn>0){
	for($i=0;$i<$qn;$i++) {
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
			
	}
}else{
		echo "<div class='itm'>No hay sugerencias en este momento.</div><img src='r/sombraPost.png' class='thumb shadow' />";
	}

?>