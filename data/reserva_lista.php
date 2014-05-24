<?
include("main.php");
$ide=addslashes($_GET["id"]);
$rq=mysql_query("SELECT * FROM `reservas` WHERE `userid`='$ide'");
while($rd=mysql_fetch_assoc($rq)){
	$fechahora=$rd["fechahora"];
	echo '<div class="itm">
            <h2>'.$rd["fechahora"].'</h2>
            <p>Reserva para: '.$rd["comenzales"].' '.$rd["preferencias"].'</p>
        </div>';
}
?>