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
				
				/********** INCLUDE CLASSES **********/
				require_once("Class/User.class.php");
			
			
/**********************************************************************************/
?>

<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>OOP - Klassen und Instanzen</title>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/debug.css">
	</head>

	<body>
		<h1>OOP - Klassen und Instanzen</h1>
		<p>
			Ein Objekt ist eine sog. Instanz einer Objekt-Klasse. Die Klasse enthält quasi den Bauplan 
			des Objekt inkl. aller seiner Eigenschaften (Attribute) und seiner Funktionen (Methoden).
			Aus diesem Klassenbauplan kann jederzeit ein neues individuelles Objekt der Klasse erstellt werden.
		</p>
		<p>
			Der Vorteil dieser Klassenschemata ist, dass alle Variablen und Funktionen, die zu einem bestimmten 
			Objekttyp gehören, auch technisch miteinander verbunden sind. Userattribute wie firstname, lastname, email etc. 
			sind nicht länger (technisch gesehen) völlig voneinander unabhängige Variablen, sondern stehen nun in 
			einer echten Beziehung (nämlich der Zugehörigkeit zu einem Objekt vom Typ User) zueinander.
		</p>
		<p>
			Alle Objekte vom gleichen Typ besitzen die gleichen Attribute und Methoden, unterscheiden sich
			aber i.d.R. in deren Werten.
		</p>
		<p>
			Wenn man ein Objekt eines bestimmten Typs erstellt, nennt man das auch "eine Instanz der Klasse erstellen".
		</p>
		
		<h3>Eine Instanz bzw. ein Objekt der Klasse User erstellen</h3>
		<?php
			/************ OBJEKT ERSTELLEN ************/
			// Einen neuen User mit dem Objektnamen $harald erstellen
			$harald = new User();
			
			// Das neu erstelle Objekt $harald anzeigen
			echo "<pre>";
			print_r($harald);
			echo "</pre>";
			
		
		?>
		
		<h3>Das User-Objekt $harald mit Werten füllen</h3>
		<?php
			/************ OBJEKT MIT WERTEN FÜLLEN ************/
			$harald->firstname 	= "Harald";
			$harald->lastname 	= "Haraldson";
			$harald->email 		= "h@h.de";
			$harald->birthdate 	= "25.05.1988";
			
			echo "<pre>";
			print_r($harald);
			echo "</pre>";
		
		?>
		
		<h4>Ausgabe des Objekts $harald</h4>
		
		<p>
			<b>Vorname: </b>		<?=$harald->firstname?><br>
			<b>Nachname: </b>		<?=$harald->lastname?><br>
			<b>Email: </b>			<?=$harald->email?><br>
			<b>Geburtsdatum: </b>	<?=$harald->birthdate?><br>
		</p>
		
		<h3>Eine weitere Instanz der Klasse User erstellen</h3>
		
		<?php
			$peter = new User();
			
		?>
		
		<h3>Das User-Objekt $peter mit Werten füllen</h3>
		<?php
			/************ OBJEKT MIT WERTEN FÜLLEN ************/
			$peter->firstname 	= "Peter";
			$peter->lastname 	= "Petersen";
			$peter->email 		= "p@p.de";
			$peter->birthdate 	= "17.03.1982";
			
			echo "<pre>";
			print_r($peter);
			echo "</pre>";
		
		?>
		<h4>Ausgabe des Objekts $peter</h4>
		
		<p>
			<b>Vorname: </b>		<?=$peter->firstname?><br>
			<b>Nachname: </b>		<?=$peter->lastname?><br>
			<b>Email: </b>			<?=$peter->email?><br>
			<b>Geburtsdatum: </b>	<?=$peter->birthdate?><br>
		</p>
		
		<h2>Klassenmethoden</h2>
		<p>
			Methoden, die sich auf ein Objekt beziehen, werden in dessen jeweiliger Klasse notiert und 
			erfüllen ausschließlich Aufgaben, die sich auf das konkrete/eigene Objekt beziehen:
		</p>
		
		<?php
			/********* AUFRUF VON OBJEKTMETHODEN ***********/
			echo $harald->beispielMethode();
			echo $peter->beispielMethode();
			echo $peter->fetchFullName();
			echo $harald->fetchFullName();
		?>
		
		
		
		
		
		
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























