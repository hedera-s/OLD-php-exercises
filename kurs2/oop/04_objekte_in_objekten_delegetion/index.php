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
				require_once("Class/Book.class.php");
				require_once("Class/Author.class.php");
			
			
/**********************************************************************************/
?>

<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>OOP - Objenke innerhalb von Objekten / Delegation</title>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/debug.css">
	</head>

	<body>
		<h1>OOP - Objenke innerhalb von Objekten / Delegation</h1>
		<p>
		Man kann Objekten als Attributswert auch weitere Objekte übergeben. Beispielsweise wäre in einer Bookstore-App
		das Buch ein eigenes Objekt, ebenso wie der Autor. Das Buch würde also als Autor in diesem Fall ein Objekt vom Typ
		Autor übergeben bekommen.<br>
		<br>
		Um nun auf die Attributswerte dieses "inneren" Objekts zugreifen zu können, muss man...
		</p>

		<br>
		<hr>
		<br>
		
		<h3>Autorenobjekt legen und mit Werten füllen:</h3>
		
		<?php
			$peter 	= new Author("Peter", "Petersen", "Nürnberg");
			$paul	= new Author("Paul", "Paulsen", "Ulm");
		?>
		
		<h3>Buchobjekt anlegen und mit Werten füllen:</h3>
		<?php
		//$title=NULL, $releaseyear=NULL, $price=NULL, $author=NULL
		$book1 = new Book("Der Insasse", "2018", "20.99", $peter);
		$book2 = new Book("Die Tyrannei des Schmetterlings", "2000", "16.89", $paul);
		
		?>
		
		<br>
		<hr>
		<br>
		
		<h3>Auslesen der Buchdaten und der jeweiligen Authodendaten</h3>
		
		<h4>Buch 1 (ohne Delegation):</h4>
		<p>
			<b>Titel: </b><?=$book1->getTitle() ?> <br>
			<b>Autor: </b><?=$book1->getAuthor()->getFirstname()?>  <?=$book1->getAuthor()->getLastname()?><br>
			<b>Jahr: </b><?=$book1->getReleaseyear()?> <br>
			<b>Preis: </b><?=$book1->getPrice()?> <br>
		</p>
		
		
		
		<h4>Buch 1 (ohne Delegation mit virtuellem  Attribut):</h4>
		<p><i>
			In $this->author->getFirstname() bezieht sich 'author' auf den Attributswert in dieser Klasse - also auf das Objekt
			'author' innerhalb des Book-Objekts.<br>
			Nach dem Auslesen des eingebetten Author-Objekts werden die jeweiligen Attribut-Getter und -Setter des Author-Objekts aufgerufen, die 
			die ihrerseits die jeweiligen Attributswerte des Author-Objekts auslesen.
		<i></p>
		<p>
			<b>Titel: </b><?=$book1->getTitle() ?> <br>
			<b>Autor: </b><?=$book1->getAuthor()->getFullname()?><br>
			<b>Jahr: </b><?=$book1->getReleaseyear()?> <br>
			<b>Preis: </b><?=$book1->getPrice()?> <br>
		</p>
		
		<h4>Buch 2 (mit Delegation):</h4>
		<p><i>
			Die Delegation ist im Grunde genommen eine Art virtuelles Attribut, das innerhalb einer 
			Klasse das eingebettete Objekt ausliest und über dieses auf dessen Getter & Setter zugreifen kann.
		<i></p>
		<p>
			<b>Titel: </b><?=$book2->getTitle()?> <br>
			<b>Autor: </b><?=$book2->getAuthorFullname()?><br>
			<b>Jahr: </b><?=$book2->getReleaseyear()?> <br>
			<b>Preis: </b><?=$book2->getPrice()?> <br>
		</p>
		
		<br>
		<hr>
		<br>
		
		<h3>Schreiben in ein eingebetetes Objekt</h3>
		<p>Der Nachname von "Peter" soll geändert werden in "Petersdottir"</p>
		<h4>Ändern des Nachnamens direkt über das Author-Objekt</h4>
		<?php
			$peter->setLastname("Petersdottir");
			echo "<pre class='debugClass'><b>Line  " . __LINE__ .  "</b> <i>(" . basename(__FILE__) . ")</i>:<br>";					
			print_r($peter);					
			echo "</pre>";
		?>
		
		
		<p>Der Nachname von "Paul" soll geändert werden in "Paulsdottir"</p>
		<h4>Ändern des Nachnamens direkt über das Book-Objekt</h4>
		
		<?php
			$book2->getAuthor()->setLastname("Paulsdottir");
			echo "<pre class='debugClass'><b>Line  " . __LINE__ .  "</b> <i>(" . basename(__FILE__) . ")</i>:<br>";					
			print_r($paul);					
			echo "</pre>";
		?>
		
		<h3>Ändern des Authors eines Book-Objekts</h3>
		<?php
			$book1->setAuthor($paul);
			echo "<pre class='debugClass'><b>Line  " . __LINE__ .  "</b> <i>(" . basename(__FILE__) . ")</i>:<br>";					
			print_r($book1);					
			echo "</pre>";
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























