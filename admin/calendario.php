<div class="col2">
    <div class="cuadro main_wide menuSec">
    	 <? include("r/menuSec.php");?>
    </div>
    
    <div class="cuadro main_wide">
    <? 
	$months   = array (1=>'Ene',2=>'Feb',3=>'Mar',4=>'Abr',5=>'May',6=>'Jun',7=>'Jul',8=>'Ago',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dic');

	/* años */
	if ($_GET["Y"]){$Y=$_GET["Y"];}else{$Y=date("Y");}
	if ($_GET["M"]){$M=$_GET["M"];}else{$M=date("n");}
	$dayLink="./?q=res&a=daychange&";
	echo '<p class="calendar-title-years">';
	for ($i=date("Y"); $i<=date("Y")+2 ; $i++) {
		if ($Y==$i){ $class="class='calendar-actual'";}else{$class="";}
		$url="?q=res&a=calendario";
		$url.="&Y=$i";
		$url.="&M=$M";
		echo "<a href='$url' $class>$i</a>";
	}
	echo '</p>';
	
	// meses
	echo '<p class="calendar-title-meses">';
	for ($i=1; $i<=12 ; $i++) {
		if ($M==$i){ $class="class='calendar-actual'";}else{$class="";}
		$url="?q=res&a=calendario";
		$url.="&Y=$Y";
		$url.="&M=$i";
		echo "<a href='$url' $class>".$months[$i]."</a>";
	}
	echo '</p>';
	$dq=mysql_query("SELECT * FROM `calendario` WHERE YEAR(fecha) = '$Y' AND MONTH(fecha)='$M' ORDER BY `fecha` ASC");
	$dn=mysql_num_rows($dq);
	for ($i=0;$i<$dn;$i++) {
		$d=mysql_fetch_assoc($dq);
		$dl[$i]=$d["fecha"];
		$opDia[$i]=$d["dayoff"];
	}
	echo draw_calendar($M,$Y,$dayLink,$dl,$opDia);
	?>
    
    </div>
</div>
<script type="text/javascript" >


	$(".day-number").click(function(){
		$(".calDaysOff").css("display","block");
			var dia=$(this).attr("id");
			$("#textjs").html(dia);
			$("#fecha").val(dia);
		});
		$(".goback").click(function(event){
			event.preventDefault(); 
			$(".calDaysOff").css("display","none");
			
		});
		
		$(document).ready(function(){
	
	formCalSize();

$(window).resize(function(){
		formCalSize();
		
	})
	
	function formCalSize () {
		var calSize = $(".calendar").width();
		$(".calDaysOff").css("width",calSize);
		
	}
});


</script> 

<? include("r-lastLogins.php");?>