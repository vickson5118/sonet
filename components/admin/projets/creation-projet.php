<?php
namespace components\admin\projets;

use manager\ClientManager;
use manager\DomaineManager;
use manager\LieuManager;
use manager\ProjetManager;
use utils\Functions;
use manager\FileManager;

require_once($_SERVER["DOCUMENT_ROOT"] . "/src/Utilisateur.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/manager/ClientManager.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/manager/DomaineManager.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/manager/LieuManager.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/manager/ProjetManager.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/manager/FileManager.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/Client.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/Domaine.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/Lieu.php");

session_start();

if(($_SESSION["utilisateur"]) == null) {
    header("Location: http://" . $_SERVER["SERVER_NAME"] . "/wps-admin");
    exit();
}

$projetManager = new ProjetManager();
$oneProjet = $projetManager->getOneProjet(Functions::getValueChamp($_GET["id"]));

if($oneProjet == null) {
    http_response_code(404);
    exit();
}

$clientManager = new ClientManager();
$domaineManager = new DomaineManager();
$lieuManager = new LieuManager();
$fileManager = new FileManager();


$listeClient = $clientManager->getAllClient();
$liseDomaine = $domaineManager->getAllDomaine();
$listeLieu = $lieuManager->getAllLieu();
$listeProjetFiles = $fileManager->getProjetFiles($oneProjet->getId());

//Ajouter le projet courant dans la session
$_SESSION["projet"] = $oneProjet;


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Création d'un projet | SONET-CI</title>
    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/inc/other/admin/css.php"); ?>
    <link rel="stylesheet" href="/inc/css/admin/creation projet.css" type="text/css"/>
    <script src="https://cdn.tiny.cloud/1/w4gnz8ul7u8lagw27vzog1zfmrmt20kyeqszuagrfs4d0ayc/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="https://hayageek.github.io/jQuery-Upload-File/4.0.11/uploadfile.css" rel="stylesheet">
</head>

<body>


<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/inc/other/admin/menu.php"); ?>

