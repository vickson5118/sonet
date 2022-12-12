<?php 

namespace components\admin\projets;

use manager\ProjetManager;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/ProjetManager.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/src/Utilisateur.php");

session_start ();

if (($_SESSION ["utilisateur"]) == null) {
    header ( "Location: http://" . $_SERVER ["SERVER_NAME"]."/wps-admin" );
    exit ();
}

$projetManager = new ProjetManager();
$listeProjet = $projetManager->getAllProjet();

$projetEnCours = false;
$projetFini = false;
$projetBloque = false;

foreach ($listeProjet as $projet){

    if(!$projet->isFinish()){
        $projetEnCours = true;
    }
    
    if($projet->isFinish() && !$projet->isBlocage()){
        $projetFini = true;
    }

    if($projet->isFinish() && $projet->isBlocage()){
        $projetBloque = true;
    }
    
}

?>

<!DOCTYPE html>
    <html lang="fr">
    	<head>
            <meta charset="utf-8">
            <title>Liste des projets | SONET-CI</title>
        	<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/admin/css.php"); ?>
    	</head>
    
    	<body>
	
		
		<?php require_once ($_SERVER["DOCUMENT_ROOT"] . "/inc/other/admin/menu.php"); ?>
	
		<div class="page-container">
		<div class="container-fluid">

			<!-- Button Creer admin modal -->
			<button type="button"  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdropCreateProjet" >Ajouter un projet</button>
				

			<!-- Listes des projets en cours  -->
			<div class="panel panel-primary">
				<div class="panel-header">
					<h3>Les projets en cours</h3>
				</div>
				<div class="panel-body table-responsive">
					<?php if(!$projetEnCours){ ?>
						<h3 class="text-center">Aucun projet en cours enregistré.</h3>
					<?php }else{ ?>
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th scope="col">N°</th>
								<th scope="col">Titre</th>
								<th scope="col">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$projetEnCoursCount = 0;
							foreach ($listeProjet as $projet){
							    if(!$projet->isFinish()){
							        $projetEnCoursCount++; ?>
							<tr style="text-align: center;">
								<th scope="row"><?= $projetEnCoursCount ?></th>
								<td><?= $projet->getTitre() ?></td>
    								<td>
        								<a href="/wps-admin/projets/creation/<?= $projet->getId() ?>" title="Voir le projet" class="btn btn-primary"><i class="bi bi-pencil-fill"></i></a>
    								</td>
								
								</tr>
								<?php }}?>
						</tbody>
					</table>
					<?php }?>
				</div>
			</div>
			
			<!-- Listes des projets en cours  -->
			<div class="panel panel-success">
				<div class="panel-header">
					<h3>Les projets terminés</h3>
				</div>
				<div class="panel-body table-responsive">
					<?php if(!$projetFini){ ?>
						<h3 class="text-center">Aucun projet terminé enregistré.</h3>
					<?php }else{ ?>
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th scope="col">N°</th>
								<th scope="col">Titre</th>
								<th scope="col">Domaine</th>
								<th scope="col">Client</th>
								<th scope="col">Lieu</th>
								<th scope="col">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$projetFiniCount = 0;
							foreach ($listeProjet as $projet){
							    if($projet->isFinish() && !$projet->isBlocage()){
							        $projetFiniCount++; ?>
							<tr style="text-align: center;">
								<th scope="row"><?= $projetFiniCount ?></th>
								<td class="row-titre"><?= $projet->getTitre() ?></td>
								<td><?= $projet->getDomaine()->getNom() ?></td>
								<td><?= $projet->getClient()->getNom() ?></td>
								<td><?= $projet->getLieu()->getNom() ?></td>
                                <td>
                                    <a href="/wps-admin/projets/creation/<?= $projet->getId() ?>" title="Voir le projet" class="btn btn-primary"><i class="bi bi-pencil-fill"></i></a>
                                    <button value="<?= $projet->getId() ?>" data-bs-toggle="modal" data-bs-target="#staticBackdropBloquerProjet" type="button" class="btn btn-danger btn-bloquer-projet" title="Bloquer le projet"><i class="bi bi-lock-fill"></i></button>
                                </td>
								
								</tr>
								<?php }}?>
						</tbody>
					</table>
					<?php }?>
				</div>
			</div>

            <!-- Listes des projets bloqués  -->
            <div class="panel panel-danger">
                <div class="panel-header">
                    <h3>Les projets bloqués</h3>
                </div>
                <div class="panel-body table-responsive">
                    <?php if(!$projetBloque){ ?>
                        <h3 class="text-center">Aucun projet bloqué.</h3>
                    <?php }else{ ?>
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Titre</th>
                                <th scope="col">Domaine</th>
                                <th scope="col">Client</th>
                                <th scope="col">Date</th>
                                <th scope="col">Motif</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $projetBloqueCount = 0;
                            foreach ($listeProjet as $projet){
                                if($projet->isFinish() && $projet->isBlocage()){
                                    $projetBloqueCount++; ?>
                                    <tr style="text-align: center;">
                                        <th scope="row"><?= $projetBloqueCount ?></th>
                                        <td class="row-titre"><?= $projet->getTitre() ?></td>
                                        <td><?= $projet->getDomaine()->getNom() ?></td>
                                        <td><?= $projet->getClient()->getNom() ?></td>
                                        <td><?= $projet->getDateBlocage() ?></td>
                                        <td><?= $projet->getMotifBlocage() ?></td>
                                        <td>
                                            <a href="/wps-admin/projets/creation/<?= $projet->getId() ?>" title="Voir le projet" class="btn btn-primary"><i class="bi bi-pencil-fill"></i></a>
                                            <button value="<?= $projet->getId() ?>" data-bs-toggle="modal" data-bs-target="#staticBackdropDebloquerProjet" type="button" class="btn btn-success btn-debloquer-projet" title="Debloquer le projet"><i class="bi bi-unlock-fill"></i></button>
                                        </td>

                                    </tr>
                                <?php }}?>
                            </tbody>
                        </table>
                    <?php }?>
                </div>
            </div>


		</div>
		<!-- Modal -->
		<?php
		require_once("modal/modal-create-projet.php");
        require_once("modal/modal-bloquer-projet.php");
        require_once("modal/modal-debloquer-projet.php");
        ?>

	</div>
		
		<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/admin/js.php"); ?>
		<script src="/inc/js/admin/liste-projet.js" type="text/javascript"></script>
	</body>

</html>