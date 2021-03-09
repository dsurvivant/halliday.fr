<?php
	/**
	 * JMT
	 * FEVRIER 2021
	 *	
	 * lié au formulaire formutilisateur (form_utilisateur.php)
	 */

?>
 <span class="titre" >Ajouter un album </span>
	<input id="ajoutchoice1" type="radio" form="formutilisateur" name="ajouteralbum" value="1" <?php if($ajouteralbum){echo "checked";} ?>>
	<label for="ajoutChoice1" >Autorisé</label>

	<input id="ajoutchoice2" type="radio" form="formutilisateur" name="ajouteralbum" value="0" <?php if(!$ajouteralbum){echo "checked";} ?>>
	<label for="ajoutChoice2">Interdit</label>
	<br><br>

<span class="titre">Modifier un album</span>
	<input id="modifierchoice1" type="radio" form="formutilisateur" name="modifieralbum" value="1" <?php if($modifieralbum){echo "checked";} ?>>
	<label for="modifierchoice1">Autorisé</label>

	<input id="modifierchoice2" type="radio" form="formutilisateur" name="modifieralbum" value="0" <?php if(!$modifieralbum){echo "checked";} ?>>
	<label for="modifierchoice2">Interdit</label>
	<br><br>

<span class="titre">Supprimer un album</span>
	<input id="supprimerchoice1" type="radio" form="formutilisateur" name="supprimeralbum" value="1" <?php if($supprimeralbum){echo "checked";} ?>>
	<label for="supprimerChoice1">Autorisé</label>

	<input id="supprimerchoice2" type="radio" form="formutilisateur" name="supprimeralbum" value="0" <?php if(!$supprimeralbum){echo "checked";} ?>>
	<label for="supprimerChoice2">Interdit</label>
	<br><br>

<span class="titre">Modifier Infos Titre</span>
	<input id="modiftitrechoice1" type="radio" form="formutilisateur" name="modifierinfostitre" value="1" <?php if($modifierinfostitre){echo "checked";} ?>>
	<label for="modiftitreChoice1">Autorisé</label>

	<input id="modiftitrechoice2" type="radio" form="formutilisateur" name="modifierinfostitre" value="0" <?php if(!$modifierinfostitre){echo "checked";} ?>>
	<label for="modiftitreChoice2">Interdit</label>
	<br><br>

<span class="titre">Modifier Paroles titre</span>
	<input id="modifparoleschoice1" type="radio" form="formutilisateur" name="modifierparolestitre" value="1" <?php if($modifierparolestitre){echo "checked";} ?>>
	<label for="modifparolesChoice1">Autorisé</label>

	<input id="modifparoleschoice2" type="radio" form="formutilisateur" name="modifierparolestitre" value="0" <?php if(!$modifierparolestitre){echo "checked";} ?>>
	<label for="modifparolesChoice2">Interdit</label>
	<br><br>

<span class="titre">Actif</span>
	<input id="actifchoice1" type="radio" form="formutilisateur" name="actif" value="1" <?php if($actif){echo "checked";} ?>>
	<label for="actifChoice1">Oui</label>

	<input id="actifchoice2" type="radio" form="formutilisateur" name="actif" value="0" <?php if(!$actif){echo "checked";} ?>>
	<label for="actifChoice2">Non</label>
