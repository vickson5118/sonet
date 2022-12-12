<?php 
namespace inc\other\index;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/ProjetManager.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Projet.php");

use manager\ProjetManager;
use utils\Functions;

$projetManager = new ProjetManager();
$listeProjet = $projetManager->getThreeLastProjet(true);

?>

<div class="projets-container">

	<div class="container">

		<h2>Nos réalisations</h2>

		<div class="row">
            <?php foreach($listeProjet as $projet){ ?>
                <div class="col-md-4 one-projet-container">
                    <img src="<?= $projet->getIllustration() ?>" alt="<?= $projet->getTitre() ?>" />
                    <h3>
                        <a href="/realisations/<?= $projet->getTitreUrl() ?>"><?= $projet->getTitre() ?></a>
                    </h3>
                    <p class="date-construction"><?= Functions::formatProjetDate($projet->getDateDebut(), $projet->getDateFin()) ?></p>
                    <p><?= $projet->getLieu()->getNom() ?></p>
                </div>
            <?php }?>
		</div>
		
		<a href="/realisations" class="link-projets">Plus de projets</a>

	</div>

</div>