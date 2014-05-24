<? if ($embed!=1) { 
		echo "<p>Ruta de acceso incorrecta.</p>";
		exit;
	}
	?>
<a href="javascript:history.go(-1)">volver</a> 
<a href="./?q=<?=$_GET["q"]?>&a=list">Listar <?=$secciones[$_GET["q"]]["t"]?></a> 
<a href="./?q=<?=$_GET["q"]?>&a=cargar">Cargar <?=$secciones[$_GET["q"]]["t"]?></a>
<?
if ($_GET["q"]=="res"){
?>
<a href="./?q=<?=$_GET["q"]?>&a=calendario">Calendario</a>
<?
}
?>
<a href="excel.php?q=<?=$_GET["q"]?>" target="_blank">Exportar a Excel</a>