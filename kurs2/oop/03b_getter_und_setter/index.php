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
		<title>OOP - Getter und Setter/Sichtbarkeit/Virtuelle Attribute</title>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/debug.css">
	</head>

	<body>
		<h1>OOP - Getter und Setter/Sichtbarkeit/Virtuelle Attribute</h1>
		
		<p>
			Auch Objekte und deren Attribute und Methoden lassen sich kapseln. I.d.R. werden vor allem 
			die Objektattribute gekapselt, so dass diese nicht aus Versehen mit falschen Datentypen oder 
			Wert-Formaten gefüllt werden können.<br>
		<br>
			Hierzu setzt man die Sichtbarkeit der Attribute auf 'private' oder 'protected' und lässt sowohl 
			den lesenden als auch den schreibenden zugriff auf sie nur noch über Objektmethoden zu. In diesen Objektmethoden kann dann beispielsweise vor der Wertzuweisung eine Typ- bzw. Datenprüfung 
			oder -manipulation vorgenommen werden.<br>
		<br>
			Diese speziellen Methoden zum Auslesen bzw. Schreiben eines Objektattributs nennt man Getter bzw.
			Setter.
		</p>
	
		<?php
		/************ OBJEKT ERSTELLEN **************/
		$harald = new User();
		
		echo "<pre>";
		print_r($harald);
		echo "</pre>";
		
		/*********** OBJEKT MITTELS SETTER MIT WERTEN FÜLLEN **********/
		
		// $harald->firstname = "Harald";	ist durch das 'private' vor dem Attribut nicht mehr möglich
		$harald->setFirstname("Harald");
		$harald->setLastname("Haraldson");
		$harald->setEmail("ha@ha.de");
		$harald->setBirthdate(12.02);
		
		
		echo "<pre>";
		print_r($harald);
		echo "</pre>";
		
		?>
		
		<h4>Ausgabe des Objekts $harald:</h4>
		<p>
			<b>Vorname:</b> 		<?= $harald->getFirstname() ?><br>
			<b>Nachname:</b> 		<?= $harald->getLastname() ?><br>
			<b>Email-Adresse:</b> 	<?= $harald->getEmail() ?><br>
			<b>Geburtdatum:</b>		<?= $harald->getBirthdate() ?><br>
			<b>Voller Name:</b>		<?= $harald->getFullname() ?><br>
		</p>

		<br>
		<hr>
		<br>
		
		<h3>Virtuelles Attribut:</h3>
		<p>
			Mittels GETTER kann man sich auch sog. "virtuelle Attribute" erschaffen:<br>
			<br>
			Ein virtuelles Attribut ist kein wirklich existierendes Attribut. Es existiert allerdings 
			ein GETTER, der das virtuelle Attribut beim Aufruf "live zusammenbaut".<br>
			<br>
			Das folgende virtuelle Attribut besteht im Grunde lediglich aus einem zusätzlichen GETTER mit dem Namen
			<i>getFullname()</i>, in dem die Attribute $firstname und $lastname zu einem einzigen String zusammengebaut
			werden. Der Aufruf des GETTERS <i>getFullname()</i> gibt nun den fertig zusammengestzten 
			first- und lastname des User-Objekts zurück, so dass bei der Anrede des Users nicht jedes Mal
			<i>$user->getFirstname() $user->getLastname()</i>, sondern lediglich <i>$user->getFullname()</i> aufgerufen werden muss: 
		</p>
		
		<b>Voller Name:</b>		<?= $harald->getFullname() ?><br>
		
		
		
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























