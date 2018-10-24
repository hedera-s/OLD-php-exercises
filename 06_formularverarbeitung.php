<?php
/**********************************************************************************************/	
			/********************************/
			/******** CONFIGURATION *********/
			/********************************/
			
			
			
			/********* INCLUDES *************/
			
			// include(Pfad zur Datei): Bei Fehler wird das Skript weiter ausgeführt. Problem mit doppelter Einbindung derselben Datei
			// require(Pfad zur Datei): Bei Fehler wird das Skript gestoppt. Problem mit doppelter Einbindung derselben Datei
			// include_once(Pfad zur Datei): Bei Fehler wird das Skript weiter ausgeführt. Kein Problem mit doppelter Einbindung derselben Datei
			// require_once(Pfad zur Datei): Bei Fehler wird das Skript gestoppt. Kein Problem mit doppelter Einbindung derselben Datei
			require_once("include/config.inc.php");
			require_once("include/form.inc.php");
			
			
/**********************************************************************************************/	
			
			/********************************************/
			/*********** INITIALIZE VARIABLES ***********/
			/********************************************/
			
			$monthArray = array("01"=>"Januar", 
								"02"=>"Februar", 
								"03"=>"März", 
								"04"=>"April", 
								"05"=>"Mai", 
								"06"=>"Juni", 
								"07"=>"Juli", 
								"08"=>"August", 
								"09"=>"September", 
								"10"=>"Oktober", 
								"11"=>"November", 
								"12"=>"Dezember");
								
			$errorFirstname = NULL;
			$errorLastname 	= NULL;
			$errorEmail 	= NULL;
			$errorMessage	= NULL;
			
			$title 			= NULL;
			$gender 		= NULL;
			$firstname 		= NULL;
			$lastname 		= NULL;
			$email 			= NULL;
			$day 			= NULL;
			$month 			= NULL;
			$year 			= NULL;
			$message 		= NULL;
			$hobbiesArray	= NULL;
			
			
			$successMessage = NULL;
		
			
			

					
/**********************************************************************************************/	
			
			/***************************************/
			/********* FORM VERARBEITUNG ***********/
			/***************************************/
			
			// Schritt 1 FORM: Prüfen, ob Formular abgeschickt wurde
			
			if(isset($_POST['formsent'])){
if(DEBUG)	echo "<p class='debug'>Formular wurde Abgeschickt</p>";		

if(DEBUG)	echo "<pre class='debug'>";
if(DEBUG)	print_r($_POST);
if(DEBUG)	echo "</pre>";
			
			// WICHTIG: Alle weiteren Schritte, die mit der Verarbeitung
			// der Formulardaten zu tun haben, finden ausschließlich
			// INNERHALB dieses isset()-Blockes statt
	
			// Schritt 2 FORM: Werte auslesen, entschärfen
						
			$title 		= cleanString($_POST['title']);
			$gender 	= cleanString($_POST['gender']);
			$firstname 	= cleanString($_POST['firstname']);
			$lastname 	= cleanString($_POST['lastname']);
			$email 		= cleanString($_POST['email']);
			$day 		= cleanString($_POST['day']);
			$month 		= cleanString($_POST['month']);
			$year 		= cleanString($_POST['year']);
			$message 	= cleanString($_POST['message']);
			
if(DEBUG)	echo "<p class='debug'>title: $title</p>";	
if(DEBUG)	echo "<p class='debug'>gender: $gender</p>";	
if(DEBUG)	echo "<p class='debug'>firstname: $firstname</p>";	
if(DEBUG)	echo "<p class='debug'>lastname: $lastname</p>";	
if(DEBUG)	echo "<p class='debug'>email: $email</p>";	
if(DEBUG)	echo "<p class='debug'>day: $day</p>";	
if(DEBUG)	echo "<p class='debug'>month: $month</p>";	
if(DEBUG)	echo "<p class='debug'>year: $year</p>";	
if(DEBUG)	echo "<p class='debug'>message: $message</p>";	

			// ARRAY CHECHBOXEN AUSLESEN
			if(isset($_POST['hobbies'])){
				$hobbiesArray = $_POST['hobbies'];
if(DEBUG)		echo "<pre class='debug'>";
if(DEBUG)		print_r($hobbiesArray);
if(DEBUG)		echo "</pre>";
			}


			// Schritt 3 FORM:Werte Validieren
			// 1. Fehlermeldungen erzeugen und ausgeben
			// 2. Formularfelder vorbelegen
			// 3. Abschließende Formulaprüfung
			$errorFirstname 	= checkInputString($firstname);
			$errorLastname 		= checkInputString($lastname);
			$errorEmail 		= checkEmail($email);
			$errorMessage 		= checkInputString($message, 10, 1000);
			
			// WICHTIG: Ist das Formular Fehlerfrei?
			if(!$errorFirstname && !$errorLastname && !$errorEmail && !$errorMessage){
if(DEBUG)		echo "<p class='debug ok'>Das Formular ist Fehlerfrei</p>";	
				
				// Schritt 4 FORM: Daten weiterverarbeiten
				$successMessage = "<h3 class = 'success'>Vielen Dank, wir haben Ihre Daten erhalten.</h3>";
				// Zum Schluss die Formularfelder leeren
				$title 		= NULL;
				$gender 	= NULL;
				$firstname 	= NULL;
				$lastname 	= NULL;
				$email 		= NULL;
				$day 		= NULL;
				$month 		= NULL;
				$year 		= NULL;
				$message 	= NULL;
				
			} else {
if(DEBUG)		echo "<p class='debug err'>Das Formular enthält noch Fehler</p>";					
				}
			
			
			}



