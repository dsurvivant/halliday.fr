<?php
//
//michemuche62
//made in rock'n'roll
	//** page servant à faite des test en mode production
?>
<form method="post" action="test.php">

	<label for="texte">Texte:</label>
	<input type="text" name="texte">

	<input type="submit" name="valider">
</form> 

<?php
	if(isset($_POST['texte']))
	{
		$caractères_interdit = array ("<",">",":","/","\\","|","?","*","\"");
		$string = $_POST['texte'];
		$string = str_replace($caractères_interdit, '', $string);
		echo $string;
	}
?>