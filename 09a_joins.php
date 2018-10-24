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
					require_once("include/datetime.inc.php");
					
					
/**********************************************************************************************/	
?>
<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>JOINs – Oder die Kunst, mehrere Tabellen abzufragen</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="css/debug.css">
	</head>

	<body>
		<h1>JOINs – Oder die Kunst, mehrere Tabellen abzufragen</h1>

		<p>
			Ausgangssituation: Es gibt 3 Tabellen in der Datenbank "miniforum"
			(users, accounts, postings). Diese Tabellen sind über einen
			Fremdschlüssel wie in einer Eimerkette miteinander verbunden:<br>
			<br>
			postings -> accounts -> users<br>
			<br>
			Als Fremdschlüssel dienen die jeweiligen IDs der in den Tabellen 
			enthaltenen Datensätze:
		</p>
		<ul>
			<li>Die Datensätze in der Tabelle postings enthalten als Fremdschlüssel 
			jeweils die ID desjenigen Accounts, der das Posting verfasst hat.</li>
			<li>Die Datensätze in der Tabelle Accounts enthalten als Fremdschlüssel 
			die ID desjenigen Users, zu dem der Account gehört.</li>
		</ul>

		<h2>Inhalte der einzelnen Tabellen anzeigen</h2>
		
		<br>
		<hr>
		<br>
		
		<h4>Tabelle users</h4>
		
		<?php 
			/************* DATENBANKOPERATION ***************/
			
			//1. DB: DB-Verbindung erstellen
			$pdo = dbConnect("miniforum");
			
			//2. DB: SQL-Statement vorbereiten
			$statement = $pdo->prepare("SELECT * FROM users");
			
			//3. DB: SQL-ausführen und ggf. Platzhalter füllen
			$statement->execute() OR DIE( $statement->errorInfo()[2] );
			
			//4. DB: Daten weiterverarbeiten
			while($row = $statement->fetch(PDO::FETCH_ASSOC)){
				echo "<p>
						$row[usr_id] - $row[usr_firstname] $$row[usr_lastname] ($row[usr_email]) - $row[usr_city]<br>
						Mitglied seit $row[usr_registerdate]
					</p>";
			}
			
			
		?>
		
		<h4>Tabelle accounts</h4>
		<?php 
			/************* DATENBANKOPERATION ***************/
			
			//1. DB: DB-Verbindung erstellen
		
			
			//2. DB: SQL-Statement vorbereiten
			$statement = $pdo->prepare("SELECT * FROM accounts");
			
			//3. DB: SQL-ausführen und ggf. Platzhalter füllen
			$statement->execute() OR DIE( $statement->errorInfo()[2] );
			
			//4. DB: Daten weiterverarbeiten
			while($row = $statement->fetch(PDO::FETCH_ASSOC)){
				echo "<p>
						$row[acc_id]. $row[acc_name] $row[acc_password], user ID: $row[usr_id]<br>
					</p>";
			}
			
		
		?>
		
		
		<h4>Tabelle postings</h4>
		<?php 
			/************* DATENBANKOPERATION ***************/
			
			//1. DB: DB-Verbindung erstellen
			
			
			//2. DB: SQL-Statement vorbereiten
			$statement = $pdo->prepare("SELECT * FROM postings");
			
			//3. DB: SQL-ausführen und ggf. Platzhalter füllen
			$statement->execute() OR DIE( $statement->errorInfo()[2] );
			
			//4. DB: Daten weiterverarbeiten
			while($row = $statement->fetch(PDO::FETCH_ASSOC)){
				echo "<p>
						$row[pos_id]. <b>User Nr: $row[acc_id] schrieb am $row[pos_date]:</b> $row[pos_content]<br>
					</p>";
			}
			
		
		?>
		
		<br>
		<hr>
		<br>
		
		<h2>INNER JOIN</h2>
		<p>
			INNER JOIN liefert alle Datensätze, die in den beteiligten Tabellen eine 
			gemeinsame Schnittmenge haben.
		</p>
		<h4>Zeige alle Accounts, die Postings verfasst haben PLUS die zugehörigen Postings</h4>
		
		<?php
			/************* DATENBANKOPERATION ***************/
			
			//1. DB: DB-Verbindung erstellen
			
			//2. DB: SQL-Statement vorbereiten
			$statement = $pdo->prepare("SELECT acc_name, pos_content, pos_date 
										FROM accounts INNER JOIN postings USING(acc_id)");
			
			//3. DB: SQL-ausführen und ggf. Platzhalter füllen
			$statement->execute() OR DIE( $statement->errorInfo()[2] );
			
			//4. DB: Daten weiterverarbeiten
			while($row = $statement->fetch(PDO::FETCH_ASSOC)){
				echo "<p>
						<b>$row[acc_name]  schrieb am $row[pos_date]:</b> $row[pos_content]<br>
					</p>";
			}
		?>
		
		<br>
		<hr>
		<br>
		
		<h2>LEFT-/RIGHT JOIN</h2>
		<p>
			LEFT-/RIGHT JOIN liefert sämtliche Datensätze aus einer Tabelle, zuzüglich diejenigen Datensätze 
			aus einer weiteren Tabelle, die mit der ersten Tabelle eine gemeinsame Schnittmenge haben.
		</p>
		<p>Zeige <u>alle</u> Accountnamen PLUS ggf. die von ihnen verfassten Postings:</p>
		
		<?php
			
			/************* DATENBANKOPERATION ***************/
			
			//1. DB: DB-Verbindung erstellen
			
			//2. DB: SQL-Statement vorbereiten
			$statement = $pdo->prepare("SELECT acc_name, pos_content, pos_date 
										FROM accounts LEFT JOIN postings USING(acc_id)");
			
			//3. DB: SQL-ausführen und ggf. Platzhalter füllen
			$statement->execute() OR DIE( $statement->errorInfo()[2] );
			
			//4. DB: Daten weiterverarbeiten
			while($row = $statement->fetch(PDO::FETCH_ASSOC)){
				echo "<p>
						<b>$row[acc_name]  schrieb am $row[pos_date]:</b> $row[pos_content]<br>
					</p>";
			}
		
		?>		
		
				
		<br>
		<hr>
		<br>
		
		<h2>INNER JOIN über 3 Tabelle</h2>
		<?php
			
			$dateTimeArr = isoToEuDateTime("2017-09-21 22:25:37");
			print_r($dateTimeArr);
			/************* DATENBANKOPERATION ***************/
			
			//1. DB: DB-Verbindung erstellen
			
			//2. DB: SQL-Statement vorbereiten
			$statement = $pdo->prepare("SELECT acc_name, pos_content, pos_date, usr_city, usr_registerdate FROM accounts 
										INNER JOIN postings USING(acc_id)
										INNER JOIN users USING(usr_id)");
			
			//3. DB: SQL-ausführen und ggf. Platzhalter füllen
			$statement->execute() OR DIE( $statement->errorInfo()[2] );
			
			//4. DB: Daten weiterverarbeiten
			while($row = $statement->fetch(PDO::FETCH_ASSOC)){
				
				$usrDateTimeArray = isoToEuDateTime($row['usr_registerdate']);
				$posDateTimeArray = isoToEuDateTime($row['pos_date']);
				
				echo "<p>
						<b>$row[acc_name] aus $row[usr_city]<br>
						Mitglied seit $usrDateTimeArray[date] <br>
						schrieb am $posDateTimeArray[date] um $posDateTimeArray[time] Uhr:<br>
						</b> $row[pos_content]<br>
					</p>";
			}
		?>
		

</body>

</html>