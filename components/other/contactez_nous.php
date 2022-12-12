<?php 
    namespace components\other;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<title>Contactez-nous | SONET-CI</title>
<meta charset="utf-8" />
	<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/css.php"); ?>
	<link rel="stylesheet" href="/inc/css/other/contactez_nous.css" type="text/css" />
</head>
<body>

	<div class="container-fluid">

		<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/header.php"); ?>

		<div class="page-carrousel-container">
			<div class="page-carrousel-bg">
				<h1>Contactez-nous</h1>
			</div>
		</div>

		<div class="container contact-content">

			<p class="contact-texte">Pour toute demande de renseignements, de
				devis, de formations ou suggestions sur notre site, n'hésitez pas à
				nous contacter, nous vous répondrons dans les plus brefs délais.</p>


			<div class="row">
				<div class="col-md-6 map-container">
				
					<div class="mapouter">
						<div class="gmap_canvas">
							<iframe width="620" height="650" id="gmap_canvas" src="https://maps.google.com/maps?q=5.392899982546324,%20-3.9761991612258245&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
							<a href="https://fmovies-online.net">fmovies</a><br>
							<style>.mapouter{position:relative;text-align:right;height:650px;width:620px;}</style>
							<a href="https://www.embedgooglemap.net">iframe html generator</a>
							<style>.gmap_canvas {overflow:hidden;background:none!important;height:650px;width:620px;}</style>
						</div>
					</div>

				</div>
				<div class="col-md-6 contact-container">

					<form>

                        <div class="row">

                            <div class="col-md-6 input-container">
                                <label for="nom">Nom</label>
                                <input type="text" name="nom" id="nom" />
                                <div class="error"></div>
                            </div>

                            <div class="col-md-6 input-container">
                                <label for="prenoms">Prenoms</label> <input type="text"
                                                                            name="prenoms" id="prenoms" />
                                <div class="error"></div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6 input-container">
                                <label for="email">E-mail</label> <input type="email"
                                                                         name="email" id="email" />
                                <div class="error"></div>
                            </div>

                            <div class="col-md-6 input-container">
                                <label for="telephone">Telephone</label>
                                <input type="tel" name="telephone" id="telephone" />
                                <div class="error"></div>
                            </div>

                        </div>

						<div class="input-container">
							<label for="objet">Objet</label>
                            <input type="text" name="objet" id="objet" />
							<div class="error"></div>
						</div>

                        <div class="input-container">
                            <label for="message">Message</label>
                            <textarea name="message" id="message" class="col-md-12"></textarea>
                            <div class="error"></div>
                        </div>

						<button type="button" class="btn-contact" id="send-message">Soumettre</button>
						
					</form>

				</div>
			</div>

		</div>

		<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/footer.php"); ?>

	</div>

	<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/js.php"); ?>
    <script src="/inc/js/other/contactez-nous.js" type="text/javascript"></script>
</body>
</html>