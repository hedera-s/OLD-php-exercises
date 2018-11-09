<?php
/**********************************************************************************/
			
			
				/***********************************/
				/********** CONFIGURATION **********/
				/***********************************/
				
				// include(Pfad zur Datei): Bei Fehler wird das Skript weiter ausgeführt. Problem mit doppelter Einbindung derselben Datei
				// require(Pfad zur Datei): Bei Fehler wird das Skript gestoppt. Problem mit doppelter Einbindung derselben Datei
				// include_once(Pfad zur Datei): Bei Fehler wird das Skript weiter ausgeführt. Kein Problem mit doppelter Einbindung derselben Datei
				// require_once(Pfad zur Datei): Bei Fehler wird das Skript gestoppt. Kein Problem mit doppelter Einbindung derselben Datei
				require_once("include/config.inc.php");
				require_once("include/form.inc.php");
			
			
/**********************************************************************************/

				
				/*****************************************/
				/********** INITALIZE VARIABLES **********/
				/*****************************************/
				
				$firstname 			= NULL;
				$email 				= NULL;
				$image 				= NULL;
				
				$errorFirstname 	= NULL;
				$errorEmail 		= NULL;
				$errorImage 		= NULL;
				
				$message 			= NULL;


/**********************************************************************************/


				/******************************************/
				/********** FORMULARVERARBEITUNG **********/
				/******************************************/
				
				// Schritt 1 FORM: Prüfen, ob Formular abgeschickt wurden
				if( isset($_POST['formsentUpload']) ) {
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . ":</b> Formular wurde abgeschickt. <i>(" . basename(__FILE__) . ")</i></p>";					
					
					// Schritt 2 FORM: Werte auslesen, entschärfen, DEBUG-Ausgabe
					$firstname = cleanString($_POST['firstname']);
					$email = cleanString($_POST['email']);
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . ":</b> \$firstname: $firstname <i>(" . basename(__FILE__) . ")</i></p>";					
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . ":</b> \$email: $email <i>(" . basename(__FILE__) . ")</i></p>";

					// Schritt 3 FORM: Daten validieren
					$errorFirstname 	= checkInputString($firstname);
					$errorEmail 		= checkEmail($email);

					
					// Bild nur auf den Server laden, wenn es sonst keine Fehler im Formular gibt:
					/********** ABSCHLIESSENDE FORMULARPRÜFUNG TEIL 1 **********/
					if(!$errorFirstname AND !$errorEmail) {
if(DEBUG)			echo "<p class='debug ok'><b>Line " . __LINE__ . ":</b> Pflichtfelder sind korrekt ausgefüllt. <i>(" . basename(__FILE__) . ")</i></p>";						
						
						
						/********** IMAGE UPLOAD **********/
						
						// Prüfen, ob Bild hochgeladen wurde
						if( $_FILES['image']['tmp_name'] ) {
if(DEBUG)				echo "<p class='debug'><b>Line " . __LINE__ . ":</b> Bildupload aktiv... <i>(" . basename(__FILE__) . ")</i></p>";

							// Sicherheitsprüfung Bild
							$imageUploadReturnArray = imageUpload($_FILES['image']);
							
							// Prüfen, ob es einen Fehler gab
							if( $imageUploadReturnArray['imageError'] ) {
								// Fehlerfall
if(DEBUG)					echo "<p class='debug err'><b>Line " . __LINE__ . ":</b> FEHLER beim Bildupload! <i>(" . basename(__FILE__) . ")</i></p>";
								$errorImage = "$imageUploadReturnArray[imageError]";
							} else {
								// Erfolgsfall
if(DEBUG)					echo "<p class='debug ok'><b>Line " . __LINE__ . ":</b> Bildupload ist fehlerfrei. <i>(" . basename(__FILE__) . ")</i></p>";														
							
								// Bildpfad speichern
								$imagePath = $imageUploadReturnArray['imagePath'];
if(DEBUG)					echo "<p class='debug ok'><b>Line " . __LINE__ . ":</b> Bildwurde erfolgreich unter <i>$imageUploadReturnArray[imagePath]</i> gespeichert. <i>(" . basename(__FILE__) . ")</i></p>";
							}
						} // IMAGE UPLOAD ENDE
					
						/*********************************/
					
					
						// Formular nur weiterverarbeiten, wenn auch der Bildupload fehlerfrei ist:
						/********** ABSCHLIESSENDE FORMULARPRÜFUNG TEIL 2 **********/						
						if(!$errorImage) {
							// Erfolgsfall
if(DEBUG)				echo "<p class='debug ok'><b>Line " . __LINE__ . ":</b> Formular ist fehlerfrei und wird nun verarbeitet... <i>(" . basename(__FILE__) . ")</i></p>";						
							
							// Schritt 4 FORM: Daten weiterverarbeiten
							$message = "<h3 class='success'>Vielen Dank, wir haben Ihre Daten erhalten.</h3>";
							
							// Formularfelder leeren
							$firstname = NULL;
							$email = NULL;
							
						} // WEITERVERARBEITUNG ENDE
						
					} // PFLICHTFELDPRÜFUNG ENDE
					
				} // FORMULARVERARBEITUNG ENDE


/**********************************************************************************/
?>

<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>DEBUGGING 2.0</title>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/debug.css">
	</head>

	<body>
	
		<?php
			echo "<p>\$_SERVER[PHP_SELF]: $_SERVER[PHP_SELF]</p>";
			echo "<p>\$_SERVER[REQUEST_URI]: $_SERVER[REQUEST_URI]</p>";
			echo "<p>\$_SERVER[SCRIPT_NAME]: $_SERVER[SCRIPT_NAME]</p>";
		
		?>
		<h1>DEBUGGING 2.0</h1>
		
		<p>
			Diese Seite enthält ein Formular, über das ein Vorname und eine Email-Adresse
			eingegeben werden können, sowie einen optionalen Bildupload.
		</p>
		<p>
			Das Formular soll eine Feldprüfung für die Felder "Vorname" und Email" aufweisen.
		</p>
		<p>
			Nach erfolgreicher Datenübermittlung und Formularprüfung soll eine Rückmeldung
			ausgegeben werden, dass die Daten erfolgreich empfangen wurden.
		</p>
		
		<br>
		<hr>
		<br>
		
		<?= $message ?>
		
		<?php if( isset($imageUploadReturnArray['imagePath']) ): ?>
			<img src="<?= $imageUploadReturnArray['imagePath'] ?>" style="width: 200px"><br>
			<br>	
		<?php endif ?>
		
		<br>
		<hr>
		<br>

		<form action="<?= $_SERVER['SCRIPT_NAME'] ?>" method="POST" enctype="multipart/form-data">
			
			<input type="hidden" name="formsentUpload">
			
			<fieldset>
				<legend>Personal Data</legend>
				<span class="error"><?= $errorFirstname ?></span><br>
				<input type="text" name="firstname" value="<?= $firstname ?>" placeholder="Vorname"><span class="marker">*</span><br>
				<span class="error"><?= $errorEmail ?></span><br>
				<input type="text" name="email" value="<?= $email ?>" placeholder="Email-Adresse"><span class="marker">*</span><br>
			</fieldset>
			
			<fieldset>
				<legend>File Upload</legend>
				<span class="error"><?= $errorImage ?></span><br>
				<input type="file" name="image">
			</fieldset>
			
			<input type="submit" value="Upload">
		</form>
			

















		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		
	</body>

</html>


























