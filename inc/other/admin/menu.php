<?php
namespace inc\other\admin;

use manager\ContactManager;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/ContactManager.php");

session_start();

$contactManager = new ContactManager();

?>
<!--  <header>-->
	<div class="sidebar">
		<div class="logo-content">
			<div class="logo">
				<h2><a href="/">SONET-CI</a></h2>
			</div>
			<i class='bx bx-menu' id="btn-menu"></i>
		</div>
		<nav>
			<ul class="nav_list">
				<li>
					<a href="/wps-admin/tableau-de-bord">
						<i class='bx bx-grid-alt'></i>
						<span class="link-name">Tableau de bord</span>
					</a>
					<span class=tooltip-content>Tableau de bord</span>
				</li>
				
				<li>
					<a href="/wps-admin/administrateurs">
						<i class='bx bx-street-view'></i>
						<span class="link-name">Administrateurs</span>
					</a>
					<span class="tooltip-content">Administrateurs</span> 
				</li>
				
				<li>
					<a href="/wps-admin/projets">
						<i class='bx bxs-buildings'></i>
						<span class="link-name">Projets</span>
					</a>
					<span class="tooltip-content">Projets</span> 
				</li>
				
				<li>
					<a href="/wps-admin/partenaires">
						<i class='bx bi-people-fill' ></i>
						<span class="link-name">Partenaires</span>
					</a>
					<span class="tooltip-content">Partenaires</span> 
				</li>
				
				<li>
					<a href="/wps-admin/contacts">
						<i class='bx bx-mail-send' ></i>
						<?php if($contactManager->isNotView()){?>
    						<span class="menu-not-view" 
    						style="display: block;height: 10px;width: 10px;background-color: red;position: absolute;margin-top: -15px;margin-left: 15px; border-radius: 50%;" ></span>
						<?php }?>
						<span class="link-name">Contactez-nous</span>
					</a>
					<span class="tooltip-content">Contactez-nous</span> 
				</li>
				
				
				
			</ul>
		</nav>

		<div class="log-out-container">
			<a href="/compte/deconnexion/<?= $_SESSION["utilisateur"]->getId() ?>" title="Deconnexion"><span>Deconnexion</span> <i class='bx bx-log-out' id="log-out"></i></a>
		</div>

	</div>
<!-- </header> -->