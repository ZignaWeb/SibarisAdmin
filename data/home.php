<?
session_start();
if ($_SESSION["appusr"]!="") {
?>
<div id="top">
                <div class="wrap">
                <img id="u_foto" src="r/h_thumb.png" />
                <div class="u_info">
                    <div class="nombre">Juan Carlos Andrada</div>
                    <div class="secLine">Córdoba</div>
                    <a href="#" class="link"><img src="../r/h_conf_tiny.png" />Mi Configuración</a>
                </div>
                </div>
            </div>
            <div class="wrap">
            <ol data-role="content" id="btn_cuenta">
                <li><a href="club.php" class="link" data-transition="flip"><img src="../r/h_club.png" /></a></li>
                <li><a href="sugerencias.php" class="link" data-transition="flip"><img src="../r/h_sugerencias.png" /></a></li>
                <li><a href="recetas.php" class="link" data-transition="flip"><img src="../r/h_recetas.png" /></a></li>
            </ol>
            </div>
            <ol id="botoneraPrincipal">
        	<li><img src="r/reserva.png" /></li>
            <li><img src="r/cuenta.png" /></li>
        </ol>
<? } else { ?>

<form action="data/logincheck.php" method="post">
            <input type="text" name="usr" id="username" value="" placeholder="Username"/>
            <input name="psw" placeholder="Contraseña" type="password" />
            <input type="submit" value="Ingresar" />
        </form>

<? } ?>