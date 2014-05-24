<?
$que=mysql_real_escape_string($_GET["que"]);
$ide=mysql_real_escape_string($_GET["id"]);

	if ($que=="usuario"){
		$un = mysql_num_rows(mysql_query("SELECT `id` FROM `usuario`"));
		if ($un>1){
			if (borrar($que, $ide)){
				echo "Usuario borrado.";
			}else{
				echo "El usuario no pudo ser borrado.";
			}
		}else{
			echo '<p>Este es el unico usuario registrado, no lo puedes borrar</p>';
		}
	}elseif (borrar($que,$ide)){
		echo '<p>¡Eliminado: '.ucfirst($que).'!</p>';
	}else{
		echo '<p>Error al eliminar el '.$que.', inténtelo de nuevo.</p>';
	}
	
	function borrar($table, $idregistro){
		if (mysql_query("DELETE FROM `".$table."` WHERE `id`='".$idregistro."'")){
			return true;
		}else{
			return false;
		}
	}
?>