/**********************************************************************************************/	
?>
<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>Formularverarbeitung</title>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/debug.css">
		<style>
			* { margin: 0; padding: 0; }
			body { padding: 50px; font-family: arial; font-size: 11px; background-color: lavender}
			h1, h2 { margin: 10px; 50px; }
			h2 { color: green; }

			input, textarea, select, label { margin: 10px; padding: 3px; width: 300px; border-radius: 5px; }
			label { font-size: 1.3em; }
			select { width: 235px; }
			select#day { width: 70px; }
			select#month { width: 115px; }
			select#year { width: 80px; }
			input[type="radio"], input[type="checkbox"] { width: 20px; margin: 10px 6px; }
			input[type="submit"] { width: 310px }
			textarea { float: left; font-size: 1.1em;}

			.marker { font-size: 1.6em; font-weight: bold;}
			.clearer { clear: both; }
			/* Den Placeholder-Font selbst bestimmen: */
			::-webkit-input-placeholder { font-family: verdana; }
			:-moz-placeholder { font-family: verdana; }
			::-moz-placeholder { font-family: verdana; }
			:-ms-input-placeholder { font-family: verdana; }
		</style>
		
	</head>

	<body>
	
		<h1>Formularverarbeitung</h1>
		
		<?php echo $successMessage ?>

		<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
			
			<input type="hidden" name="formsent">
			
			<label>Anrede:</label>
			<select name="title">
				<option value="mr" 		<?php if($title == "mr") echo "selected" ?>>Herr</option>
				<option value="mrs" 	<?php if($title == "mrs") echo "selected" ?>>Frau</option>
				<option value="other" 	<?php if($title == "other") echo "selected" ?>>Sonstiges</option>
			</select>
			
			<br>
			<br>
			<br>
			
			<label>Geschlecht:</label>
			<input type="radio" name="gender" value="male" <?php if($gender == NULL || $gender == "male") echo "checked" ?>>männlich
			<input type="radio" name="gender" value="female" <?php if($gender == "female") echo "checked" ?>>weiblich
			<input type="radio" name="gender" value="other" <?php if($gender == "other") echo "checked" ?>>sonstiges
			
			<br>
			<br>
			
			<span class="error"><?php echo $errorFirstname ?></span><br>
			<input type="text" name="firstname" value="<?php echo $firstname ?>" placeholder="Vorname"><span class="marker">*</span>
			<br>
			<br>
			<span class="error"><?php echo $errorLastname ?></span><br>
			<input type="text" name="lastname" value="<?php echo $lastname ?>" placeholder="Nachname"><span class="marker">*</span>
			<br>
			<br>
			<span class="error"><?php echo $errorEmail ?></span><br>
			<input type="text" name="email"  value="<?php echo $email ?>" placeholder="Email"><span class="marker">*</span>
			<br>
			<br>		
			
			<label>Geburtsdatum:</label><br>
			<select id="day" name="day">
				<!--<option value="1" selected>1</option> -->
				<?php 
				
					for($i=1; $i<=31; $i++){
						// $i mit führender 0 auffüllen
						// sprintf() gibt einen vorformatierten String zurück
						// Erster Parameter:
						// % = Steuerzeichen (hier soll aufgefüllt werden); 0 = Zeichen, mit dem aufgefüllt werden soll
						// 2 = Anzahl der Zeichen, bis zu der aufgefüllt werden soll
						// d = Wert aus Parameter 2 wird als Integer angesehen und als Dezimalwert ausgegeben
						// Zweiter Parameter:
						// String, der umformatiert werden soll
						$i = sprintf("%02d", $i);
						if($i == $day){
							echo "\t\t\t\t<option value='$i' selected>$i</option>\r\n";
						} else {
							echo "\t\t\t\t<option value='$i'>$i</option>\r\n";
						}

					}
				?>
			</select>
			<select id="month" name="month">
				<!-- <option value="1">Januar</option> -->
				<?php 
					foreach($monthArray AS $key=>$value){
						if($key == $month){
							echo "\t\t\t\t<option value='$key' selected>$value</option>\r\n";
						} else {
							echo "\t\t\t\t<option value='$key'>$value</option>\r\n";
						}
						
					}
				
				?>
				
			</select>
			<select id="year" name="year">
				<!--<option value="2018">2018</option>-->
				<?php 
					$currentYear = date("Y");
					for($i=$currentYear; $i>=1900; $i--){
						if($i == $year){
							echo "\t\t\t\t<option value='$i' selected>$i</option>\r\n";
						} else {
							echo "\t\t\t\t<option value='$i'>$i</option>\r\n";
						}
					}
				?>
			</select>
			
			<br>
			<br>
			
			<span class="error"><?php echo $errorMessage ?></span><br>
			<textarea class="fleft" name="message" placeholder="Ihre Nachricht an uns..."><?php echo $message ?></textarea><span class="marker">*</span>
			<div class="clearer"></div>
			<br>
			
			<label>Hobbies:</label>
			<input type="checkbox" name="hobbies[reading]" value="1" <?php if(isset($hobbiesArray['reading'])) echo "checked" ?>>Lesen
			<input type="checkbox" name="hobbies[animals]" value="1" <?php if(isset($hobbiesArray['animals'])) echo "checked" ?>>Tiere
			<input type="checkbox" name="hobbies[sleeping]" value="1" <?php if(isset($hobbiesArray['sleeping'])) echo "checked" ?>>Schlafen
			
			<br>
			<br>
			
			<input type="submit" value="Absenden">
		
		</form>
	</body>

</html>