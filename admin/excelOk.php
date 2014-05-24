<?php
	include("../data/main.php");
    // Using the function
	if ($_GET["q"]) {
		$getq = $_GET["q"];
		$tabla = $secciones[$_GET["q"]]["db"];
		
		/*
		SELECT 
		  `beneficio`.`titulo` AS `(beneficios) benId`
		  ,`usuario`.`nombre` AS `(usuarios) usrId`
		  ,`asignaciones`.`fecha` AS `(Premios asignados) fecha`
		  ,`asignaciones`.`estado` AS `(Premios asignados) estado`
		  ,`asignaciones`.`visto` AS `(Premios asignados) visto` 
		FROM 
		  `asignaciones`
		LEFT JOIN 
		  `beneficio`
		ON
		  `beneficio`.`id`=`asignaciones`.`benId` 
		LEFT JOIN  
		  `usuario` 
		ON 
		   `usuario`.`id`=`asignaciones`.`usrId`
		WHERE 1 
		*/
		
		$tablas=array();
		
		$sql = "SELECT ";
		$where = " WHERE ";
		foreach($secciones[$getq]["c"] as $key => $val){
			if ($val["get"]){
				$tablas[$val["get"]]=$secciones[$val["get"]]["db"];
				$key=reset($secciones[$val["get"]]["c"]);
				$sql .= "`".$tablas[$val["get"]]."`.`".$key["db"]."` AS `(".$secciones[$val["get"]]["t"].") ".$val["db"]."`,";
				$where .= "`".$secciones[$val["get"]]["db"]."`.`id`=`".$secciones[$getq]["db"]."`.`".$val["db"]."` AND ";
			}else{
				$sql .= "`".$secciones[$getq]["db"]."`.`".$val["db"]."` AS `(".$secciones[$getq]["t"].") ".$val["db"]."`,";
			}
		}
		if (!$val["get"]){
			$where .="1 AND ";
		}
		$sql=substr($sql,0,-1);
		$where=substr($where,0,-5);
		
		// FROM
		$sql .= " FROM `".$secciones[$getq]["db"]."`,";
		foreach($tablas as $val){
			$sql .="`$val`,";
		}
		$sql=substr($sql,0,-1);
		$sql .= $where;
		query_to_csv($dbh, $sql, $tabla."_".$hoy.".csv", true);
	}else{
		echo "No se pudo generar el archivo de Excel.";
	}
?>