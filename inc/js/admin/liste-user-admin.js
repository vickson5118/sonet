$(document).ready(function(){
	
	/**
	*Creer un administrateur
	 */
	//validation JS
	inputValidation("#staticBackdropCreateAdmin #nom","nom",2,30,true);
	inputValidation("#staticBackdropCreateAdmin #prenoms","prenoms",2,100,true);
	emailInputValidation("#staticBackdropCreateAdmin #email");
	
	$("#staticBackdropCreateAdmin #create-admin").click(function(){
		
		$("#staticBackdropCreateAdmin #create-admin").attr("disabled","disabled")
		gifLoader("#staticBackdropCreateAdmin #create-admin");
		$(".error").text("");
		$(".error").parent().find(".form-control").removeClass("is-invalid")
		
		const data = {};
		data.nom = $("#staticBackdropCreateAdmin #nom").val();
		data.prenoms = $("#staticBackdropCreateAdmin #prenoms").val();
		data.email = $("#staticBackdropCreateAdmin #email").val();
		
		$.post("/validation/admin/users/create-admin-validation.php",data,function(data){
			if(data.type === "success"){
				
				location.reload();
				
			}else if(data.type === "session"){
				$(location).attr("href","/wps-admin")
			}else{
				
				$("#staticBackdropCreateAdmin #create-admin").removeAttr("disabled")
				
				Object.entries(data).forEach(([key,value]) => {
					$("#staticBackdropCreateAdmin #"+key).addClass("is-invalid")
					$("#staticBackdropCreateAdmin #"+key).parent().find(".error").text(value)
				});
					
				if(data.msg != null){
					createErrorNotif(data.msg,3,"top-right")
				}
			}
			
		},"json")
		
	})
	
	
	//Bloquer l'user
	inputValidation("#motif-blocage","motif",10,150,true);
	$(".btn-bloquer-user").click(function(){
		const id = $(this).val();
		const name = $(this).parent().parent().find(".row-name").text();
		const email = $(this).parent().parent().find(".row-email").text();
		
		$("#bloquer-info").html("Le blocage de l'utilisateur suivant: <br /><br /> Nom & prenoms: <b>"+name+"</b> <br />"
			+"Email: <b>"+email+"</b><br /><br /> empêchera celui-ci de se connecter à nouveau.")
	
		$("#btn-confirm-bloquer-user").click(function(){
			
			$("#btn-confirm-bloquer-user").attr("disabled","disabled")
			gifLoader("#btn-confirm-bloquer-user")

			const motif = $("#motif-blocage").val();
			
			$.post("/validation/admin/users/blocage-user-validation.php",{id,motif},function(data){
				if(data.type === "success"){
					
					location.reload();		
							
				}else if(data.type === "session"){
					
					$(location).attr("href","/wps-admin")
					
				}else{
					
					$("#btn-confirm-bloquer-user").removeAttr("disabled")
					
					if(data.motif != null){
						$("#motif-blocage").addClass("is-invalid")
						$("#motif-blocage").parent().find(".error").text(data.motif)
					}else{
						$("#motif-blocage").removeClass("is-invalid").addClass("is-valid")
						$("#motif-blocage").parent().find(".error").text("")	
					}
					
					if(data.id != null){
						createErrorNotif(data.id,3,"top-right")
					}
				}
			},"json")
			
		})
	})
	
	//Débloquer l'admin
	$(".btn-debloquer-user").click(function(){
		const id = $(this).val();
		const name = $(this).parent().parent().find(".row-name").text();
		const email = $(this).parent().parent().find(".row-email").text();
		
		$("#debloquer-info").html("Le déblocage de l'utilisateur suivant: <br /><br /> Nom & prenoms: <b>"+name+"</b> <br />"
			+"Email: <b>"+email+"</b><br /><br /> permettra à celui-ci de se connecter à nouveau.")
		
		$("#btn-confirm-debloquer-user").click(function(){
			
			$("#btn-confirm-debloquer-user").attr("disabled","disabled")
			gifLoader("#btn-confirm-debloquer-user")
			
			$.post("/validation/admin/users/deblocage-user-validation.php",{id},function(data){
				if(data.type === "success"){
					location.reload();				
				}else if(data.type === "session"){
					
					$(location).attr("href","/wps-admin")
					
				}else{
					$("#btn-confirm-debloquer-user").removeAttr("disabled")
					
					if(data.id != null){
						createErrorNotif(data.id,3,"top-right")
					}
					
				}
			},"json")
			
		})
	})
	
	
	
	
})