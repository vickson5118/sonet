<?php 
namespace components\realisations;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/ProjetManager.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/FileManager.php");

use manager\FileManager;
use manager\ProjetManager;
use utils\Functions;


$projetManager = new ProjetManager();
$fileManager = new FileManager();
$oneProjet = $projetManager->getOneProjetWithTitreUrl(Functions::getValueChamp($_GET["url"]));

if($oneProjet == null || $oneProjet->isProccess() || $oneProjet->isBlocage()){
    http_response_code(404);
    exit();
}else{
    $listeprojetImage = $fileManager->getProjetFiles($oneProjet->getId());
}

?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<title><?= $oneProjet->getTitre() ?> | SONET-CI</title>
		<meta charset="utf-8" />
		<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/css.php"); ?>
		<link rel="stylesheet" href="/inc/css/realisations/affiche.css" type="text/css" />
	</head>
	<body>

		<div class="container-fluid">
	
			<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/header.php"); ?>
			
			<div class="realisation-header">
				<div class="realisation-header-cover" style="background-image: url('<?= $oneProjet->getIllustration() ?>');">
					<h1><?= $oneProjet->getTitre() ?></h1>
				</div>
			</div>
			
			<div class="container realisation-info-container">
			
				<div class="row info-content">
					
					<div class="col-md-3 one-info">
						<p>Domaine</p>
						<p><?= $oneProjet->getDomaine()->getNom() ?></p>
					</div>
						
						<div class="col-md-3 one-info">
							<p>Lieu</p>
							<p><?= $oneProjet->getLieu()->getNom() ?></p>
						</div>
						
						<div class="col-md-3 one-info">
							<p>Période</p>
							<p><?php if($oneProjet->getDateFin() == null){ ?> Début : <?= Functions::convertDateFrToFrMonthAbrege($oneProjet->getDateDebut()) ?><?php }else{ echo Functions::formatProjetDate($oneProjet->getDateDebut(),$oneProjet->getDateFin()); }?></p>
						</div>
						
						<div class="col-md-3 one-info">
							<p>Client</p>
							<p style="font-size: 13px;"><?= mb_strtoupper($oneProjet->getClient()->getNom()) ?></p>
						</div>
					
				</div>
				
				<div class="description-container">
					<h2>Description du projet</h2>
					<p><?= $oneProjet->getDescription() ?></p>
				</div>
				
				<div class="objectif-container">
					<h2>Objectifs</h2>
					<p><?= $oneProjet->getObjectif() ?></p>
				</div>
				
				<div class="resultats-container">
					<h2>Résultats obtenus</h2>
					<p><?= $oneProjet->getResultat() ?></p>
				</div>
				
				<div class="images-container">
					<h2>En images</h2>
                    <?php foreach($listeprojetImage as $file){ ?>
					    <img src="<?= $file->getChemin() ?>" alt=" <?= $oneProjet->getTitre() ?>" />
                    <?php }?>
				</div>
				
			</div>
		
		
			<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/footer.php"); ?>

		</div>

		<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/js.php"); ?>
	</body>
</html>