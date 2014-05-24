$(document).ready(function(e) {
	changeLinks ();
	/*if(!Android.getActivado()){$("#modoSibaris").css({backgroundColor:"#B59F90"});}else{$("#modoSibaris").css({backgroundColor:"#F60"});}
			
	$("#modoSibaris").click(function(){
		if (!Android.getActivado()){
			$(this).css({backgroundColor:"#F60"});
			Android.setActivado(true);
			Android.setPriorState(Android.getRingerMode());
			Android.setRingerMode(0);
			Android.showToast("Su teléfono pasará a estar en modo silencio.");
		}else{
			$(this).css({backgroundColor:"#B59F90"});
			Android.setActivado(false);
			Android.setRingerMode(Android.getPriorState());
		}
	});*/

});

function changeLinks (){
	var u = gup("u");
	$("a").each(function(){
		$(this).attr("href",$(this).attr("href")+"?u="+u);
	});
	return u;
}
function gup(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(window.location.href);
    if (results == null)
        return "";
    else
        return results[1];
} 


// date pickr
/* create an array of days which need to be disabled 
var disabledDays = ["11-20-2013", "4-5-2010"];
*/

/* utility functions */
function nationalDays(date) {
	var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
	//console.log('Checking (raw): ' + m + '-' + d + '-' + y);
	for (i = 0; i < disabledDays.length; i++) {
		if($.inArray((m+1) + '-' + d + '-' + y,disabledDays) != -1 || new Date() > date) {
			//console.log('bad:  ' + (m+1) + '-' + d + '-' + y + ' / ' + disabledDays[i]);
			return [false];
		}
	}
	//console.log('good:  ' + (m+1) + '-' + d + '-' + y);
	return [true];
}
function noWeekendsOrHolidays(date) {
	var noWeekend = jQuery.datepicker.noWeekends(date);
	return noWeekend[0] ? nationalDays(date) : noWeekend;
}