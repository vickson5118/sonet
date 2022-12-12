<?php 
namespace components\admin\projets\modal;
?>
<!-- Modal -->
<div class="modal fade" id="staticBackdropAddDomaine" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Ajouter un domaine</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<div class="modal-body">
				<form>
					<div class="row">

						<div class="form-floating mb-3 col-md-12">
							<input type="text" class="form-control" id="nom-domaine" placeholder="Nom du domaine" name="nom-domaine"> 
							<label for="nom-domaine" style="margin-left: 15px;">Nom du domaine</label>
							<div class="error"></div>
						</div>

					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-close-add-domaine">Fermer</button>
				<button type="button" class="btn btn-primary" id="btn-confirm-add-domaine">Valider</button>
			</div>
		</div>
	</div>
</div>
<!-- modal -->