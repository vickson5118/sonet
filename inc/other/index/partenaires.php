<?php 
namespace inc\other\index;

use manager\PartenaireManager;
require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/PartenaireManager.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Partenaire.php");

$partenaireManager = new PartenaireManager();
$listePartenaire = $partenaireManager->getAll();
?>

<div class="partenaires-container">

	<div class="container">
		<h2>Ils nous font confiance</h2>

		<div class="partenaires-content row">
            <?php foreach($listePartenaire as $partenaire) ?>
                <div class="one-pub">
                    <img src="<?= $partenaire->getLogo() ?>" alt="<?= $partenaire->getNom() ?>" />
                </div>
            <?php ?>
		</div>

	</div>

</div>