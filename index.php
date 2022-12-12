<?php session_start (); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Bienvenue sur le site de la SONET-CI | SONET-CI</title>
		<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/css.php"); ?>
		<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	</head>
	
	<body>
		
		<div class="container-fluid">
			
			<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/header.php"); ?>
		
			<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/index/carrousel.php"); ?>
			
			<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/index/missions.php"); ?>
			
			<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/index/domaines.php"); ?>
			
			<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/index/realisations.php"); ?>
			
			<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/index/partenaires.php"); ?>
			
			<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/footer.php"); ?>
			
		</div>
		
		
		
		<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/js.php"); ?>
		<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
		<script src="/inc/js/index.js" type="text/javascript"></script>
	</body>
	
</html>