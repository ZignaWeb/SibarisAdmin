// JavaScript Document
$("a").click(function(event){
	event.preventDefault();
	if (confirm('Esta acción no se puede revertir. ¿Quiere continuar?')) {
		window.location.href = $(this).attr("href");
	}
});

function richTextualize (selector) {
	$( selector+" .rtfBtn").click(function(event){
		event.preventDefault();
		var textarea = $(selector + " textarea" )[0];
		var tag = $(this).attr("rel");
		if (tag!="clear") {
			if ('selectionStart' in textarea) {
					// check whether some text is selected in the textarea
				if (textarea.selectionStart != textarea.selectionEnd) {
					var newText = textarea.value.substring (0, textarea.selectionStart) + 
						"["+tag+"]" + textarea.value.substring  (textarea.selectionStart, textarea.selectionEnd) + "[/"+tag+"]" +
						textarea.value.substring (textarea.selectionEnd);
					textarea.value = newText;
				}
			}
			else {  // Internet Explorer before version 9
					// create a range from the current selection
				var textRange = document.selection.createRange ();
					// check whether the selection is within the textarea
				var rangeParent = textRange.parentElement ();
				if (rangeParent === textarea) {
					textRange.text = "["+tag+"]" + textRange.text + "["+tag+"]";
				}
			}
		}else{
			textarea.value = textarea.value.replace(/(\[([^\]]+)\])/ig,"");
		}
		
	});	
}

function ajaxizeForm (form) {
	$(form).after('<div id="enviando">Enviando ...</div><div id="mensaje"></div>');
	
	$(form).submit(function(event) {
	  event.preventDefault();
	  $(form).fadeOut(function(){
		  $("#enviando").fadeIn();
		  
		  var url = $(this).attr('action');
		  var datos = $(this).serialize();
		  
		  $.post(url, datos, function(resultado) {
			  
			$('#mensaje').html(resultado);
			
			$("#enviando").fadeOut(function (){
				$("#mensaje").fadeIn();
			});
		  });  
	  });
	});
}