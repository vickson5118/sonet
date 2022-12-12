<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/src/Utilisateur.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/manager/ContactManager.php");

session_start ();

use manager\ContactManager;
use utils\Functions;

if (($_SESSION ["utilisateur"]) == null) {
    header ( "Location: http://" . $_SERVER ["SERVER_NAME"]."/w1-admin" );
    exit ();
}

$contactManager = new ContactManager();
$contact = $contactManager->getMail(intval(Functions::getValueChamp($_GET["mail"])));

if($contact == null){
    http_response_code(404);
    exit();
}else if(!$contact->isView()){
    $contactManager->updateView($contact->getId());
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
<title>Mail de <?= $contact->getPrenoms() ?>  | SONET-CI </title>
<meta charset="utf-8" />
		<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/admin/css.php"); ?>
		<link rel="stylesheet" href="/inc/css/admin/contact.css" type="text/css" />
</head>
<body>

	<?php require_once ($_SERVER["DOCUMENT_ROOT"] . "/inc/other/admin/menu.php"); ?>

	<div class="page-container" style="margin-top: 120px;">
		<div class="container" id="wiew-mail-container">
		
		<div class="mail-objet">
			<h3><?= $contact->getObjet() ?></h3>
		</div>
		
			<div class="user-info-container">
				<div><b>Nom &amp; prenoms: </b><?= $contact->getPrenoms()." ".$contact->getNom() ?></div>
				<div><b>Email: </b><span class="row-email"><?= $contact->getEmail() ?></span></div>
				<div><b>Telephone: </b><?= $contact->getTelephone() ?></div>
				<div><b>Date envoi: </b><?= $contact->getDateEnvoi(); ?></div>
			</div>
			
			<div class="uer-message">
				<?= $contact->getMessage() ?>
				
				<button data-bs-toggle="modal" id="btn-reply-mail" data-bs-target="#modalSendMail" type="button" class="btn btn-primary btn-send-mail" title="Envoyer un mail à l'auteur">Repondre</button>
			</div>
			
			
			
		</div>
		<?php 
		  require_once ("../users/modal/modal-send-mail.php");
		?>
	</div>
	
	<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/admin/js.php"); ?>
    <script src="/inc/js/admin/script.js" type="text/javascript"></script>
</body>
</html>