
//faire apparaitre un gif lorsqu'on clique sur un btn'
function gifLoader(selecteur) {
	
	const height = $(selecteur).css("height");
	const width = $(selecteur).css("width");
	const textBtn = $(selecteur).text()
	
	
	$(document).ajaxStart(function() {
		$(selecteur).text("");
		$(selecteur).css({
			"height": height,
			"width": width,
			"backgroundImage": "url(/inc/images/gif/loader.svg)",
			"backgroundRepeat": "no-repeat",
			"backgroundPosition": "center"
		});
	});

	$(document).ajaxStop(function() {
		$(selecteur).text(textBtn);
		$(selecteur).css({
			"backgroundImage": "none"
		});
	});
}

function createSuccessNotif(message,time,position){
	alertify.set("notifier","position",position)
	alertify.success(message,time);
}

function createErrorNotif(message,time,position){
	alertify.set("notifier","position",position)
	alertify.error(message,time);
}

function inputValidation(selector,champ,minLength,maxLength,required){
	$(selector).keyup(function(){
		const texteLength = $(this).val().trim().length;
		if( ((!required && texteLength > 0) && texteLength < minLength) || (required && texteLength < minLength)){
			$(this).addClass("is-invalid")
			$(this).parent().find(".error").text("Le champ "+champ+" ne peut être inférieur à "+minLength+" caractères.")
		}else if(texteLength > maxLength){
			$(this).addClass("is-invalid")
			$(this).parent().find(".error").text("Le champ "+champ+" ne peut être supérieur à "+maxLength+" caractères.")
		}else{
			$(this).removeClass("is-invalid").addClass("is-valid")
			$(this).parent().find(".error").text("")
		}
	})
}

function emailInputValidation(selector){
	$(selector).keyup(function(){
		if(!$(this).val().match(/^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/)){
			$(this).addClass("is-invalid")
			$(this).parent().find(".error").text("Le format de l'adresse E-mail est incorrect.")
		}else{
			$(this).removeClass("is-invalid").addClass("is-valid")
			$(this).parent().find(".error").text("")
		}
	})
}

function telInputValidation(selector){
	$(selector).keyup(function(){
		 if($(this).val().length > 0 && !$(this).val().match(/^([0-9]{2}[. -]?){4}[0-9]{2}$/)){
			$(this).addClass("is-invalid")
			$(this).parent().find(".error").text("Le format du téléphone est incorrect.")
		}else{
			$(this).removeClass("is-invalid").addClass("is-valid")
			$(this).parent().find(".error").text("")
		}
	})
}

