<?php
	include("../data/main.php");
    // Using the function
	if ($_GET["q"]) {
		$getq = $_GET["q"];
		$tabla = $secciones[$_GET["q"]]["db"];
		
		$tablas=array();
		
		$sql = "SELECT ";
		$from = " FROM `".$secciones[$getq]["db"]."` ";
		$where = " WHERE ";
		
		foreach($secciones[$getq]["c"] as $key => $val){
			if ($val["get"]){
				$from.=" LEFT JOIN `".$secciones[$val["get"]]["db"]."` ON `".$secciones[$val["get"]]["db"]."`.`id`=`".$secciones[$getq]["db"]."`.`".$val["db"]."` ";
				$key=reset($secciones[$val["get"]]["c"]);
				$sql .= "`".$secciones[$val["get"]]["db"]."`.`".$key["db"]."` AS `(".$secciones[$val["get"]]["t"].") ".$val["db"]."`,";
			}else{
				$sql .= "`".$secciones[$getq]["db"]."`.`".$val["db"]."` AS `(".$secciones[$getq]["t"].") ".$val["db"]."`,";
			}
		}
		if (!$val["get"]){
			$where .="1 AND ";
		}
		$sql=substr($sql,0,-1);
		$where=substr($where,0,-5);
	
		$sql .= $from.$where;
		
		query_to_csv($dbh, $sql, $tabla."_".$hoy.".csv", true);
	}else{
		echo "No se pudo generar el archivo de Excel.";
	}
?>