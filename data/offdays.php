<?
include("main.php");

$dq=mysql_query("SELECT * FROM `calendario` WHERE `fecha` > '$hoy' ORDER BY `fecha` ASC");
$dn=mysql_num_rows($dq);
for($i=0;$i<$dn;$i++){
	$array[$i]=mysql_fetch_assoc($dq);
	$arrayFechas[$i]=$array[$i]["fecha"];
	$arrayDayoff[$i]=$array[$i]["dayoff"];
}
$echo="";
foreach ($arrayFechas as $val) {
	$val = date("n-j-Y",strtotime($val));
	$echo .= "'$val',";
}
foreach ($arrayDayoff as $val) {
	$echoDayoff .= "'$val',";
}
$echo= substr($echo,0,-1);
echo "var disabledDays = [$echo];";
echo "var opDia = [$echoDayoff];";
?>