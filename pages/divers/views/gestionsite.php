<?php
	/**
	 * JMT
	 * FEVRIER 2021
	 */
	
$i=0; //compteur ligne de tableau

?>
<div class="container">
	<div class="row">
		<?php
			if(isset($_SESSION['message'])):?>
				<h3 class="col-lg-12 text-danger text-center"><?= $_SESSION['message']; ?></h3>
		<?php 
			endif;?>
	</div>
	<div class="row">
		
		<!--	TABLE LISTE DES UTILISATEURS -->
		<div class="col-lg-7" style="margin-top: 10px;">
			<table id="tableutilisateurs" class="table table-bordered">
					<thead>
						<tr class="bg-info">
							<th>No</th>
							<th>Pseudo</th>
							<th>Nom</th>
							<th>Prenom</th>
							<th>Email</th>
							<th>Inscrit depuis</th>
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
		</div>

		
		<div class="col-lg-5" style="margin-top: 10px;">

			<!-- ONGLETS -->
			<ul class="nav nav-pills nav-justified">
                <li class="active"><a href="#profil" data-toggle="tab">Profil</a></li>
                <li><a href="#droits" data-toggle="tab">Droits</a></li>
            </ul>

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





<!--
					<div class="container">
					<div class="btn-group btn-group-toggle" data-toggle="buttons">
					  <label class="btn btn-info active">
					    <input type="radio" checked >On
					  </label>
					  <label class="btn" style="border: 1px solid;">
					    <input type="radio">Off
					  </label>
					</div>
					</div>
				-->