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
					require_once("include/db.inc.php");
					
					
/**********************************************************************************************/	
?>
<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>Schreiben in Mehreren Tabellen</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="css/debug.css">
	</head>

	<body>
		<h1>Schreiben in mehrere Tabellen</h1>
		
		<p>Einen neuen User mit einem neuen Account anlegen</p>
		
		<?php
			//Userdaten
			$firstname 	= "Paul";
			$lastname 	= "Paulsen";
			$email 		= "paul@paulsen.de";
			$city 		= "Beilefeld";
			
			//Accountdaten
			$accountname 	= "paule007";
			$passwort 		= "1234";
			
			// Passwort verschlüsseln
			
			$password_hash = password_hash($passwort, PASSWORD_DEFAULT);
			
			/**************** DB-Operation ****************/
			
			//1. DB: DB-Verbindung herstellen
			$pdo = dbconnect("miniforum");
			
			/************* ZUERST USER ANLEGEN ************/
			//2. DB: SQL-Statement vorbereiten
			
			$statement = $pdo->prepare("INSERT INTO users
										(usr_firstname, usr_lastname, usr_email, usr_city)
										VALUES
										(:ph_usr_firstname, :ph_usr_lastname, :ph_usr_email, :ph_usr_city)
										");
			
			//3. DB: SQL-Statement ausführen und ggf. Platzhalter mit Werten füllen
			$statement->execute(array (
										"ph_usr_firstname" =>	$firstname,
										"ph_usr_lastname" => $lastname, 
										"ph_usr_email" => $email, 
										"ph_usr_city" => $city
										)) OR DIE( $statement->errorInfo()[2] );
										
			//4. DB: Weiterverarbeitung
			//Bei INSERT die vergebene ID auslesen
			$newUserId = $pdo->lastInsertId();
if(DEBUG) 	echo "<p class='debug'>\$newUserId: $newUserId</p>";
			
			//Prüfen, ob Schreibvorgang erfolgreich war
			if(!$newUserId){
				//Fehlerfall
if(DEBUG) 		echo "<p class='debug err'>Fehler beim Speichern des neuen Users</p>";	
				$bdMessage = "<h3 class='error'>Es ist ein Fehler aufgetreten. Versuchen Sie es später noch einmal.</h3>";
			}else{
				//erfolgsfall
if(DEBUG) 		echo "<p class='debug ok'>Neuer User erfolgreich mit der ID $newUserId angelegt.</p>";
				
				/*********** DANACH ACCOUNT ANLEGEN **************/
				
				/**************** DB-Operation ****************/
				
				//1. DB: DB-Verbindung herstellen
			
			
				/************* ZUERST USER ANLEGEN ************/
				//2. DB: SQL-Statement vorbereiten
				$statement = $pdo->prepare("INSERT INTO accounts 
											(acc_name, acc_password, usr_id)
											VALUES
											(:ph_acc_name, :ph_acc_password, :ph_usr_id)");
				
				//3. DB: SQL-Statement ausführen und ggf. Platzhalter mit Werten füllen
				$statement->execute( array(
											"ph_acc_name" => $accountname, 
											"ph_acc_password" => $password_hash, 
											"ph_usr_id" => $newUserId
										)) OR DIE( $statement->errorInfo()[2] );
				
				// 4.DB: Daten weiterverarbeiten
				//Bei INSERT die vergebene ID auslesen
				$newAccountId = $pdo->lastInsertId();
if(DEBUG) 		echo "<p class='debug'>\$newAccountId: $newAccountId</p>";
			
				//Prüfen, ob Schreibvorgang erfolgreich war
				if(!$newAccountId){
				//Fehlerfall
if(DEBUG) 			echo "<p class='debug err'>Fehler beim Speichern des neuen Accounts</p>";	

					/********** DB BEREINIGEN **********/
					// verweisten User-Datensatz wieder löschen

					// Schritt 2 DB: SQL-Statement vorbereiten
					$statement = $pdo->prepare("DELETE FROM users
					WHERE usr_id = :ph_usr_id");

					// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
					$statement->execute( array(
					"ph_usr_id" => $newUserId
					) ) OR DIE( $statement->errorInfo()[2] );

					// Schritt 4 DB: Daten weiterverarbeiten
					//Bei DELETE Anzahl der betrofenen Datensätze prüfen
					$deleteSuccess = $statement->rowCount();
if(DEBUG) 			echo "<p class='debug'>deleteSuccess: $deleteSuccess</p>"; 					

					if( $deleteSuccess ) {
					// Erfolgsfall
if(DEBUG) 			echo "<p class='debug'>Userdatensatz mit der ID $newUserId wurde erfolgreich gelöscht.</p>"; 
					} else {
					// Fehlerfall
if(DEBUG) 			echo "<p class='debug'>FEHLER beim Löschen des Userdatensatzes mit der ID $newUserId!</p>"; 
					// TODO für die Zukunft
					// Errorlog schreiben
					// Email an den Admin senden -> Datensatz wird vom Admin per Hand gelöscht
					}

					$dbMessage = "<h3 class='error'>Es ist ein Fehler aufgetreten. Versuchen Sie es später noch einmal.</h3>";
					
					
					
				}else{
					//erfolgsfall
if(DEBUG) 			echo "<p class='debug ok'>Neuer Account erfolgreich mit der ID $newAccountId angelegt.</p>";
					$dbMessage = "<h3 class='success'>Vielen Dank, Sie wurden erfolgreich registriert</h3>";
				
				}
			
			}
			
			
			
			
		?>

		<?php echo $dbMessage ?>

</body>

</html>