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
					require_once("include/db.inc.php");
					
					
					
/**********************************************************************************************/
					/**********************************************/
					/************ INITIALIZE VARIABLES ************/
					/**********************************************/
					
					$dbMessage = NULL;
					$messageCountPhp  = NULL;
					// $dataArrayCountPhp muss an dieser Stelle als leeres Array vordefiniert 
					// werden, da weiter unten im Code mittels foreach-Schleife darauf zugegriffen 
					// wird und PHP einen Fehler wirft, wenn der Datantyp nicht Array ist.
					$dataArrayCountPhp  = array();
					$messageCountSql = NULL;
	
/**********************************************************************************************/	
					
					/**************************************************/
					/************ DB-VERBINDUNG HERSTELLEN ************/
					/**************************************************/
					
					$pdo = dbConnect("market");

/**********************************************************************************************/	
					/*********************************************/
					/******** URL-PARAMETER Verarbeitung *********/
					/*********************************************/
					
					//1 URL. Prüfen, ob URL-Parameter übergeben wurde
					
					if(isset($_GET['action'])){
if(DEBUG)				echo "<p class='debug'>URL-Parameter 'Action' wurde übergeben</p>";	
						
					//2 URL. Werte auslesen, entschärfen, debug
					
					$action = cleanString($_GET['action']);
if(DEBUG)			echo "<p class='debug'>action: $action</p>";	
					
					
					
					//3 URL. Verzweigen
					
					/************ INSERT ************/
					if($action == "insert") {
if(DEBUG)				echo "<p class='debug'>INSERT wird ausgeführt</p>";
		
					// 4 URL. Daten weiterverarbeiten	
					
					/********** DB-Operation **********/
					
					//2. SQL-Statement vorbereiten
					$statement = $pdo->prepare("INSERT INTO products 
												(prod_name, prod_description, prod_category, prod_price)
												VALUES 
												(:ph_prod_name, :ph_prod_description, :ph_prod_category, :ph_prod_price)
												");
												
					//3. SQL-Statement ausführen und ggf. Platzhalter mit werten füllen
					$statement->execute(array(
											"ph_prod_name" => "Thunfisch",
											"ph_prod_description" => "Aus Fisch",
											"ph_prod_category" => "Fisch",
											"ph_prod_price" => "12.99"
											))OR DIE($statement->errorInfo()[2]);
					//4. DB Daten weiterverarbeitung
					//Bei INSERT: Überprüfen, ob Screibvorgang erfolgreich war
					// DIe zuletzt von der DB vergebene ID auslesen
					$lastInsertId = $pdo->lastInsertId();
if(DEBUG)			echo "<p class='debug'>lastInsertId: $lastInsertId</p>";	

					// Wenn die lastInsertId einen anderen Wert als 0 hat, war der Schreibvorgang erfolgreich
					if($lastInsertId){
						// Erfolgsfall
if(DEBUG)				echo "<p class='debug ok'>Neuer Datensatz wurde erfolgreich mit der ID $lastInsertId angelegt</p>";											
						$dbMessage = "<p class='success'>Neuer Datensatz wurde erfolgreich angelegt</p>";
					} else {
						//Fehlerfall
if(DEBUG)				echo "<p class='debug err'>Fehler beim Anlegen des neuen Datensatzes</p>";
						$dbMessage = "<p class='error'>Ein Fehler beim Anlegen des neuen Datensatzes</p>";
					
					}
						
						
					/************ UPDATE ************/
					} elseif($action == "update"){
if(DEBUG)					echo "<p class='debug'>UPDATE wird ausgeführt</p>";			
		
					// 4 URL. Daten weiterverarbeiten	
					//1. Verbindung DB
					//2. DB-Statement vorbereiten
					$statement = $pdo->prepare("UPDATE products
												SET
												prod_price = :ph_prod_price
												WHERE prod_name = :ph_prod_name
												");
					//3. SQL-Statement ausführen und Platzhalter füllen
					$statement->execute(array(
											"ph_prod_price" => 9.99,
											"ph_prod_name" => "Thunfisch",
											))OR DIE($statement->errorInfo()[2]);

					//4.DB Daten weiterverarbeiten
					// Bei UPDATE: Schreiberfolg überprüfen
					// Number of affected rows (Anzahl der betroffenen Datensätze) auslesen
					$anzahl = $statement->rowCount();
if(DEBUG)			echo "<p class='debug'>DELETE wird ausgeführt</p>";	
					
					if($anzahl){
						//Erfolgsfall
if(DEBUG)			echo "<p class='debug ok'>$anzahl Datensätze wurden geändert</p>";		
					$dbMessage = "<p class='success'>$anzahl Datensätze wurden geändert </p>";
						
					} else {
						// Es wurde nicht in die DB geschrieben (Es wurde kein Datensatz gefunden oder
						// es gab keine wirkliche Änderungen an den Werten vorzunehmen oder es gab tatsächlich
						// einen Fehler auf der DB)
					$dbMessage = "<p class='info'>Es wurde kein Datensatz geändert.</p>";
if(DEBUG)			echo "<p class='debug'> Es wurde kein Datensatz geändert. </p>";							
					}
					
					
					/************ DELETE ************/
					} elseif($action == "delete"){
if(DEBUG)				echo "<p class='debug'>DELETE wird ausgeführt</p>";	
		
					// 4 URL. Daten weiterverarbeiten	
					//1. Verbindung DB
					//2. DB-Statement vorbereiten
					$statement = $pdo->prepare("DELETE FROM products
												WHERE prod_name = :ph_prod_name
												");
					//3. SQL-Statement ausführen und Platzhalter füllen
					$statement->execute(array(
											"ph_prod_name" => "Thunfisch",
											))OR DIE($statement->errorInfo()[2]);
										
					//4 DB. Daten weiterverarbeiten
					// Bei DELETE: Schreiberfolg überprüfen
					// Number of affected rows (Anzahl der betroffenen Datensätze) auslesen

					$anzahl = $statement->rowCount();
if(DEBUG)			echo "<p class='debug'>anzahl :  $anzahl</p>";	
					
					if($anzahl){
						//Erfolgsfall
if(DEBUG)			echo "<p class='debug ok'>$anzahl Datensätze wurden gelöscht</p>";		
					$dbMessage = "<p class='success'>$anzahl Datensätze wurden gelöscht</p>";
						
					} else {
						// Es wurde nicht in die DB geschrieben (Es wurde kein Datensatz gefunden oder
						// es gab keine wirkliche Änderungen an den Werten vorzunehmen oder es gab tatsächlich
						// einen Fehler auf der DB)
					$dbMessage = "<p class='info'>Es wurde kein Datensatz gelöscht.</p>";
					}
					
					
					/************ COUNTPHP ************/
					} elseif($action == "countPhp"){
if(DEBUG)				echo "<p class='debug'>COUNTPHP wird ausgeführt</p>";		
		
					// 4. Daten weiterverarbeiten	
						//1. Verbindung DB
						//2. DB-Statement vorbereiten
					$statement = $pdo->prepare("SELECT DISTINCT prod_category FROM products");
					
					//3. SQL-Statement ausführen und Platzhalter füllen
					$statement->execute() OR DIE($statement->errorInfo()[2]);
					//4. Daten weiterverarbeiten
					//Bei SELECT: Datensätze auslesen
					// $dataArrayCountPhp enthält ein zweidimensionales Array. Jedes darin 
					// enthaltene Array entspricht einem Datensatz aus der DB
					
					$dataArrayCountPhp = $statement->fetchAll(PDO::FETCH_ASSOC);
					
					//Zählen, wie viele Datensätze geliefert wurden
					$anzahl = $statement->rowCount();
if(DEBUG)			echo "<p class='debug'>anzahl :  $anzahl</p>";		

					//Ergebnis im Frontend ausgeben
					$messageCountPhp = "<p class='info'>Es wurden $anzahl unterschiedliche Kategorien gefunden.</p>";

					/************ COUNTSQL ************/
					} elseif($action == "countSql"){
if(DEBUG)				echo "<p class='debug'>COUNTSQL wird ausgeführt</p>";	
		
					// 4. Daten weiterverarbeiten	
					
					/************** DB-OPERATION *************/
					
					//1. Verbindung DB
					//2. DB-Statement vorbereiten
					$statement = $pdo->prepare("SELECT COUNT(DISTINCT prod_category) FROM products");
					
					//3. SQL-Statement ausführen und Platzhalter füllen
					$statement->execute() OR DIE($statement->errorInfo()[2]);
					//4. Daten weiterverarbeiten
					//Bei SELECT COUNT(): Rückgabewert von COUNT auslesen
					$anzahl = $statement->fetchColumn();
if(DEBUG)			echo "<p class='debug'>Anzahl: $anzahl</p>";	
					
					//Ergebnis im Frontend ausgeben
					$messageCountSql = "<p class='info'>Es wurden $anzahl unterschiedliche Kategorien gefunden.</p>";
					}
					
					}



/**********************************************************************************************/	
					
					/******************************************************/
					/*************** DATEN AUS DB ANZEIGEN ****************/
					/******************************************************/
if(DEBUG) echo "<p class='debug'>Daten wurden ausgelesen</p>";					
					// 1. DB-Verbindung herstellen
					// ist bereits geschehen
					
					// 2. SQL-Statement vorbereiten
					$statement = $pdo->prepare("SELECT * FROM products");
					
					// 3. SQL-Statement ausführen und ggf. Platzhalter füllen
					$statement->execute() OR DIE($statement->errorInfo()[2]);
					
					// 4. Daten weiterverarbeiten
					// Bei SELECT: Datensätze auslesen
					// fetchAll liefert zweidimensionales Array zurück, 
					//das ALLE Datensätze beinhaltet
					
					$dataArray = $statement->fetchAll(PDO::FETCH_ASSOC);
					
					
/**********************************************************************************************/	
?>
<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>DB-Operationen mit Prepared Statements</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="css/debug.css">
	</head>

	<body>
		<h1>DB-Operationen mit Prepared Statements</h1>

		<br>
			<?php echo $dbMessage ?>
		<br>
		<br>
		<p><a href="<?php echo $_SERVER['SCRIPT_NAME']?>">Seitenaufruf ohne Parameter</a></p>
		<br>
		<hr>
		<br>
		<h3>Einen neuen Datensatz anlegen</h3>
		<p><a href="?action=insert">Einen neuen Datensatz anlegen</a></p>
		<br>
		<hr>
		<br>
		<h3>Einen bestehenden Datensatz ändern</h3>
		<p><a href="?action=update">Einen bestehenden Datensatz ändern</a></p>
		<br>
		<hr>
		<br>
		<h3>Einen bestehenden Datensatz löschen</h3>
		<p><a href="?action=delete">Einen bestehenden Datensatz löschen</a></p>
		<br>
		<hr>
		<br>
		<h3>Bestehende Datensätze zählen mit PHP (rowCount())</h3>
		<p><a href="?action=countPhp">Bestehende Datensatze zählen mit PHP (rowCount())</a></p>
		<?php echo $messageCountPhp ?>
		<!--
		Die Tabelle mit den unterschiedlichen Kategorien soll nur dann erzeugt werden,
		wenn der Link "Bestehende Datensätze zählen mit PHP (rowCount())" aufgerufen wurde.
		Wenn der Link aufgerufen wurde, enthält $messageCountPhp einen String, ansonsten NULL.
		-->
		<?php if($messageCountPhp): ?>
		<table>
			<tr>
				<th>Category</th>
			</tr>
			<!--
				$dataArrayCountPhp enthält ein zweidimensionales Array. Jedes darin 
				enthaltene Array entspricht einem Datensatz aus der DB.
				Je Schleifendurchlauf enthält $dataset einen anderen Datensatz in Form 
				eines eindimensionalen Arrays, dessen Indizes den Namen der Spalten in 
				der Tabelle 'products' entsprechen.
			-->
			<?php foreach($dataArrayCountPhp AS $dataSet): ?>
			<tr>
				<td><?php echo $dataSet['prod_category'] ?></td>
			</tr>
			<?php endforeach ?>
		</table>
		<?php endif ?>
		<p>
			In PHP wird bei Einsatz von Prepared Statements mittels des Konstrukts $statement->rowCount() gezählt, wieviele 
			Datensätze von der SQL-Abfrage zurückgeliefert wurden.<br>
			<br>
			Vorteil dieser Methode: Neben der Anzahl der gelieferten Datensätze stehen auch die Datensätze selbst zur 
			Weiterverarbeitung zur Verfügung.<br>
			Nachteil dieser Methode: Es werden alle betroffenen Datensätze tatsächlich aus der DB gelesen und übertragen, was
			für das reine Zählen wenig performant ist.
		</p>
		<br>
		<hr>
		<br>
		<h3>Bestehende Datensätze zählen mit SQL (COUNT())</h3>
		<p><a href="?action=countSql">Bestehende Datensätze zählen mit SQL (COUNT())</a></p>
		<?php echo $messageCountSql ?>
		<p>
			In SQL wird mittels des Konstrukts COUNT() gezählt, wieviele Einträge in einer Tabelle 
			von einer SQL-Abfrage betroffen sind.<br>
			<br>
			Vorteil dieser Methode: Die Einträge werden tatsächlich nur gezählt. Es werden keine 
			weiteren Daten übertragen, was sich positiv auf die Performanz auswirkt.<br>
			Nachteil dieser Methode: Sollen die betroffenen Datensätze doch noch verarbeitet werden, 
			muss eine zweite SQL-Abfrage an die DB gesandt werden.
		</p>
		<br>
		<hr>
		<br>
		
		<h3>Inhalt der Tabelle "Products":</h3>
		
		<table>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Description</th>
				<th>Category</th>
				<th>Price</th>
			</tr>
			<!--
				$dataArrayCountPhp enthält ein zweidimensionales Array. Jedes darin 
				enthaltene Array entspricht einem Datensatz aus der DB.
				Je Schleifendurchlauf enthält $dataset einen anderen Datensatz in Form 
				eines eindimensionalen Arrays, dessen Indizes den Namen der Spalten in 
				der Tabelle 'products' entsprechen.
			-->
			<?php foreach( $dataArray AS $dataSet ): ?>
				<tr>
					<td><?php echo $dataSet['prod_id'] ?></td>
					<td><?php echo $dataSet['prod_name'] ?></td>
					<td><?php echo $dataSet['prod_description'] ?></td>
					<td><?php echo $dataSet['prod_category'] ?></td>
					<td><?php echo $dataSet['prod_price'] ?>€</td>
				</tr>
			<?php endforeach ?>
			
		</table>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

</body>

</html>