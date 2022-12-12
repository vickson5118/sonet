$(document).ready(function(){
	
	/**
	Ajout d'un nouveau projet */
	inputValidation("#titre", "titre du projet", 5, 80, true);
	$("#btn-confirm-create-projet").on("click", function() {

		$("#btn-confirm-create-projet").attr("disabled", "disabled")
		gifLoader("#btn-confirm-create-projet");
		$(".error").text("");

		const titre = $("#titre").val();

		$.post("/validation/admin/projets/create-projet-validation.php", { titre }, function(data) {

			if (data.id != null) {

				$(location).attr("href", "/wps-admin/projets/creation/"+data.id);

			} else if (data.type === "session") {

				$(location).attr("href", "/wps-admin")

			} else {

				$("#btn-confirm-create-projet").removeAttr("disabled")

				if (data.titre != null) {
					$("#titre").addClass("is-invalid")
					$("#titre").parent().find(".error").text(data.titre)
				} else {
					$("#titre").removeClass("is-invalid").addClass("is-valid")
					$("#titre").parent().find(".error").text("")
				}

			}

		}, "json")

	})

	//Bloquer le projet
	inputValidation("#motif-blocage","motif",10,250,true);
	$(".btn-bloquer-projet").click(function(){
		const id = $(this).val();
		const titre = $(this).parent().parent().find(".row-titre").text();
		$("#bloquer-info").html("Le blocage du projet suivant la rendra inaccessible: <br /><br />"
			+"Titre: <b> "+titre+"</b><br />")

		$(".btn-confirm-bloquer-projet").click(function(){

			$(".btn-confirm-bloquer-projet").attr("disabled","disabled")
			gifLoader("btn-confirm-bloquer-projet")
			$(".error").text("")

			const motif = $("#motif-blocage").val();

			$.post("/validation/admin/projets/blocage-projet-validation.php",{id,motif},function(data){
				if(data.type === "success"){

					location.reload();

				}else if(data.type === "session"){

					$(location).attr("href","/wps-admin")

				}else{
					$(".btn-confirm-bloquer-projet").removeAttr("disabled")

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


	//Débloquer le projet
	$(".btn-debloquer-projet").click(function(){
		const id = $(this).val();
		const titre = $(this).parent().parent().find(".row-titre").text();

		$("#debloquer-info").html("Le déblocage du projet suivante la rendra de nouveau accessible: <br /><br />"
			+"Titre: <b> "+titre+"</b><br />")

		$(".btn-confirm-debloquer-projet").click(function(){

			$(".btn-confirm-debloquer-projet").attr("disabled","disabled")
			gifLoader(".btn-confirm-debloquer-projet")

			$.post("/validation/admin/projets/deblocage-projet-validation.php",{id},function(data){
				if(data.type === "success"){

					location.reload();
				}else if(data.type === "session"){

					$(location).attr("href","/w1-admin")

				}else{
					$(".btn-confirm-debloquer-projet").removeAttr("disabled")

					if(data.id != null){
						createErrorNotif(data.id,3,"top-right")
					}
				}
			},"json")

		})
	})
	
})