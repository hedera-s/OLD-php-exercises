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
				require_once("class/Oberklasse.class.php");
				require_once("class/Unterklasse.class.php");
				require_once("class/Unterunterklasse.class.php");
			
			
/**********************************************************************************/
?>

<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>OOP - Vererbung</title>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/debug.css">
	</head>

	<body>
		<h1>OOP - Vererbung</h1>
		<p>
			Vererbung ist ein gängiges Prinzip in der objektorientierten Programmierung. Mittels Vererbung kann man quasi Hierarchiestufen 
			in Klassen ermöglichen: Sämtliche Attribute und Methoden, die in einer Oberklasse definiert wurden, 
			vererben sich, sofern sie die Sichtbarkeit 'public' oder 'protected' besitzen, auf die Unterklassen und können dort verwendet werden.<br>
			<br>
			Vererbte Attribute und Methoden lassen sich in den Unterklassen überschreiben. 
		</p>
		<p>
			In PHP kann eine Klasse lediglich von EINER Oberklasse erben, nicht jedoch von mehreren gleichzeitig. Jedoch 
			kann die Vererbung über mehrere Klassen "nach unten weitergereicht" werden (Eimerketten-Prinzip).
		</p>

		<br>
		<hr>
		<br>
		
		<h3>Oberklasse</h3>
		<p>
			Die vererbende Oberklasse ist eine ganz normale Klasse.
			Wichtig sind hier die Einstellungen zur Sichtbarkeit:
			Alle Attribute und Methoden, die vererbbar sein sollen, müssen mit dem Präfix "public" oder "protected" 
			versehen werden. "private"-Attribute und Methoden werden nicht vererbt und sind nach wie vor ausschließlich 
			aus der eigenen Klasse heraus aufrufbar.
			"protected"-Attribute und -Methoden sind aus den vererbten Klassen aufrufbar, jedoch nicht von außerhalb 
			über den Objektaufruf. "public"-Attribute und -Methoden hingegen werden ebenfalls vererbt.
		</p>
		
		<h4>Objekt der Klasse "Oberklasse" erzeugen:</h4>
		<?php
			$oberObjekt = new Oberklasse();
		//	echo $oberObjekt->name;
		?>
		
		<br>
		<hr>
		<br>

		<h3>Unterklasse</h3>
		<p>
			Die Unterklasse erbt mittels des Schlüsselwortes "extends" von der Oberklasse alle 
			dort als "protected" notierten Attribute und Methoden (in diesem Fall also das 
			Attribut 'name' und die Methode HelloWorld()).<br>
			<br>
			Mittels der Notation "parent::Methodenname()" kann direkt auf die vererbte Methode 
			der Elternklasse zugegriffen werden.
		</p>

		<h4>Objekt der Klasse 'Unterklasse' erzeugen:</h4>
		<?php
			$unterObjekt = new Unterklasse();
			$unterObjekt->HelloWorld();
		?>
		
		<br>
		<hr>
		<br>

		<h3>UnterUnterklasse</h3>
		<p>
			Eine Vererbung kann über mehrere "Generationen" weitergereicht werden. Jede Folgeklasse erbt die 
			"protected"-Eigenschaften und -Methoden der vererbenden Klassen und - wie in der berühmten Eimerkette - alle 
			"protected"-Eigenschaften und -Methoden aller Oberklassen.<br>
			<br>
			Die geerbten Eigenschaften und Methoden können jedoch jederzeit überschrieben werden.
		</p>

		<h4>Objekt der Klasse UnterUnterklasse erzeugen:</h4>
		<?php
			$unterunterObjekt = new UnterunterKlasse();
			$unterunterObjekt->HelloWorld();
		?>
		
		<br>
		<hr>
		<br>

		<h2>Die Elternklasse einer Kindklasse auslesen</h2> 
		<p>
			Mittels der Funktion get_parent_class() kann man sich die Elternklasse 
			einer Kindklasse anzeigen lassen:
		</p>
		<p>Elternklasse von $oberObjekt: <b><?=get_parent_class($oberObjekt)?></b></p>
		<p>Elternklasse von $unterObjekt: <b><?=get_parent_class($unterObjekt)?></b></p>
		<p>Elternklasse von $unterunterObjekt: <b><?=get_parent_class($unterunterObjekt)?></b></p>
		<?php
			
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























