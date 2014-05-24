<?
session_start();
// DB
$db_server="localhost";
$db_name="restosib_app";
$db_usr="restosib_applock";
$db_psw="agguz3yfdq";

$dbh = mysql_connect ($db_server, $db_usr, $db_psw) or die ('I cannot connect to the database because: ' . mysql_error()); mysql_select_db ($db_name);

// emails
$email_reservas="restosibaris@windsortower.com";

// timezone
date_default_timezone_set('America/Argentina/Buenos_Aires');
$hoy = date("Y-n-j");
$ahora = date("Y-n-j H:i:s");
$semIni= date("Y-n-j",strtotime("$hoy next Monday"));
$semFin= date("Y-n-j",strtotime( "$semIni +2 week" ));
// beneficio inicio y fin
$benIni= date("Y-n-j",strtotime("$hoy previous Monday"));
$benFin= date("Y-n-j",strtotime("$benIni +1 Year" ));
//errores
$error["usrpsw"]="Nombre de usuario o contrase&ntilde;a incorrectos.";
// directiorios
$img_dir="../data/uploads";
// colores estadisticas
$co = array("#FFCC5E","#9CC","#99C","#6C9","#FF9923","#CC6","#FFE1C3","#F99","#39C");

// permisos
$secciones=array(
	res => array (
		p => 0,
		t => "reservas",
		db=> "reservas",
		c => array(
			userid => array ( db => "userid", t => "usuario", type => "drop", get => "usu"),
			nombre => array ( db => "nombre", t => "nombre", type => "input", val => "text", force => "1"),
			area => array ( db => "area", t => "codigo de area", type => "input", val => "number", force => "1"),
			telefono => array ( db => "telefono", t => "telefono", type => "input", val => "number", force => "1"),
			comenzales => array ( db => "comenzales", t => "numero de comenzales",type => "input", val => "number", force => "1"),
			fechahora => array ( db => "fechahora", t => "fecha y hora", type => "input", val => "date", force => "1"),
			preferencias => array ( db => "preferencias",t => "preferencias", type => "textarea", val => "text"),
			creada => array ( db => "creada", t => "fecha de creacion", type => "input", val => "date", autofill=>$ahora),
			estado => array ( db => "estado", t => "estado", type => "select", force => "1", 
							  options => array (1 => "Confirmada", 0 => "Sin confirmar", 2 => "Llegó")
							)
		)
	),
	awa => array (
		p => 0,
		t => "Premios asignados",
		db=> "asignaciones",
		c => array(
			benId => array ( db => "benId", t => "Beneficio", type => "drop", get => "ben", force => "1"),
			usrId => array ( db => "usrId", t => "Usuario", type => "drop", get => "usu", force => "1"),
			fecha => array ( db => "fecha", t => "Fecha", type => "input", val => "date", autofill=>$ahora),
			estado => array( db => "estado", t => "Estado", type => "select", options => array(0=>"Pendiente", 1=>"Entregado"), force => "1"),
			visto => array ( db => "visto", t => "Visto por el usuario", type => "select", options => array(0=>"No", 1=>"Si"))
		)
	),
	ben => array (
		p => 0,
		t => "beneficios",
		db=> "beneficio",
		c => array (
			titulo => array ( db => "titulo", t => "titulo", type => "input", val => "text", force => "1"),
			tipo => array ( db => "tipo", t => "tipo", type => "select", val => "number", force => "1", 
							options => array( 0 => "Para todo nuevo usuario (no se asigna)", 1 => "Para todos (no se asigna)", 2 => "Exclusivo a un usuario a designar")),
			desde => array ( db => "desde", t => "Desde", type => "input", val => "date", autofill=>$benIni),
			hasta => array ( db => "hasta", t => "Hasta", type => "input", val => "date", autofill=>$benFin)
		)
	),
	rec => array (
		s => array("editar", "crear", "excel"),
		t => "recetas",
		db=> "receta",
		c => array (
			titulo => array ( db => "titulo", t => "titulo", type => "input", val => "text", force => "1"),
			img => array ( db => "img", t => "img", type => "img", val => "file", force => "1"),
			descripcion => array ( db => "descripcion",t => "descripcion", type => "textarea", val => "text", force => "1"),
			fecha => array ( db => "fecha", t => "fecha", type => "input", val => "date", autofill=>$hoy)
		)
	),
	sug => array (
		p => 1,
		t => "sugerencias",
		db => "sugerencia",
		c => array (
			titulo => array ( db => "titulo", t => "titulo", type => "input", val => "text", force => "1"),
			img => array ( db => "img", t => "foto", type => "img", val => "file", force => "1"),
			descripcion => array ( db => "descripcion",t => "descripcion", type => "textarea", val => "text", force => "1"),
			inicio => array ( db => "inicio", t => "mostrar a partir de", type => "input", val => "date", autofill=>$semIni, force => "1"),
			fin => array ( db => "fin", t => "hasta", type => "input", val => "date", autofill=>$semFin, force => "1"),
			estado => array ( db => "estado", t => "Mostar en la applicación", type => "select", 	options => array(0=>"Si", 1=>"No"), force => "1"),
			fecha => array ( db => "fecha", t => "Fecha de creacion", type => "input", val => "date", autofill=>$hoy)
		)
	),
	usu => array (
		p => 1,
		t => "usuarios",
		db => "usuario",
		c => array (
			nombre => array ( db => "nombre", t => "nombre", type => "input", val => "text", force => "1"),
			ubicacion => array ( db => "ubicacion", t => "ubicacion", type => "input", val => "text"),
			img => array ( db => "img", t => "Imagen de perfil", type => "img", val => "file"),
			email => array ( db => "email", t => "email", type => "input", val => "email", force => "1"),
			password => array ( db => "password", t => "password", type => "password", val => "text", force => "1"),
			area => array ( db => "area", t => "codigo de area", type => "input", val => "number"),
			telefono => array ( db => "telefono", t => "telefono", type => "input", val => "number"),
			cumple => array ( db => "cumple", t => "fecha de nacimiento", type => "input", val => "date"),
			sexo => array ( db => "sexo", t => "sexo", type => "select", val => "text", options => array (h => "hombre", f => "mujer")),
			signupdate => array ( db => "signupdate", t => "Fecha de registro", type => "input", val => "date", autofill=>$hoy),
			observaciones => array ( db => "observaciones",t => "observaciones", type => "textarea", val => "text")
		)
	),
	adm => array (
		p => 2,
		t => "Admins",
		db => "admins",
		// 	usr	psw	email	level
		c => array (
			array ( db => "usr", t => "usuario", type => "input", val => "text", force => "1"),
			array ( db => "psw", t => "password", type => "input", val => "text", force => "1"),
			array ( db => "email", t => "email", type => "input", val => "email"),
			array ( db => "level", t => "nivel", type => "select", force => "1", 	
					options => array (0 => "Solo reservas", 1 => "Reservas y contenido", 2 => "Acceso total")
				  )
		)
	)
	
);

