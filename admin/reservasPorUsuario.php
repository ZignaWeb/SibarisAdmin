<? 
$rxut="
SELECT usuario. * , COUNT( * ) AS rxu
FROM reservas, usuario
WHERE estado =2
AND usuario.id = reservas.userid
AND reservas.creada >= DATE_SUB( CURDATE( ) , INTERVAL 30 
DAY ) 
GROUP BY userid
HAVING rxu >1
LIMIT 0 , 30
";
$rxuq=mysql_query($rxut);
$rxud=mysql_fetch_assoc($rxuq);
foreach($rxud as $val){
	echo'
		<p>$secciones[usu]["c"]</p>
	
	';	
}
?>