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
				
				/********** INCLUDE CLASSES **********/
				require_once("class/User.class.php");
			
			
/**********************************************************************************/
?>

<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>OOP - Objektoperationen</title>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/debug.css">
	</head>

	<body>
		<h1>OOP - Objektoperationen</h1>
		
		<h2>Eine Instanz der Klasse User erstellen</h2>
		
		<?php
			$harald = new User("Harald", "Haraldsen", "ha@ha.de", "22.04.1989");
			
		?>
		
		<h3>Ausgabe des Objekts $haralds:</h3>
		<p>
			<b>Vorname: </b>		<?=$harald->getFirstname()?><br>
			<b>Nachname: </b>		<?=$harald->getLastname()?><br>
			<b>Email: </b>			<?=$harald->getEmail()?><br>
			<b>Geburtsdatum: </b>	<?=$harald->getBirthdate()?>
		
		</p>
		
		<br>
		<hr>
		<br>
		
		<h2>Prüfen eines Objekts auf seinen Objekttyp</h2>
		<p>
			Will man überprüfen, ob ein bestimmtes Objekt zu einem bestimmten Typ(Klasse) gehört, benutzt
			man den Vergleichsoperator 'instanceof'. 'instanceof' liefert true oder false zurück.
		</p>
		<?php
			/********* Prüfen, ob Harald ein Objekt der Klasse User ist ********/
			if($harald instanceof User){
				// Erfolgsfall:
				echo "<p class='success'>\$harald ist ein Objekt der Klasse User</p>";
			}else{
				// Fehlerfall:
				echo "<p class='error'>\$harald ist kein Objekt der Klasse User</p>";
			}
			
			// Ein Instanz der Klasse stdClass erstellen
			// Die stdClass ist sozusagen die Mutter aller Klassen in PHP. Jede selbst erstellte
			// Klasse erbt von ihr beispielsweise den leeren Konstruktor
			
			
			/********* Prüfen, ob stdObjekt ein Objekt der Klasse User ist ********/
			$stdObject = new stdClass();
			
			if($stdObject instanceof User){
				// Erfolgsfall:
				echo "<p class='success'>\$stdObject ist ein Objekt der Klasse User</p>";
			}else{
				// Fehlerfall:
				echo "<p class='error'>\$stdObject ist kein Objekt der Klasse User</p>";
			}
			
			
			/********* Prüfen, ob Harald ein Objekt der Klasse stdClass ist ********/
			
			
			if($harald instanceof stdClass){
				// Erfolgsfall:
				echo "<p class='success'>\$harald ist ein Objekt der Klasse stdClass</p>";
			}else{
				// Fehlerfall:
				echo "<p class='error'>\$harald ist kein Objekt der Klasse stdClass</p>";
			}
			
			
		?>
		
		<br>
		<hr>
		<br>
		
		<h2>Die Klasse einer Instanz auslesen</h2>
		<p>
			Mittels der Funktion get_class() kann man sich die Klasse eines Objekts 
			ausgeben lassen:
		</p>
		<p>$harald ist ein Objekt der Klasse "<?= get_class($harald) ?>".</p>
		<p>$stdObject ist ein Objekt der Klasse "<?= get_class($stdObject) ?>".</p>
		
		<br>
		<hr>
		<br>
		
		<h2>Klassen-, Objekteigenschaften auslesen</h2>
		<p>
			Mittels der Funktion get_class_vars() kann man sich die public(!) Attribute in einer Klasse 
			ausgeben lassen (der Rückgabewert ist ein Array):
		</p>
		
		<?php
			echo "<pre>";					
			print_r(get_class_vars("User"));					
			echo "</pre>";
		?>
		
		<p>
			Mittels der Funktion get_object_vars() kann man sich die public(!) Attribute in einer Klasse 
			ausgeben lassen (der Rückgabewert ist ein Array):
		</p>
		
		<?php
			echo "<pre>";					
			print_r(get_object_vars($harald));					
			echo "</pre>";
		?>
		
		<p>
			Mittels der Funktion get_class_methods() kann man sich die public(!) Methoden 
			einer Klasse anzeigen lassen:
		</p>
		
		<?php
			echo "<pre>";					
			print_r(get_class_methods("User"));					
			echo "</pre>";
		?>
		
		<br>
		<hr>
		<br>
		
		<h2>Kopieren, Referenzieren und Vergleichen von Objekten</h2>
		<p>Zwei neue User-Objekt anlegen:</p>
		<?php
			$peter = new User();
			$petra = new User();
		?>
		
		<p>Die beiden User-Objekte mittels var_dump() ausgeben:</p>
		
		<?php
			echo "<pre>";					
			var_dump($peter);					
			echo "</pre>";
			
			echo "<pre>";					
			var_dump($petra);					
			echo "</pre>";
			
			
		?>
		
		<p><i>
			Anhand der Nummerierung der Objekte (#3, #4), die mittels var_dump() angezeigt wird, sieht man, 
			dass die Objekte $peter und $petra nicht identisch sind, obwohl sie inhaltlich gleich sind.
		</i></p>
		
		<h3>Vergleich zweier Objekte desselben Typs mit gleichen Eigenschaften:</h3>
		<p>
			<i>
				(wenn zwei Objekte miteinander mittels "===" vergleichen werden, 
				vergleicht das dritte "=" nicht den Datentyp, sondern die Identität)
			</i>
		</p>
		
		<?php
		
			/********* IDENTITÄTSPRÜFUNG *********/
			
			//Prüfen auf Identität:
			if($peter === $petra){
				echo "<h4>Die Objekte sind identisch.</h4>";
				
				//Prüfen auf Gleichheit:
			}elseif($peter == $petra){
				echo "<h4>Die Objekte sind gleich.</h4>";
			}else{
				echo "<h4>Die Objekte sind völlig unterschielich.</h4>";
			}
		?>
		
		<br>
		<hr>
		<br>
		
		<p>Den Objekten unterschiedliche Werte zuweisen: </p>
		
		<?php
			$peter->setFirstname("Peter");
			$petra->setFirstname("Petra");
			
			/********* IDENTITÄTSPRÜFUNG *********/
			
			//Prüfen auf Identität:
			if($peter === $petra){
				echo "<h4>Die Objekte sind identisch.</h4>";
				
				//Prüfen auf Gleichheit:
			}elseif($peter == $petra){
				echo "<h4>Die Objekte sind gleich.</h4>";
			}else{
				echo "<h4>Die Objekte sind unterschielich.</h4>";
			}
			
			
			echo "<pre>";					
			var_dump($peter);					
			echo "</pre>";
			
			echo "<pre>";					
			var_dump($petra);					
			echo "</pre>";
		?>
		
		<h3>Ein Objekt in ein anderes Objekt kopieren:</h3>
		<p>
			Man kann ein Objekt in ein anderes Objekt kopieren, indem man es klont:<br>
			<code>$petra = clone $stefan;</code>
		</p>
		
		<?php
			$petra = clone $peter;
			
			echo "<pre>";					
			var_dump($peter);					
			echo "</pre>";
			
			echo "<pre>";					
			var_dump($petra);					
			echo "</pre>";
			/********* IDENTITÄTSPRÜFUNG *********/
			
			//Prüfen auf Identität:
			if($peter === $petra){
				echo "<h4>Die Objekte sind identisch.</h4>";
				
				//Prüfen auf Gleichheit:
			}elseif($peter == $petra){
				echo "<h4>Die Objekte sind gleich.</h4>";
			}else{
				echo "<h4>Die Objekte sind unterschielich.</h4>";
			}
		?>
		<h3>Ein Objekt in ein anderes Objekt referenzieren</h3>
		<p><i>
			ACHTUNG: Bei Objekten wird mittels = KEINE echte Kopie des Objekts angefertigt, sondern es 
			wird stattdessen eine Referenz angelegt. D.h. dass ab sofort beide Variablen auf diesselbe
			Speicheradresse zeigen. Im Klartext: Es existiert nur 1 Objekt, das nun über 2 unterschiedlichen
			Variablen ansprechbar ist.<br>
			<br>
			Dieses Verhalten entspricht der Referenzierung von Variablen mittels <b>&$variable</b>.
		</i></p>
		
		<?php
			$petra = $peter;
			
			echo "<pre>";					
			var_dump($peter);					
			echo "</pre>";
			
			echo "<pre>";					
			var_dump($petra);					
			echo "</pre>";
			/********* IDENTITÄTSPRÜFUNG *********/
			
			//Prüfen auf Identität:
			if($peter === $petra){
				echo "<h4>Die Objekte sind identisch.</h4>";
				
				//Prüfen auf Gleichheit:
			}elseif($peter == $petra){
				echo "<h4>Die Objekte sind gleich.</h4>";
			}else{
				echo "<h4>Die Objekte sind unterschielich.</h4>";
			}
		?>
		
		<p><i>
			Die Objekte haben dieselbe Nummer (#5). D.h., dass zwei unterschiedlich benannte Variablen
			auf denselben Speicherbereich zeigen, in dem 1 Objekt gespeichert ist.<br>
			<br>
			Es handelt sich bei $petra und $peter durch das "Kopieren" also nicht mehr um 2 
			unabhängige aber gleiche Objekte, sondern es wurde beiden Objekt-Variablen dieselbe Speicheradresse
			zugewiesen. Das bedeutet, dass nunmehr ein und dasselbe Objekt unter zwei Variablennamen
			ansprechbar ist!
		</i></p>
		
		<h2 class="error">
			MERKE: Variablen oder Objekte referenzieren - ebenso wie verschachteltes Output-Bufferung - sollte nach Möglichkeit strikt vermeiden werden!
			Es besteht die große Gefahr, dass der Workflow des Codes so durcheinander gebracht wird, dass ein nachvollziehen des Workfolws nur noch sehr schwer möglich ist.
		</h2>
		
		
		
		
		
		
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
		<br>
		<br>
		<br>
		
	</body>

</html>























