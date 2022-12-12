$(document).ready(function(){

	inputValidation("#nom","nom",2,15,true);
	inputValidation("#prenoms","prenoms",2,30,false);
	telInputValidation("#telephone");
	emailInputValidation("#email");
	inputValidation("#objet","objet",10,100,true);
	inputValidation("#message","message",50,1000,true);

	$("#send-message").click(function(){
		
		$("#send-message").attr("disabled","disabled");
		gifLoader("#send-message");
		$(".error").text("");
		
		const data = {};
		data.nom = $("#nom").val();
		data.prenoms = $("#prenoms").val();
		data.telephone = $("#telephone").val();
		data.email = $("#email").val();
		data.objet = $("#objet").val();
		data.message = $("#message").val();
		
		$.post("/validation/other/contactez-nous-validation.php",data,function(data){
			if(data.type === "success"){

				createSuccessNotif("Vous message a bien été envoyé. Nous vous repondrons sous peu.",3,"top-right")
				setTimeout(function(){$(location).attr("href","/"); }, 3000);

			}else{
				
				$("#send-message").removeAttr("disabled");

				if(data.msg != null){
					createErrorNotif(data.msg,3,"top-right")
				}

				Object.entries(data).forEach(([key, value]) => {
					$("#" + key).addClass("is-invalid")
					$("#" + key).parent().find(".error").text(value)
				});
				
			}
		},"json")
	});
})