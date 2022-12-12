<?php 
    namespace components\realisations;
require_once($_SERVER["DOCUMENT_ROOT"] . "/manager/ProjetManager.php");

use manager\ProjetManager;

$projetManager = new ProjetManager();
$listeProjet = $projetManager->getAllProjetNotLocked();
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Nos réalisations | SONET-CI</title>
		<meta charset="utf-8" />
		<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/css.php"); ?>
		<link rel="stylesheet" href="/inc/css/realisations/home.css" type="text/css" />
	</head>
	<body>

		<div class="container-fluid">
	
			<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/header.php"); ?>
			
			<div class="page-carrousel-container">
				<div class="page-carrousel-bg">
					<h1>Nos réalisations</h1>
				</div>
			</div>
			
			<div class="container realisations-container">
				
				<div class="row">

                    <?php foreach($listeProjet as $projet){ ?>
                            <div class="col-md-4 one-realisation-container">
                                <img src="<?= $projet->getIllustration() ?>" alt="<?= $projet->getTitre() ?>"/>
                                <p class="rea-domaine"><?= $projet->getDomaine()->getNom() ?></p>
                                <h2><a href="/realisations/<?= $projet->getTitreUrl() ?>"><?= $projet->getTitre() ?></a></h2>
                                <p class="rea-evolution"><?php if($projet->isFinish()){ echo "Terminé"; }else{ echo "En cours"; } ?></p>
                            </div>
                        <?php }?>
					
				</div>
				
			</div>
		
			<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/footer.php"); ?>

		</div>

		<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/js.php"); ?>
		<script type="text/javascript" src="/inc/js/realisations/home.js"></script>
	</body>
</html>