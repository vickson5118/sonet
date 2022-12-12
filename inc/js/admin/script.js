$(document).ready(function(){
	
	//Envoyer un mail à l'admin
	inputValidation("#objet","objet",15,150,true);
	inputValidation("#message","message",20,1000,true);
	$(".btn-send-mail").click(function(){
		
		const email = $(this).parent().parent().find(".row-email").text();
		
		$("#btn-confirm-send-mail").click(function(){

			$("#btn-confirm-send-mail").attr("disabled","disabled");
			gifLoader("#btn-confirm-send-mail");
			$(".error").text("");
			
			const data = {};
			data.objet = $("#objet").val();
			data.message = $("#message").val();
			data.email = email;
			
			$.post("/validation/admin/other/send-mail-validation.php",data,function(data){
				if(data.type === "success"){
					
					location.reload();
					
				}else if(data.type === "session"){
					
					$(location).attr("href","/wps-admin")
					
				}else{
					
					$("#btn-confirm-send-mail").removeAttr("disabled")
					
					Object.entries(data).forEach(([key,value]) => {
						$("#"+key).addClass("is-invalid")
						$("#"+key).parent().find(".error").text(value)
					});
					
					if(data.email != null){
						createErrorNotif(data.email,3,"top-right")
					}
				}
			},"json")
			
		})
		
	})
	
})