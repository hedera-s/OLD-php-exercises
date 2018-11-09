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
				require_once("Class/User.class.php");
			
			
/**********************************************************************************/
?>

<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>OOP - Constructor / Magische Methoden / Debugging von Objekten</title>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/debug.css">
	</head>

	<body>
		<h1>OOP - Constructor / Magische Methoden / Debugging von Objekten</h1>
		
		<p>
			Der Konstruktor erstellt eine neue Klasseninstanz/Objekt.<br>
			<br>
			Soll ein Objekt beim Erstellen bereits mit Attributwerten versehen werden,
			muss ein eigener Konstruktor geschrieben werden. Dieser nimmt die Werte in 
			Form von Parametern (genau wie bei Funktionen) entgegen und ruft seinerseits 
			die entsprechenden SETTER auf, um die Werte zuzuweisen.
		</p>

		<p>
			<b>Der Konstruktor gehört zu den sog. "magischen Methoden"</b>, die man nicht explizit aufrufen muss. Stattdessen 
			entscheiden diese magischen Methoden selbst, ob sie aufgerufen werden müssen oder nicht.<br>
			<br>Magische Methoden erkennt man an ihren Namen, die stets mit __ (2 Unterstriche) beginnen:<br>
			<code>__construct()</code>.
		</p>

		<p>
			Eine andere magische Methode, die bei jedem echo-Befehl automatisch aufgerufen wird, ist __toString(), 
			die den mittels echo auszugebenen Wert in einen String umwandelt. Bei zur Umwandlung in einen 
			String ungeeigneten Datentypen wie Arrays oder Objekten erzeugt __toString() eine entsprechende Fehlermeldung.
		</p>

		<br>
		<hr>
		<br>
		
		<h3>Eine Instanz aus der Klasse User erstellen (ein Objekt der Klasse User erstellen) und direkt bei Erstellung
		über den Konstruktor mit Attributswerten füllen (der Konstruktor ruft sich automatisch selbst auf):</h3>
		<code>$harald = new User("Harald", "Haraldsen", "ha@ha.de", "1968-04-03");</code>
		
		
		<?php
		$harald = new User(123, "Haraldsen", "haha.de", "1968-04-03");
	
		
		
		$peter = new User("Peter", "Petersen");
		
		echo "<h3 class='info'>Hallo Herr " . $peter->fetchFullName() . "</h3>";
		
	
		
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