function printbars($var){
	echo "<div class='bar'>";
	$c=0;
	global $co;
	shuffle($co);
	$varn=count($var);
	$porSum=0;
	$an=0;
	foreach ($var as $val ) {
		$an=$an+$val["n"];
	}
	$i=0;
	foreach ($var as $key => $val){
		$i++;
		if ($i==$varn) {
			$por=100-$porSum;
		}else{
			$por=floor($val["n"]*100/$an);
			$porSum=$porSum+$por;
		}
		if ($por!=0){
			echo "<span style='width:".$por."%; background:".$co[$c]."' title='".$por."%'>".$val["s"]."</span>";
			$c++;
		}
	}
	echo "</div><p>";
	foreach ($var as $key => $val){
		echo "<span>".$val["t"].":</span> ".$val["n"]." ";
	}
	echo "<p>";
}

function subirImg ($name_media_field,$destination_dir,$tabla,$relid) {
	$tmp_name = $_FILES[$name_media_field]['tmp_name'];
	if ( is_dir($destination_dir) && is_uploaded_file($tmp_name))
	{
		$img_type  = $_FILES[$name_media_field]['type'];
		$img_file  = $name_media_field.time().'.'.str_replace("image/","",$img_type);
		if ( strpos($img_type, "jpeg") || strpos($img_type,"jpg") || strpos($img_type,"gif") || strpos($img_type,"png") ){
			if(move_uploaded_file($tmp_name, $destination_dir.'/'.$img_file)){
				
				$imageDim=getimagesize($destination_dir.'/'.$img_file);
				$imageRel=$imageDim[0]/$imageDim[1];
				$maxH=600;
				$maxW=900;
				$maxSizes=array(
					// h => 0 altura variable
					portrait => array ( 
						w => 500,
						h => "auto"
						)
				);
				if (mysql_query("UPDATE `$tabla` SET `$name_media_field` ='$img_file' WHERE `id`='$relid'")){
					
					foreach ($maxSizes as $key => $val) {
						
						if ($val["w"]!="auto" && $val["h"]!="auto") {
							$newImgRel=$val["w"]/$val["h"];
							$image_p = imagecreatetruecolor($val["w"], $val["h"]);
							if ( strpos($img_type, "jpeg") || strpos($img_type,"jpg")){
								$image = imagecreatefromjpeg($destination_dir.'/'.$img_file);
							}elseif ( strpos($img_type, "gif")){
								$image = imagecreatefromgif($destination_dir.'/'.$img_file);
							}elseif ( strpos($img_type, "png")){
								imagesavealpha($image_p, true); 
								$color = imagecolorallocatealpha($image_p,0x00,0x00,0x00,127); 
								imagefill($image_p, 0, 0, $color); 
								$image = imagecreatefrompng($destination_dir.'/'.$img_file);
							}
							if ($imageRel>$newImgRel){
								// dimensiones
								$H  = $val["h"];
								$W  = $imageDim[0]*$val["h"]/$imageDim[1];
								// offsets
								$oX =-($W-$val["w"])/2;
								$oY =0;
							}else{
								// dimensiones
								$W  = $val["w"];
								$H  = $imageDim[1]*$val["w"]/$imageDim[0];
								//ofesets
								$oY=0; // $oY=-($H-$val["h"]); center
								$oX=0;
							}
						}elseif($val["h"]=="auto" && $val["w"]=="auto"){
							$newImgRel=$imageRel;
							if ($imageRel<$maxW/$maxH){
								// dimensiones
								$W  = $imageDim[0]*$maxH/$imageDim[1];
								$H  = $maxH;
							}else{
								// dimensiones
								$W  = $maxW;
								$H  = $imageDim[0]*$maxW/$imageDim[1];
							}
							
							$image_p = imagecreatetruecolor($W, $H);
							if ( strpos($img_type, "jpeg") || strpos($img_type,"jpg")){
								$image = imagecreatefromjpeg($destination_dir.'/'.$img_file);
							}elseif ( strpos($img_type, "gif")){
								$image = imagecreatefromgif($destination_dir.'/'.$img_file);
							}elseif ( strpos($img_type, "png")){
								imagesavealpha($image_p, true); 
								$color = imagecolorallocatealpha($image_p,0x00,0x00,0x00,127); 
								imagefill($image_p, 0, 0, $color); 
								$image = imagecreatefrompng($destination_dir.'/'.$img_file);
							}
							
						}else{
							
							if ($val["h"]=="auto"){
								// dimensiones
								$W  = $val["w"];
								$H  = $imageDim[1]*$val["w"]/$imageDim[0];
							}elseif ($val["w"]=="auto"){
								// dimensiones
								$W  = $imageDim[0]*$val["h"]/$imageDim[1];
								$H  = $val["h"];
							}
							
							$image_p = imagecreatetruecolor($W, $H);
							if ( strpos($img_type, "jpeg") || strpos($img_type,"jpg")){
								$image = imagecreatefromjpeg($destination_dir.'/'.$img_file);
							}elseif ( strpos($img_type, "gif")){
								$image = imagecreatefromgif($destination_dir.'/'.$img_file);
							}elseif ( strpos($img_type, "png")){
								imagesavealpha($image_p, true); 
								$color = imagecolorallocatealpha($image_p,0x00,0x00,0x00,127); 
								imagefill($image_p, 0, 0, $color); 
								$image = imagecreatefrompng($destination_dir.'/'.$img_file);
							}
							$oY=0;
							$oX=0;
						}
						//imagecopyresampled($image_p, $image, $oX, $oY, 0, 0, $W, $H, $imageDim[0], $imageDim[1]);
						imagecopyresampled($image_p, $image, 0, 0, 0, 0, $W, $H, $imageDim[0], $imageDim[1]);
						if ( strpos($img_type, "jpeg") || strpos($img_type,"jpg")){
							imagejpeg( $image_p, $destination_dir.'/'.$key.'/'.$img_file,90);
						}elseif ( strpos($img_type, "gif")){
							imagegif( $image_p, $destination_dir.'/'.$key.'/'.$img_file);
						}elseif ( strpos($img_type, "png")){
							imagepng( $image_p, $destination_dir.'/'.$key.'/'.$img_file);
						}
						
					}
					if ($_GET["do"]=="push clase") {
						echo '<p><img src="../Includes/imgs/upoloads/aside/'.$img_file.'" /></p>';
					}elseif ($_GET["do"]=="push foto") {
						echo '<p><img src="../Includes/imgs/upoloads/thum/'.$img_file.'" /></p>';
					}
					
				}else{echo '<p>no se pudo cargar la imagen</p>';}
			}else{echo '<p>no se pudo copiar la imagen (moveUpload)</p>';}
		}else{echo '<p>No es un formato de imagen compatible (jpeg, jpg, gif, png)</p>';}
	}else{echo "<p>El directorio ($destination_dir) no existe o no se subio un archivo</p>";}
}

