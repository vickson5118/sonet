<!-- Modal -->
<div class="modal fade" id="staticBackdropEditPartenaire" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Editer un partenaire</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="post" enctype="multipart/form-data" id="edit-partenaire-form">
			<div class="modal-body">
				
					<div class="row">

						<div class="form-floating col-md-12">
							<input type="text" class="form-control" id="editNom" placeholder="Nom" name="editNom"> 
							<label for="editNom" style="margin-left: 15px;">Nom de l'entreprise</label>
							<div class="error"></div>
						</div>
						
						<div class="col-md-12 mb-3">
							
        					<label for="editPartenaireIllustration" class="form-label editPartenaireIllustrationLabel"> 
        						<img src=""  alt="" style="max-width: 300px; max-height: 300px;" />
        					</label> 
        						<input class="form-control" type="file" id="editPartenaireIllustration" name="editPartenaireIllustration" accept="image/*">
        						<span class="partenaire-illustration-info">L'image doit être au format 250 * 120</span>
        						<div class="error" style="margin-left: 25px;margin-top: -40px;"></div>
        					</div>

					</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
				<button type="submit" class="btn btn-primary" id="btn-confirm-edit-partenaire">Valider</button>
			</div>
			</form>
			
		</div>
	</div>
</div>
<!-- modal -->