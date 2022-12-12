$(document).ready(function(){
	
	
	$("#btn-admin-connexion").on("click",function(){

		$("#btn-admin-connexion").attr("disabled","disabled")
		gifLoader("#btn-admin-connexion");
		$(".connexion-error").text("");

		let data = {};
		data.email = $("#email").val();
		data.password = $("#password").val();

		$.post("/validation/admin/compte/connexion-validation.php",data,function(data){

			if(data.type === "success"){

				$(location).attr("href","/wps-admin/tableau-de-bord");

			}else{

					$("#btn-admin-connexion").removeAttr("disabled")
					$(".connexion-error").text(data.error);

				}

		},"json")

	})
	
})