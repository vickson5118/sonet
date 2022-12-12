<?php 
    namespace inc\other\index;
    require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/ProjetManager.php");
    use manager\ProjetManager;
use utils\Functions;

$projetManager = new ProjetManager();
$listeProjet = $projetManager->getThreeLastProjet(false);
?>
<div class="carrousel-container">

	<div class="all-carrousel-container">

        <?php foreach($listeProjet as $projet){  ?>
            <div class="one-carrousel-container" style="background-image: url('<?= $projet->getIllustration() ?>');">
                <div class="one-carrousel-details-container">
                    <h1><a href="/realisations/<?= $projet->getTitreUrl() ?>"><?= $projet->getTitre() ?></a></h1>
                    <p>Début des travaux : <?= Functions::convertDateFrToFrMonthLong($projet->getDateDebut()) ?></p>
                </div>
            </div>
        <?php }?>
	</div>
	
	<div class="carrousel-prev"><i class="bi bi-chevron-left"></i></div>
	<div class="carrousel-next"><i class="bi bi-chevron-right"></i></div>
	
</div>