function draw_calendar($month,$year,$daychange,$daysoff,$opDia){
	
	$headings = array('Do','Lu','Ma','Mi','Ju','Vi','Sa');
	global $hoy;
	// calendario
	 
	$calendar = '
									
								<table cellpadding="0" cellspacing="0" class="calendar">
							';
	
	
	/* table headings */
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	$offn=count($daysoff);
	
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
	$clase="";
		$claseR="";
		$claseL="";
		if ($offn>0){
			$fulldate="$year-$month-$list_day";
			$fulldate= date('Y-m-d', strtotime($fulldate));
			$index=array_search($fulldate,$daysoff);
			if ($index!== false){
				$clase .= " off";
				if($opDia[$index]==0 ){
					$claseR=" off";
					$claseL=" off";
					
				}else if($opDia[$index]==1){
					$claseL=" off";
				}else if($opDia[$index]==2){
					$claseR=" off";
				}
			}
		}
		
		// hoy
		
		if ($hoy=="$year-$month-$list_day") {$clase .= " shadow";}
		$date="$year-$month-$list_day";
		
		$calendar.= '
								 <td class="calendar-day '.$clase.'">
								 <div class="diaL '.$claseL.'"></div>
								 <div class="diaR '.$claseR.'"></div>
								';
			/* add in the day number */
			
			$calendar.= '<a  id="'.$date.'" class="day-number">'.$list_day.'</a>';

			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
			$calendar.= str_repeat('<p> </p>',2);
			
		$calendar.= '</td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	echo '<div class="calDaysOff">
									<div>
												<a href="http://restosibaris.com.ar/Prev/admin/?q=res&a=calendario" class="goback">[X]</a>
												<p id="textjs"></p>
												<form action="./?q=res&a=daychange" method="post">
													<select name="accion">
														<option value="off">Deshabilitar</option>
														<option value="on">Habilitar</option>
													</select><br />
													<input type="radio" name="opcionDia" value="0" checked  /><span>Completo</span><br/>
													<input type="radio" name="opcionDia" value="1"  /><span>Almuerzo</span><br />
													<input type="radio" name="opcionDia" value="2"  /><span>Cena</span><br />
													<input id="fecha" type="hidden" name="date" value="">
													<input type="submit" value="Aceptar" />
												
												</form>
											</div>
									 </div>';
	$calendar.= '</table>';
	
	/* all done, return result */
	return $calendar;
}


function query_to_csv ($db_conn, $query, $filename, $attachment = false, $headers = true) {
	if($attachment) {
		// send response headers to the browser
		header( 'Content-Type: text/csv' );
		header( 'Content-Disposition: attachment;filename='.$filename);
		$fp = fopen('php://output', 'w');
	} else {
		$fp = fopen($filename, 'w');
	}
	
	$result = mysql_query($query, $db_conn) or die( mysql_error( $db_conn ) );
	global $getq;
	if($headers) {
		// output header row (if at least one row exists)
		$row = mysql_fetch_assoc($result);
		if($row) {
			fputcsv($fp, array_keys($row));
			// reset pointer back to beginning
			mysql_data_seek($result, 0);
		}
	}
	
	while($row = mysql_fetch_assoc($result)) {
		fputcsv($fp, $row);
	}
	
	fclose($fp);

}

function debug_to_console( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}
?>