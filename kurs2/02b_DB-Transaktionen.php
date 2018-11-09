<?php
/*************************************************************************************/


				/***********************************/
				/********** CONFIGURATION **********/
				/***********************************/

				/********** INCLUDES **********/
				// include(Pfad zur Datei): Bei Fehler wird das Skript weiter ausgeführt. Problem mit doppelter Einbindung derselben Datei
				// require(Pfad zur Datei): Bei Fehler wird das Skript gestoppt. Problem mit doppelter Einbindung derselben Datei
				// include_once(Pfad zur Datei): Bei Fehler wird das Skript weiter ausgeführt. Kein Problem mit doppelter Einbindung derselben Datei
				// require_once(Pfad zur Datei): Bei Fehler wird das Skript gestoppt. Kein Problem mit doppelter Einbindung derselben Datei
				require_once("include/config.inc.php");
				require_once("include/db.inc.php");


/*************************************************************************************/
				/**********************************************/
				/********** VARIABLEN INITIALISIEREN **********/
				/**********************************************/

				$dbErrorUser = false;
				$dbErrorAccount = false;

				$dbMessage = NULL;


/*************************************************************************************/


				/************************************/
				/********** DB-OPERATIONEN **********/
				/************************************/

				// Schritt 1 DB: DB-Verbindung herstellen
				$pdo = dbConnect("miniforum");

				/******* Transaction Starten ********/
				
				if(!$pdo->beginTransaction()){
					// Fehlerfall
if(DEBUG)			echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: FEHLER: Fehler beim Starten dee Transaction <i>(" . basename(__FILE__) . ")</i></p>";					
					
				}else{
					//Erfolgsfall
if(DEBUG)			echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Transaction erfolgreich gestartet <i>(" . basename(__FILE__) . ")</i></p>";
					
					/********** 1. NEUEN USER ANLEGEN **********/

					// Schritt 2 DB: SQL-Statement vorbereiten
					$statement = $pdo->prepare("INSERT INTO users
												(usr_firstname, usr_lastname, usr_email, usr_city)
												VALUES
												(?,?,?,?)
												");

					// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
					// WICHTIG: KEIN od Die()..., da ansonsten beim Fehler das Skript an 
					// dieser Stelle komplett abgebrochen wird und die Transaction somit
					// nie zuende geführt werden kann
					$statement->execute( array(
					"Paula",
					"Paulsen",
					"paula@paulsen.net",
					"Pichelsdorf"
					) );

					// Schritt 4 DB: Daten weiterverarbeiten
					$newUserId = $pdo->lastInsertId();
if(DEBUG) 			echo "<p class='debug'>Zeile " . __LINE__ . ": \$newUserId: $newUserId</p>";
						
					// Beim Einsatz von Transactions muss der zweite Schreibvorgang nicht mehr
					// zwingend vom Erfolg des ersten Schreibvorgangs abhängig sein	
					
					// Fehlerflag für späteren Commit/Rollback setzen
					// Wenn $newUserId false ist, wird die Error-Variable true. Ansonsten false.
					
					$dbErrorUser = !$newUserId ? true : false;
if(DEBUG) 			echo "<p class='debug'>Zeile " . __LINE__ . ": \$dbErrorUser: $dbErrorUser</p>";	

					/********** 2. NEUEN ACCOUNT ANLEGEN **********/

					// Schritt 2 DB: SQL-Statement vorbereiten
					$statement = $pdo->prepare("INSERT INTO accounts
												(acc_name, acc_password, usr_id)
												VALUES
												(?, ?, ?)
												");

					// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
					$statement->execute( array(
												"paula01",
												"1234",
												$newUserId
												) );

					// Schritt 4 DB: Daten weiterverarbeiten
					
					// Anzahl der betroffenen Datensätze auslesen
					// WICHTIG: lastInsertId() würde hier im Zweifelsfall die ID des Users zurückliefern,
					// daher ist die lastInsertid an dieser Stelle zur Prüfung ungeeignet!
					
					$accountEntry = $statement->rowCount();
if(DEBUG) 			echo "<p class='debug'>Zeile " . __LINE__ . ": \$accountEntry: $accountEntry</p>";					
					
					// Fehlerflag für späteren Commit/Rollback setzen
					// Wenn $accountEntry false ist, wird die Error-Variable true. Ansonsten false.
					$dbErrorAccount = !$accountEntry ? true : false;
if(DEBUG) 			echo "<p class='debug'>Zeile " . __LINE__ . ": \$dbErrorAccount: $dbErrorAccount</p>";			

					/****** Schreiberfolg anhand der Fehlerflags prüfen ******/
					
					if($dbErrorUser || $dbErrorAccount){
						//Fehlerfall Schreibvorgang
if(DEBUG) 				echo "<p class='debug err'>Zeile " . __LINE__ . ": FEHLER beim Schreiben in die DB!</p>"; 
						$dbMessage = "<p class='error'>Es ist ein Fehler aufgetreten! Bitte versuchen Sie es später noch einmal.</p>";		
						
						/********* ROLLBACK DURCHFÜHREN *********/
						if($pdo->rollback()){
							// Erfolgsfall
if(DEBUG)					echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Rollback erfolgreich durchgeführt <i>(" . basename(__FILE__) . ")</i></p>";							
						}else{
							//Fehlerfall
if(DEBUG)					echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: Fehler bein durchführen des Rollbacks <i>(" . basename(__FILE__) . ")</i></p>";							
						}

					
					}else{
						//Erfolgsfall Schreibvorgang
						
						/*********** Commit durchführen **********/
						if($pdo->commit()){
							//Erfolgsfall
if(DEBUG)					echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Commit erfolgreich durchgeführt <i>(" . basename(__FILE__) . ")</i></p>";										
							$dbMessage = "<p class='success'>Ihre Registrierung war erfolgreich :)</p>";
						}else{
							//Fehlerfall
if(DEBUG)					echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: Fehler bein durchführen des Commits <i>(" . basename(__FILE__) . ")</i></p>";	
							$dbMessage = "<p class='error'>Es ist ein Fehler aufgetreten! Bitte versuchen Sie es später noch einmal.</p>";
						}
						
						
						
					}
					
					
				
				}

/*************************************************************************************/
?>

<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>DB-Transaktionen</title>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/debug.css">
	</head>

	<body>
		<h1>DB-Transaktionen</h1>
		<p>
			Standardmäßig befindet sich die MySQL-Datenbank im sog. autocommit-Modus, d.h. dass 
			alle Änderungen an den Datensätzen automatisch ausgeführt werden. Der Befehl $pdo->beginTransaction()
			setzt diesen Zustand aus, solange bis mittels $pdo->commit() die Daten "per Hand" gespeichert werden.<br>
			<br>
			Anschließend befindet sich die Datenbank wieder im autocommit-Modus.
		</p>
		<p>
			Die Feldprüfungen für Email und Accountname werden nun von der DB übernommen. 
			Dazu müssen beide Felder in der DB auf "unique" gesetzt werden.
		</p>
		<p>
			Schlägt nun einer der folgenden INSERTs fehl, wird ein komplettes Rollback der 
			Datensätze vorgenommen, d.h. beide Tabellen werden in ihren Ursprungszustand zurückversetzt.
		</p>
		<?=$dbMessage?>
		
	</body>

</html>