<?
include("../data/main.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sibaris Admin</title>
<link href="r/main.css" rel="stylesheet" type="text/css" />
<link href="r/form.css" rel="stylesheet" type="text/css" />
<link href="../r/jQui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="r/funciones.js"></script>
<script type="text/javascript" src="r/jq.js"></script>
<script type="text/javascript" src="r/form.js"></script>
<script type="text/javascript" src="../r/jQui.js"></script>
<script type="text/javascript" src="r/timepicker.js"></script>
</head>

<body>
	<div id="header">
    	<a href="./"><img id="logo" src="r/logo.png" align="sibaris" />
        <h1>Administración</h1></a>
    </div>
	<?
	if(isset($_SESSION[myusername]) && isset($_SESSION[mypermisos])){
		$embed=1;
		include ("menu.php");
		if ($_GET["a"] && $_GET["q"]) {
			if ($secciones[$_GET["q"]]["p"]<=$_SESSION["mypermisos"]) {
				include(htmlentities($_GET["a"]).'.php');
			}else{
				$embed=0;
				echo "<div class='cuadro'>Las credenciales de la cuenta con la que inició esta sessión (".ucfirst($_SESSION["myusername"]).") no le permiten completar esta acción.</div>";
			}
		}else{
			include("res.php");
		}
	}else{
		include ('login.php');
	}
	?>
<script type="text/javascript">
$(document).ready(function(){
	$("a.eliminarelemeto").click(function(event){
		event.preventDefault();
		if (confirm('Esta acción no se puede revertir. ¿Quiere continuar?')) {
			window.location.href = $(this).attr("href");
		}
	});
});
</script>
</body>
</html>