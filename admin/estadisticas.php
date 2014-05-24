<?
include("../data/main.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sibaris Admin</title>
<link href="r/main.css" rel="stylesheet" type="text/css" />
<link href="../r/jQui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="r/funciones.js"></script>
<script type="text/javascript" src="r/jq.js"></script>
<script type="text/javascript" src="../r/jQui.js"></script>
<script type="text/javascript" src="r/timepicker.js"></script>
</head>

<body>
	<div id="header">
    	<a href="./"><img id="logo" src="r/logo.png" align="sibaris" /></a>
        <h1>Estadísticas</h1>
    </div>
	<?
	if(session_is_registered(myusername) && session_is_registered(mypermisos)){
		include ("menu.php");

		// numero de usuarios
		$un = mysql_num_rows(mysql_query("SELECT * FROM `usuario` WHERE 1"));
		
		$hmn = array(
			h => array (n => mysql_num_rows(mysql_query("SELECT * FROM `usuario` WHERE `sexo`='h'")),t=>"Hombres",s=>"H"),
			m => array (n => mysql_num_rows(mysql_query("SELECT * FROM `usuario` WHERE `sexo`='f'")),t=>"Mujeres",s=>"M"),
			x => array (n => mysql_num_rows(mysql_query("SELECT * FROM `usuario` WHERE `sexo`=''")),t=>"?",s=>"?"),
		);
		
		// -20
		$en = array(
			u20 => array (n=>mysql_num_rows(mysql_query("SELECT * FROM `usuario` WHERE `cumple`>'".date("Y-n-j",strtotime("$hoy -20 Years"))."'")),t=>"Menores de 20",s=>"-20"),
			u2035 => array (n=>mysql_num_rows(mysql_query("SELECT * FROM `usuario` WHERE `cumple`<='".date("Y-n-j",strtotime("$hoy -20 Years"))."' && `cumple`>'".date("Y-n-j",strtotime("$hoy -35 Years"))."'")),t=>"Entre 20 y 35",s=>"20-35"),
			u3550 => array (n=>mysql_num_rows(mysql_query("SELECT * FROM `usuario` WHERE `cumple`<='".date("Y-n-j",strtotime("$hoy -35 Years"))."' && `cumple`>'".date("Y-n-j",strtotime("$hoy -50 Years"))."'")),t=>"Entre 35 y 50",s=>"35-50"),
			o50 => array (n=>mysql_num_rows(mysql_query("SELECT * FROM `usuario` WHERE `cumple`<='".date("Y-n-j",strtotime("$hoy -50 Years"))."'")),t=>"Mayores de 50",s=>"+50")
		);
		// reservas totales
		$rn =  mysql_num_rows(mysql_query("SELECT * FROM `reservas` WHERE 1"));
		// reservas totales confirmadas
		$rnc =  mysql_num_rows(mysql_query("SELECT * FROM `reservas` WHERE `estado`=2"));
		// reservas ultimas 24 hrs
		$ayer= date("Y-n-j H:i:s",strtotime("$ahora -24 Hours"));
		$rnh =  mysql_num_rows(mysql_query("SELECT * FROM `reservas` WHERE `fechahora`> '$ayer' AND `fechahora`<='$ahora'"));
		// reservas ultimas 7 dias
		$ayer= date("Y-n-j H:i:s",strtotime("$ahora -7 Days"));
		$rns =  mysql_num_rows(mysql_query("SELECT * FROM `reservas` WHERE `fechahora`> '$ayer' AND `fechahora`<='$ahora'"));
		// reservas ultimas 30 dias
		$ayer= date("Y-n-j H:i:s",strtotime("$ahora -30 Days"));
		$rnm =  mysql_num_rows(mysql_query("SELECT * FROM `reservas` WHERE `fechahora`> '$ayer' AND `fechahora`<='$ahora'"));
		// reservas por día
		$dn = array (
			Lun => array (n=>mysql_num_rows(mysql_query("SELECT * FROM `reservas` WHERE DAYOFWEEK(`fechahora`) = 2")),t=>"Lun",s=>"Lu"),
			Mar => array (n=>mysql_num_rows(mysql_query("SELECT * FROM `reservas` WHERE DAYOFWEEK(`fechahora`) = 3")),t=>"Mar",s=>"Ma"),
			Mie => array (n=>mysql_num_rows(mysql_query("SELECT * FROM `reservas` WHERE DAYOFWEEK(`fechahora`) = 4")),t=>"Mie",s=>"Mi"),
			Jue => array (n=>mysql_num_rows(mysql_query("SELECT * FROM `reservas` WHERE DAYOFWEEK(`fechahora`) = 5")),t=>"Jue",s=>"Ju"),
			Vie => array (n=>mysql_num_rows(mysql_query("SELECT * FROM `reservas` WHERE DAYOFWEEK(`fechahora`) = 6")),t=>"Vie",s=>"Vi"),
			Sab => array (n=>mysql_num_rows(mysql_query("SELECT * FROM `reservas` WHERE DAYOFWEEK(`fechahora`) = 7")),t=>"Sab",s=>"Sa"),
			Dom => array (n=>mysql_num_rows(mysql_query("SELECT * FROM `reservas` WHERE DAYOFWEEK(`fechahora`) = 1")),t=>"Dom",s=>"Do")
		);
		// almuerzos 11 - 18 & 
		$acn = array(
			a => array(n=>mysql_num_rows(mysql_query("SELECT * FROM `reservas` WHERE TIME (`fechahora`) BETWEEN '06:00:01' AND '17:00:00'")),t=>"Almuerzo",s=>"Almuerzo"),
			c => array(n=>mysql_num_rows(mysql_query("SELECT * FROM `reservas` WHERE TIME (`fechahora`) >= '17:00:01' OR TIME (`fechahora`) <= '06:00:00'")),t=>"Cena",s=>"Cena")
		);
		// usuarios activos ultimas 24hs
		$ayer= date("Y-n-j H:i:s",strtotime("$ahora -24 Hours"));
		$uahoy =  mysql_num_rows(mysql_query("SELECT * FROM `usuario` WHERE `lastlogin`> '$ayer' AND `lastlogin`<='$ahora'"));
		// usuarios activos ultimos 30 dias
		$ayer= date("Y-n-j H:i:s",strtotime("$ahora -30 Days"));
		$uames =  mysql_num_rows(mysql_query("SELECT * FROM `usuario` WHERE `lastlogin`> '$ayer' AND `lastlogin`<='$ahora'"));
		// premios asignados
		$pran =  mysql_num_rows(mysql_query("SELECT * FROM `asignaciones` WHERE 1"));
		// premios entregados
		$pren =  mysql_num_rows(mysql_query("SELECT * FROM `asignaciones` WHERE `estado`='1'"));
		
		
	?>
    <div id="estadisticas" class="cuadro">
    	<h1>Estadísticas</h1>
        <div class="wrap">
            <div class="col">
                <h2>Tipo de reserva</h2>
                <? printbars($acn); ?>
                <h2>Número de reservas</h2>
                <p><span>Reservas totales: </span><?=$rn?></p>
                <p><span>Reservas totales Confirmadas: </span><?=$rnc?></p>
                <p><span>En las últimas 24hrs: </span><?=$rnh?></p>
                <p><span>En los últimos 7 días: </span><?=$rns?></p>
                <p><span>En los últimos 30 días: </span><?=$rnm?></p>
                <h2>Día de reserva</h2>
                <? printbars($dn); ?>
                <h2>Premios</h2>
                <? $A=round($pren*100/$pran);?>
                <div class="bar"><span class="bar1" style="width:<?=$A?>%; background:#FF9923" title="<?=$A?>%"><?=$A?></span></div>
                <p><span>Asignados: </span><?=$pran?></p>
                <p><span>Entregados: </span><?=$pren?></p>
            </div>
            <div class="col">
            	<h2>Usuarios</h2>
            	<p><span>Número de usuarios registrados:</span> <?=$un?></p>
                <h2>Usuarios activos</h2>
                <p><span>Usuarios activos en las últimas 24hrs:</span> <?=$uahoy?></p>
                <? $A=round($uahoy*100/$un);?>
                <div class="bar"><span class="bar1" style="width:<?=$A?>%; background:#FF9923" title="<?=$A?>%"></span></div>
                <p><span>Usuarios activos en los últimos 30 días:</span> <?=$uames?></p>
                <? $A=round($uames*100/$un);?>
                <div class="bar"><span class="bar1" style="width:<?=$A?>%; background:#FF9923" title="<?=$A?>%"></span></div>
                <h2>Edad</h2>
                <? printbars($en); ?>
                <h2>Sexo</h2>
                <? printbars($hmn);?>
                <h2>Reservas por Usuario</h2>
                <div class="content">
                	
                <? 
					$rxut="
					SELECT usuario.`nombre`, usuario.`email`, usuario.`area`, usuario.`telefono`,usuario.`cumple`,usuario.`lastlogin` ,COUNT( * ) AS rxu
					FROM reservas, usuario
					WHERE estado =2
					AND usuario.id = reservas.userid
					AND reservas.creada >= DATE_SUB( CURDATE( ) , INTERVAL 30 
					DAY ) 
					GROUP BY userid
					HAVING rxu >=1
					ORDER BY rxu DESC
					";
					$rxuq=mysql_query($rxut);
					
					while($val=mysql_fetch_assoc($rxuq)){
					$c=	date("Y-n-j",strtotime($val["cumple"]));
					$ll=date("Y-n-j H:i:s",strtotime($val["lastlogin"]));
						echo'
						
						<div class="rxu">
							<div>
								<p>Nombre: '.$val["nombre"].'</p>
								<p>Email: '.$val["email"].'</p>
								<p>Tel.: ('.$val["area"].') '.$val["telefono"].'</p>
								<p>Cumpleaños: '.$c.'</p>
								<p>Ultimo login: '.$ll.'</p>
							</div>
							<div>
								<div class="circle">
									<div class="circle-text">
										<div>'.$val["rxu"].'</div>
									</div>
								</div>
							</div>
						</div>
						
						';
					}
					?>
					                </div>
					                
					            </div>
					        </div>
					    </div>
    <?
	}else{
		include ('login.php');
	}
	?>
</body>
</html>