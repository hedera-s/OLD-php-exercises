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
		<title>Datenbankanbindung mit PHP</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="css/debug.css">
	</head>

	<body>
		<h1>Datenbankanbindung mit PHP</h1>
		<p>
			In PHP existieren drei Varianten, um auf eine MySQL Datenbank zuzugreifen. Die älteste nutzt die MySQL Erweiterung, 
			die aber seit PHP 5.5.0 als veraltet (deprecated) markiert wurde und in der kommenden PHP Version entfernt wurde. 
			Die zweite Möglichkeit ist mittels der MySQL Improved Extension (MySQLi), und die letzte Möglichkeit ist mittels 
			PHP Data Objects (PDO).<br>
			<br>
			PDO ist dabei das aktuellste Interface, um auf Datenbank zuzugreifen, und besitzt gegenüber MySQLi einige neue nette 
			Funktionen und den großen Vorteil, dass es auch mit anderen Datenbanksystemen als MySQL zusammenarbeiten kann. 
			Das heißt, dass man, sollte man einmal auf ein anderes Datenbanksystem wechseln müssen, kaum etwas am PHP-Code 
			verändern muss.
		</p>
		<p>
			Eine PHP-Datenbankabfrage - egal ob lesend oder schreibend - läuft immer 
			nach dem gleichen Schema ab:
		</p>
		<ul>
			<li>Schritt 1: Mit der Datenbank verbinden</li>
			<li>Schritt 2: SQL-Statement vorbereiten</li>
			<li>Schritt 3: SQl-Statement ausführen und ggf. Platzhalter füllen</li>
			<li>Schritt 4: Daten weiterverarbeiten</li>
		</ul>
		
		<h3>Schritt 1 DB:  Mit der Datenbank verbinden</h3>
		<?php
			$pdo = dbConnect("market");
		?>
		
		<h3>Schritt 2 DB: SQL-Statement vorbereiten</h3>
		
		<?php
			$statement = $pdo->prepare("SELECT * FROM products");
		?>
		
		<h3>Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen</h3>
		<?php
			$statement->execute() OR DIE($statement->errorInfo()[2]);
			// Hier findet sozusagen der 'Handshake' zwischen Statement-Objekt und Datenbank statt:
			// Die SQL-Abfrage ist in der übermittelten Form 'genehmigt' und kann nun ausgeführt werden
		?>
		
		<h3>Schritt 4 DB: Daten weiteverarbeitrn</h3>
		<?php
			
			// Datensätze über eine Schleife auslesen
			// Der fetch()-Parameter PDO::FETCH_ASSOC liefert o.g. asoziatives Array zurück.
			// Der fetch()-Parameter PDO::FETCH_NUM liefert das gleiche Array als numerisches Array zurück.
			// Ohne fetch()-Parameter werden beide Arrays (asoziativ und numerisch) geliefert, was allerdings nur selten Sinn macht.
			
			while( $row = $statement->fetch(PDO::FETCH_ASSOC) ){ 
				echo "<pre>";
				print_r($row);
				echo "</pre>";
				echo "<p>ID: $row[prod_id]: $row[prod_name] - $row[prod_description] - $row[prod_category] - $row[prod_price] €</p>";
				
			}
		?>
		
		<br>
		<hr>
		<br>
		
		
		<h4>zeige alle produkte einer bestimmten Kategorie</h4>
		<?php
			$category = "Getränke";
			
			// Schritt 1 DB: DB-Verbindung aufbauen
			// ist bereits passiert
			
			// Schritt 2 DB: SQL-Statement  vorbereiten
			$statement = $pdo->prepare("SELECT * FROM products WHERE prod_category = :ph_prod_category");
			
			//Schritt 3 DB: SQL-Statement ausführen und Platzhalter mit werten füllen
			$statement->execute(array(
									"ph_prod_category" => $category
									)) OR DIE($statement->errorInfo()[2]);
			
			// Schritt 4 DB: Daten weiteverarbeitern
			while( $row = $statement->fetch(PDO::FETCH_ASSOC) ){ 
				echo "<p>ID: $row[prod_id]: $row[prod_name] - $row[prod_description] - $row[prod_category] - $row[prod_price] €</p>";
			}
		?>
		<br>
		<hr>
		<br>
		<h3>DB bei Bedarf per Hand beenden</h3>
		
		<p>
		Die Datenbankverbindung bleibt bestehen, bis das PHP-Skript abgearbeitet wurde und schließt sich dann 
		von allein. Sollte es doch einmal nötig werden, die DB-Verbindung vorher zu beenden, kann man sie mit dem 
		Befehl $pdo = NULL auch per Hand schließen.
		</p>

		<?php
		// Bei Bedarf die DB-Verbindung per Hand beenden:
		$pdo = NULL;
		?>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
</body>

</html>