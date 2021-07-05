<?php
	/**
	 * JMT
	 * FEVRIER 2021
	 *	
	 * indépendant du formulaire formutilisateur (form_utilisateur.php)
	 * Les changements de droits sont gérés en temps réel (ajax)
	 */

?>
 	
 	<div class="container-fluid">
 		
 		<div class="row">
		 	<div class="col-5 bg-info text-white text-center mr-3 py-1 px-2" >Ajouter un album </div>
		 	<div class="choix1 <?php if(!$ajouteralbum){ echo "pointeur"; } ?> rounded-left border py-1 px-3 <?php if($ajouteralbum){ echo "bg-success text-white" ;} ?>">
				<div class="addalbum">Autorisé</div>
			</div>
			<div class="choix2 <?php if($ajouteralbum){ echo "pointeur"; } ?> rounded-right border py-1 px-3 <?php if(!$ajouteralbum){ echo "bg-success text-white" ;} ?>">
				<div class="addalbum">Interdit</div>
			</div>
		</div>
		<br>
		<div class="row">
		 	<div class="col-5 bg-info text-white text-center mr-3 py-1 px-2" >Modifier un album </div>
		 	<div class="choix1 <?php if(!$modifieralbum){ echo "pointeur" ;} ?> rounded-left border py-1 px-3 <?php if($modifieralbum){ echo "bg-success text-white" ;} ?>">
				<div class="updatealbum" >Autorisé</div>
			</div>
			<div class="choix2 <?php if($modifieralbum){ echo "pointeur" ;} ?> rounded-right border py-1 px-3 <?php if(!$modifieralbum){ echo "bg-success text-white" ;} ?>">
				<div class="updatealbum" >Interdit</div>
			</div>
		</div>
		<br>
		<div class="row">
		 	<div class="col-5 bg-info text-white text-center mr-3 py-1 px-2" >Supprimer un album </div>
		 	<div class="choix1 <?php if(!$supprimeralbum) echo "pointeur" ?> rounded-left border py-1 px-3 <?php if($supprimeralbum){ echo "bg-success text-white" ;} ?>">
				<div class="deletealbum" >Autorisé</div>
			</div>
			<div class="choix2 <?php if($supprimeralbum) echo "pointeur" ?> rounded-right border py-1 px-3 <?php if(!$supprimeralbum){ echo "bg-success text-white" ;} ?>">
				<div class="deletealbum" >Interdit</div>
			</div>
		</div>
		<br>
		<div class="row">
		 	<div class="col-5 bg-info text-white text-center mr-3 py-1 px-2" >Modifier Infos Titre </div>
		 	<div class="choix1 <?php if(!$modifierinfostitre){ echo "pointeur" ;} ?> rounded-left border py-1 px-3 <?php if($modifierinfostitre){ echo "bg-success text-white" ;} ?>">
				<div class="updatetitres" >Autorisé</div>
			</div>
			<div class="choix2 <?php if($modifierinfostitre){ echo "pointeur" ;} ?> rounded-right border py-1 px-3 <?php if(!$modifierinfostitre){ echo "bg-success text-white" ;} ?>">
				<div class="updatetitres" >Interdit</div>
			</div>
		</div>
		<br>
		<div class="row">
		 	<div class="col-5 bg-info text-white text-center mr-3 py-1 px-2" >Modifier Paroles titre </div>
		 	<div class="choix1 <?php if(!$modifierparolestitre){ echo "pointeur" ;} ?> rounded-left border py-1 px-3 <?php if($modifierparolestitre){ echo "bg-success text-white" ;} ?>">
				<div class="updateparoles" >Autorisé</div>
			</div>
			<div class="choix2 <?php if($modifierparolestitre){ echo "pointeur" ;} ?> rounded-right border py-1 px-3 <?php if(!$modifierparolestitre){ echo "bg-success text-white" ;} ?>">
				<div class="updateparoles" >Interdit</div>
			</div>
		</div>
		<br>
		<div class="row">
		 	<div class="col-5 bg-info text-white text-center mr-3 py-1 px-2" >Actif </div>
		 	<div class="choix1 <?php if(!$actif){ echo "pointeur" ;} ?> rounded-left border py-1 px-3 <?php if($actif){ echo "bg-success text-white" ;} ?>">
				<div class="actif" >Oui</div>
			</div>
			<div class="choix2 <?php if($actif){ echo "pointeur" ;} ?> rounded-right border py-1 px-3 <?php if(!$actif){ echo "bg-success text-white" ;} ?>">
				<div class="actif" >Non</div>
			</div>
		</div>
		<br>
		<div class="row">
		 	<div class="col-5 bg-info text-white text-center mr-3 py-1 px-2" >Administrateur </div>
		 	<div class="choix1 <?php if(!$administrateur){ echo "pointeur" ;} ?> rounded-left border py-1 px-3 <?php if($administrateur){ echo "bg-success text-white" ;} ?>">
				<div class="administrateur" >Oui</div>
			</div>
			<div class="choix2 <?php if($administrateur){ echo "pointeur" ;} ?> rounded-right border py-1 px-3 <?php if(!$administrateur){ echo "bg-success text-white" ;} ?>">
				<div class="administrateur" >Non</div>
			</div>
		</div>

	</div> <!-- container fluid -->


