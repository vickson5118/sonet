<?php
namespace components\admin\projets\modal;
?>

<div class="modal fade" id="staticBackdropDebloquerProjet" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="debloquerProjetModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="debloquerProjetModalLabel">Débloquer un projet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <span class="text-success" id="debloquer-info"></span>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary btn-confirm-debloquer-projet">Valider</button>
      </div>
    </div>
  </div>
</div>