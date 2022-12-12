<?php 
namespace components\admin\projets\modal;
?>
<!-- Modal -->
<div class="modal fade" id="staticBackdropAddLieu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Ajouter un lieu</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<div class="modal-body">
				<form>
					<div class="row">

						<div class="form-floating mb-3 col-md-12">
							<input type="text" class="form-control" id="nom-lieu" placeholder="Nom du lieu" name="nom-lieu"> 
							<label for="nom-lieu" style="margin-left: 15px;">Nom du lieu</label>
							<div class="error"></div>
						</div>

					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-close-add-lieu">Fermer</button>
				<button type="button" class="btn btn-primary" id="btn-confirm-add-lieu">Valider</button>
			</div>
		</div>
	</div>
</div>
<!-- modal -->