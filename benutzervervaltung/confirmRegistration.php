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
				require_once("include/db.inc.php");
		
		
/**********************************************************************************/


				/******************************************/
				/********** SEITENZUGRIFFSSCHUTZ **********/
				/******************************************/
				
				// Bei fehlendem URL-Parameter auf index.php umleiten
				if( !isset($_GET['action']) OR !isset($_GET['hash']) ) {
					DIE("<h3 class='error'>Ungültiger Seitenaufruf!<br>
							<br>
							Bitte stellen Sie sicher, dass Sie den Link aus der Bestätigungsemail korrekt angeklickt haben.</h3>");
				} else {
if(DEBUG)		echo "<p class='debug'>Alle erforderlichen URL-Parameter wurden übergeben - Seitenzugriff erlaubt.</p>";					
				}


/**********************************************************************************/

				
				/**********************************************/
				/********** VARIABLEN INITIALISIEREN **********/
				/**********************************************/
				
				$message = NULL;
				
				
/**********************************************************************************/


				/***********************************************/
				/********** URL-PARAMETERVERARBEITUNG **********/
				/***********************************************/

				// Schritt 1 URL: Prüfen, ob URL-Parameter übergeben wurden
				if( isset($_GET['action']) ) {
if(DEBUG)		echo "<p class='debug'>URL-Parameter 'action' wurde übergeben.</p>";

					// Schritt 2 URL: Werte auslesen, entschärfen, DEBUG-Ausgabe
					$action = cleanString($_GET['action']);
					$regHash = cleanString($_GET['hash']);
if(DEBUG)		echo "<p class='debug'>\$action: $action</p>";
if(DEBUG)		echo "<p class='debug'>\$regHash: $regHash</p>";		

					// Schritt 3 URL: i.d.R. Verzweigen
					
					/********** SICHERHEIT: PRÜFEN AUF GÜLTIGEN WERT FÜR 'action' **********/
					if( $action != "conReg" ) {
						// Fehlerfall
						DIE("<h3 class='error'>Ungültiger Seitenaufruf!<br>
								<br>
								Bitte stellen Sie sicher, dass Sie den Link aus der Bestätigungsemail korrekt angeklickt haben.</h3>");
						
					} else {
						// Erfolgsfall
						
						// Schritt 4 URL: Daten weiterverarbeiten
						
						/********** SICHERHEIT: PRÜFEN, OB HASH AUS URL MIT HASH AUS DB ÜBEREINSTIMMT **********/
						
						// Schritt 1 DB: DB-Verbindung herstellen
						$pdo = dbConnect();
						
						// Schritt 2 DB: SQL-Statement ausführen
						$statement = $pdo->prepare("SELECT acc_id FROM accounts
															WHERE acc_reghash = :ph_acc_reghash");
															
						// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
						$statement->execute( array(
															"ph_acc_reghash" => $regHash
															) ) OR DIE( $statement->errorInfo()[2] );
															
						// Schritt 4 DB: Daten weiterverarbeiten
						$row = $statement->fetch();

						if( !$row ) {
							// Fehlerfall
if(DEBUG)				echo "<p class='debug'>FEHLER: Kein gültiger Hashwert in der DB gefunden!</p>";
							DIE("<h3 class='error'>Ungültiger Seitenaufruf!<br>
									<br>
									Bitte stellen Sie sicher, dass Sie den Link aus der Bestätigungsemail korrekt angeklickt haben.<br>
									Es kann auch sein, dass der Zeitpunkt Ihrer Registrierung länger als 7 Tage zurückliegt.
									In diesem Fall müssen sie die Registrierung erneut vornehmen.</h3>");
							
						} else {
							// Erfolgsfall
if(DEBUG)				echo "<p class='debug'OK: >Hashwert wurde in DB gefunden.</p>";
							$acc_id = $row['acc_id'];

if(DEBUG)				echo "<p class='debug'>Account mit der ID $acc_id wird nun freigeschaltet...</p>";


							/********** ACCOUNT IN DB FREISCHALTEN **********/
					
							// Schritt 2 DB: SQL-Statement ausführen
							// Hash und Timestamp aus DB löschen und Account-Status auf "open" (sta_id = 1) setzen
							$statement = $pdo->prepare("UPDATE accounts
																SET
																acc_reghash = :ph_acc_reghash,
																acc_regtimestamp = :ph_acc_timestamp,
																sta_id = :ph_sta_id
																WHERE acc_id = :ph_acc_id");
																
							// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
							$statement->execute( array(
																"ph_acc_reghash" => NULL,
																"ph_acc_timestamp" => NULL,
																"ph_sta_id" => 1,
																"ph_acc_id" => $acc_id
																) ) OR DIE( $statement->errorInfo()[2] );
							
							// Schritt 4 DB: Daten weiterverarbeiten
							// Schreiberfolg prüfen
							$success = $statement->rowCount();
if(DEBUG)					echo "<p class='debug'>\$success: $success</p>";	

							if( !$success ) {
								// Fehlerfall
if(DEBUG)					echo "<p class='debug'>FEHLER beim Schreiben in die DB!</p>";										
								$message = "<h3 class='error'>Es ist ein Fehler aufgetreten! Bitte versuchen Sie es später noch einmal.</h3>";
							} else {
								// Erfolgsfall
if(DEBUG)					echo "<p class='debug'>OK: Account wurde erfolgreich freigeschaltet.</p>";	
							header("Location: index.php?action=regConfirmed");
							exit;

							} // ACCOUNTDATEN SPEICHERN ENDE
						
						} // ACCOUNT PRÜFEN ENDE

					} // URL-PARAMETER PRÜFEN ENDE 

				} // URL-VERARBEITUNG ENDE

				
/**********************************************************************************/
?>

<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>Benutzerverwaltung - Registrierung bestätigen</title>
		<link rel="stylesheet" href="css/main.css">
	</head>

	<body>
		<h1>Benutzerverwaltung - Registrierung bestätigen</h1>
		<?= $message ?>
		
	</body>

</html>