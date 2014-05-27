<? 
include("../data/main.php");

								
					$rxut="
					SELECT usuario.`nombre`, usuario.`email`, usuario.`area`, usuario.`telefono`,usuario.`cumple`,usuario.`lastlogin` ,COUNT( * ) AS rxu
					FROM reservas, usuario
					WHERE estado =2
					AND usuario.id = reservas.userid ";
					if(isset($_GET["dias"]) && $_GET["dias"] > 0 ){
						$dias=mysql_real_escape_string($_GET["dias"]);
						$rxut.='AND reservas.creada >= DATE_SUB( CURDATE( ) , INTERVAL '.$dias.' DAY )';
						echo'<strong class="ndias">Mostrando ultimos '.$dias.' dias</strong>';
					}else {echo'<strong class="ndias">Mostrando resultados historicos</strong>';}
					$rxut.=" 
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
							<div class="'.$dias.'">
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