<div class="page-container">
    <div class="container-fluid">

        <div class="container create-projet-container">
            <h1>Creation d'un projet</h1>

            <form method="post" enctype="multipart/form-data" id="project-references">

                <div class="row mb-2">
                    <div class="form-floating mb-3 col-md-12">
                        <input type="text" class="form-control" id="titre" placeholder="Titre" name="titre"
                               value="<?= $oneProjet->getTitre() ?>"> <label for="titre" style="margin-left: 15px;">Titre
                            du projet</label>
                        <div class="error"></div>
                    </div>
                </div>

                <div class="mb-5 row">

                    <div class="col-md-11 client-container">
                        <label for="client">Client</label>
                        <select name="client" id="client" class="form-select form-select-md">
                            <?php foreach($listeClient as $client) { ?>
                                <option value="<?= $client->getId() ?>"
                                        <?php if($client->getId() == $_SESSION["projet"]->getClient()->getId()){ ?>selected="selected"<?php } ?>><?= $client->getNom() ?></option>
                            <?php } ?>
                        </select>
                        <div class="error"></div>
                    </div>

                    <div class="col-md-1">
                        <button type="button" class="btn-add-client" data-bs-toggle="modal" data-bs-target="#staticBackdropAddClient">
                            <i class="bi bi-plus-square-fill"></i>
                        </button>
                    </div>

                </div>

                <div class="row">

                    <div class="form-floating mb-3 col-md-6">
                        <input type="text" class="form-control" id="debut" placeholder="Date de début" name="debut" readonly="readonly" value="<?= $oneProjet->getDateDebut() ?>">
                        <label for="debut" style="margin-left: 15px;">Date de début</label>
                        <div class="error"></div>
                    </div>

                    <div class="form-floating mb-3 col-md-6">
                        <input type="text" class="form-control" id="fin" placeholder="Date de fin" name="fin" readonly="readonly" value="<?= $oneProjet->getDateFin() ?>">
                        <label for="fin" style="margin-left: 15px;">Date de fin</label>
                        <div class="error"></div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <div class="row">
                            <div class="col-md-11 domaine-container">
                                <label for="domaine">Domaine</label>
                                <select name="domaine" id="domaine" class="col-md-12 form-select form-select-md">
                                    <?php foreach($liseDomaine as $domaine) { ?>
                                        <option value="<?= $domaine->getId() ?>"
                                                <?php if($domaine->getId() == $_SESSION["projet"]->getDomaine()->getId()){ ?>selected="selected"<?php } ?>><?= $domaine->getNom() ?></option>
                                    <?php } ?>
                                </select>
                                <div class="error"></div>
                            </div>

                            <div class="col-md-1">
                                <button type="button" class="btn-add-domaine" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdropAddDomaine">
                                    <i class="bi bi-plus-square-fill"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <div class="row">
                            <div class="col-md-11 lieu-container">
                                <label for="lieu">Lieu</label>
                                <select name="lieu" id="lieu" class="col-md-12 form-select form-select-md">
                                    <?php foreach($listeLieu as $lieu) { ?>
                                        <option value="<?= $lieu->getId() ?>"
                                                <?php if($lieu->getId() == $_SESSION["projet"]->getLieu()->getId()){ ?>selected="selected"<?php } ?>><?= $lieu->getNom() ?></option>
                                    <?php } ?>
                                </select>
                                <div class="error"></div>
                            </div>

                            <div class="col-md-1">
                                <button type="button" class="btn-add-lieu" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdropAddLieu">
                                    <i class="bi bi-plus-square-fill"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="row" style="margin-bottom: 20px;">

                    <div class="illustration-container col-md-7" style="margin-top: 30px;">
                        <label style="margin-bottom: 10px;">Image d'illustration du projet</label>
                        <div id="img-container">
                            <?php if($oneProjet->getIllustration() == null) { ?>
                                <img src="/inc/images/admin/telechargement.jpg" alt="image par defaut" style="width: 100%;height: auto"/>
                            <?php } else { ?>
                                <img src="<?= $oneProjet->getIllustration() ?>" alt="<?= $oneProjet->getTitre() ?>" style="width: 100%;height: auto"/>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="illustration-directives col-md-5" style="margin-top: 110px;">
                        <p>Téléchargez votre image de projet ici. Pour être acceptée, elle doit répondre à nos
                            normes de qualité
                            relatives aux images de projets. Directives importantes : 1920 x 900 pixels ; format
                            .jpg, .jpeg, ou .png </p>

                        <input class="form-control" type="file" id="illustration" name="illustration" accept="image/*">
                        <div class="error"></div>
                    </div>

                </div>

                <div class="row mb-5">
                    <label for="description">Description du projet</label>
                    <div class="col-md-12">
                        <textarea id="description"><?= $oneProjet->getDescription() ?></textarea>
                        <div class="error"></div>
                    </div>
                </div>

                <div class="row mb-5">
                    <label for="objectif">Objectifs du projet</label>
                    <div class="col-md-12">
                        <textarea id="objectif"><?= $oneProjet->getObjectif() ?></textarea>
                        <div class="error"></div>
                    </div>
                </div>

                <div class="row mb-5">
                    <label for="resultat">Résulltats obtenus</label>
                    <div class="col-md-12">
                        <textarea id="resultat"><?= $oneProjet->getResultat() ?></textarea>
                        <div class="error"></div>
                    </div>
                </div>

               <div class="mb-3">
                   <div class="mb-2">
                       <input type="radio" value="0" name="achievement" id="proccess" <?php if(!$oneProjet->isFinish()){ ?>checked<?php }?>>
                       <label for="proccess"> En cours</label>
                   </div>

                   <div>
                       <input type="radio" value="1" name="achievement" id="finish" <?php if($oneProjet->isFinish()){ ?>checked<?php }?>>
                       <label for="finish"> Terminé</label>
                   </div>
               </div>

                <button type="submit" id="btn-add-projet">Valider</button>
            </form>

        </div>

        <?php if($oneProjet->isFinish()) { ?>
            <div class="container projet-file-container">

                <div id="fileuploader">Upload</div>

                <?php foreach($listeProjetFiles as $file) { ?>
                    <div class="one-projet-image">
                        <img src="<?= $file->getChemin() ?>" alt="<?= $oneProjet->getTitre() ?>"/>
                        <button type="button" value="<?= $file->getChemin() ?>" class="btn-delete-one-image"><i
                                    class="bi bi-x-lg"></i></button>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>


    </div>
</div>

<?php
require_once("modal/modal-add-client.php");
require_once("modal/modal-add-domaine.php");
require_once("modal/modal-add-lieu.php");
?>

<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/inc/other/admin/js.php"); ?>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://hayageek.github.io/jQuery-Upload-File/4.0.11/jquery.uploadfile.min.js"></script>
<script src="/inc/js/admin/creation-projet.js" type="text/javascript"></script>
</body>

</html>