<?php
	/**
	 * JMT
	 * FEVRIER 2021
	 */
	
$i=0; //compteur ligne de tableau

?>
<div class="container-fluid mb-2">
	<div class="row">
		<?php
			if(isset($_SESSION['message'])):?>
				<h3 class="col-lg-12 text-danger text-center"><?= $_SESSION['message']; ?></h3>
		<?php 
			endif;?>
	</div>
	<div class="row">
		
		<!--	TABLE LISTE DES UTILISATEURS -->
		<table  class="col-6 mt-2 align-self-start"id="tableutilisateurs" class="table table-bordered">
					<thead>
						<tr class="bg-info">
							<th>No</th>
							<th>Pseudo</th>
							<th>Nom</th>
							<th>Prenom</th>
							<th>Email</th>
							<th>Inscription</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($utilisateurs as $key => $utilisateur): 
						$dateinscription = new DateTime($utilisateur->getDateinscription());
						$i++;
						
						//surlignement de la ligne concernée
						if ($noutilisateur==$utilisateur->getNoutil()) 
							{
								echo "<tr class='selection'>";
								//récupération des éléments pour le formmulaire utilisateur
								$noutilisateur = $utilisateur->getNoutil();
								$pseudo= $utilisateur->getPseudo();
								$nom= $utilisateur->getNom();
								$prenom= $utilisateur->getPrenom();
								$email= $utilisateur->getEmail();
								$date= $dateinscription->format('j/m/Y');
								$actif = $utilisateur->getActif();
							}
						else { echo "<tr>";}
						?>
							<td><?= $utilisateur->getNoutil(); ?></td>
							<td><?= $utilisateur->getPseudo(); ?></td>
							<td><?= $utilisateur->getNom(); ?></td>
							<td><?= $utilisateur->getPrenom(); ?></td>
							<td><?= $utilisateur->getEmail(); ?></td>
							<td><?= $dateinscription->format('j/m/Y'); ?></td>
						</tr>
						<?php endforeach; ?>
						
					</tbody>
		</table>
		

		<!-- ONGLETS PROFIL ET DROITS -->
		<div class="col-5" style="margin-top: 10px;">

			<!-- ONGLETS -->
			<nav class="nav nav-tabs">
                <a class="nav-item nav-link active" href="#profil" data-toggle="tab">Profil</a>
                <a class="nav-item nav-link" href="#droits" data-toggle="tab">Droits</a>
            </nav>

            <div class="tab-content">

	            <!-- PANNEAU 1 -->
	            <div class="tab-pane active" id="profil">
	                <!-- FORMULAIRE UTILISATEUR -->
					<br>
					<?php include ("pages/divers/forms/form_utilisateur.php"); ?>     
	            </div>

	            <!-- PANNEAU 2 -->
	            <div class="tab-pane" id="droits">
	                <!-- FORMULAIRE UTILISATEUR -->
					<br>
					<?php include ("pages/divers/forms/form_droitsutilisateur.php"); ?>     
	            </div>
	        </div> <!-- tab-content -->
		</div>
	</div>
</div>