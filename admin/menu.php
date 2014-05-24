<ol id="menu">
    <?
	foreach($secciones as $key => $val){
		if ($val["p"]<=$_SESSION["mypermisos"]) {
			echo "<li><a href='./?q=$key&a=list'>".$val["t"]."</a></li>";
		}
	}
	if ($_SESSION["mypermisos"]>0){
		echo '<li><a href="estadisticas.php">Estad&iacute;sticas</a></li>';
	}
	?>
    
    <li><a href="logout.php">Salir</a></li>
</ol>