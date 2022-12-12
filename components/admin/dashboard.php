<?php 

namespace components\admin;

require_once($_SERVER["DOCUMENT_ROOT"]."/src/Utilisateur.php");

session_start();

if (($_SESSION ["utilisateur"]) == null) {
    header ( "Location: http://" . $_SERVER ["SERVER_NAME"]."/wps-admin" );
    exit ();
}


?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Tableau de bord  | Gehant</title>
		<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/admin/css.php"); ?>
		<link rel="stylesheet" href="/inc/css/admin/dashboard.css"  type="text/css" />
	</head>
	
	<body>
	
		
		<?php require_once ($_SERVER["DOCUMENT_ROOT"] . "/inc/other/admin/menu.php"); ?>
	
		<div class="page-container">
    		<div class="container-fluid">
    
    			<div class="admin-infos-container">
    				<i class='bx bxs-user-circle'></i>
    				<div class="admin-connect">
    						<span>25</span> 
    						<span><a href="/wps-admin/administrateurs">Administrateurs</a></span>
    					</div>
    					
    			</div>
    
    			<div class="user-infos-container">
    				 <i class="bi bi-people-fill"></i>
    					<div class="user-connect">
    						<span>08</span> 
    						<span><a href="/w1-admin/utilisateurs">Utilisateurs</a></span>
    					</div> 
    					
    			</div>
    			
    			<div class="domaines-formations-infos-container">
    				 <i class="bi bi-journals"></i>
    					<div class="domaines-formations-connect">
    						<span>31</span> 
    						<span><a href="/w1-admin/domaines">Domaines</a></span>
    					</div>
    				
    			</div>
    
    			<div class="formations-infos-container">
    				 <i class="bi bi-book-fill"></i>
    					<div class="formations-connect">
    						<span>21</span> 
    						<span><a href="/w1-admin/formations">Formations</a></span>
    					</div>
    			</div>
    			
    			
    			<div class="pays-infos-container">
    				 <i class="bi bi-flag-fill"></i>
    					<div class="pays-add">
    						<span>20</span> <span><a href="/w1-admin/pays">Pays</a></span>
    					</div>
    			</div>
    			
    			<div class="temoignages-infos-container">
    				 	<i class="bi bi-blockquote-left"></i>
    					<div class="temoignage-add">
    						<span>11</span> 
    						<span><a href="/w1-admin/entreprises">Entreprises</a></span>
    					</div>
    			</div>
    			
    		</div>
    	</div>
		
		<?php require_once($_SERVER["DOCUMENT_ROOT"]."/inc/other/admin/js.php"); ?>
	</body>
	
</html>