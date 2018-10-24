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
					require_once("include/functions.inc.php");
					
					
/**********************************************************************************************/	
?>
<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>Dateioperationen</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="css/debug.css">
	</head>

	<body>
		<h1>Dateioperationen</h1>

		<p>
			Eine einzulesende Datei muss utf-8 codiert sein. Das geschieht am 
			besten, indem man sie in Notepad++ erzeugt und unter "Kodierung" 
			utf-8 ohne BOM auswählt.
		</p>
		
		<h2>Datei auslesen</h2>
		<p>
			Die PHP-Funktion <b>file_get_contents()</b> dient dazu, in PHP Dateien (Files)
			zu öffnen und einzulesen. Die Funktion erwartet als Parameter den Pfad 
			zur zu öffnenden Datei.
		</p>
		<?php
			// wenn file_get_contents() eine Datei findet und deren Inhalt
			// erfolgreich in eine Variable geschrieben hat...
			// ein @ vor einem Funktionsaufruf unterdrückt die Ausgabe der von dieser
			// Funktion generierten Fehlermeldung im Frontend
			if($fileContent = @file_get_contents("dateioperationen.txt")){
				// ...gib den Inhalt aus
				echo "<p class='ex'><i>".nl2br($fileContent)."</i></p>";
			} else {
				// ...ansonsten Fehlermeldung
				echo "<p class='error'><i>FEHLER beim Einlesen der Datei!</i></p>";
			}
			
		?>
		
		<h3>Datei zeilenweise auslesen</h3>
		<p>
			Die PHP-Funktion <b>file()</b> liest eine Datei zeilenweise ein und 
			erzeugt ein Array, in dem jede Zeile als eigener Wert (String) 
			gespeichert wird. Die Funktion erwartet als Parameter den Pfad
			zur zu öffnenden Datei.
		</p>
		
		<?php 
			$fileContentArray = file("dateioperationen.txt");
if(DEBUG)	echo "<pre class='debug'>";			
if(DEBUG)	print_r($fileContentArray);			
if(DEBUG)	echo "</pre>";			
		?>
		
		<h3>Nur die erste Zeile der Textdatei ausgeben:</h3>
		<p class="ex"><i><?php echo $fileContentArray[0] ?></i></p>
		<p>- - -</p>
		
		<h3>Alle Zeilen der Textdatei ausgeben:</h3>
		<?php foreach($fileContentArray AS $key=>$value): ?>
			<p class="ex"><i><?php echo "$key: $value" ?></i></p>
		<?php endforeach ?>
		<p>- - -</p>
		
		<h3>Jede ungerage Zeile der Textdatei ausgeben:</h3>
		<?php foreach($fileContentArray AS $key=>$value): ?>
			<?php if($key%2): ?>
				<p class="ex"><i><?php echo "$key: $value" ?></i></p>
			<?php endif ?>
		<?php endforeach ?>
		<p>- - -</p>
		
		<h3>Eine zufällige Zeile der Textdatei ausgeben:</h3>
		<?php  
			$arrayLength = count($fileContentArray);
			$randomIndex = rand(0,$arrayLength-1);
			echo "<p class='ex'><i>$fileContentArray[$randomIndex]</i></p>";
		?>
			
		<p>- - -</p>
		
		<h2>In Datei schreiben</h2>
		<h3>In Datei überschreiben</h3>
		<p>
			Um in Dateien schreiben zu können, existiert in PHP die Funktion
			<b>file_put_contents($filename,$content)</b>. Als Argument erwartet die 
			Funktion als erstes den Dateipfad und als zweites die Daten, die 
			in die Datei geschrieben werden sollen.<br>
			<br>
			Ist die Datei (noch) nicht vorhanden, wird sie kurzerhand erzeugt.<br>
			Ist die Datei bereits vorhanden, wird ihr Inhalt überschrieben.
		</p>
		<p>- - -</p>
		
		<?php
			if(!file_put_contents("dateioperationen2.txt", "Hier steht mein Content...")){
				//fehlerfall
if(DEBUG)	echo "<p class='debug err'>Fehler beim Schreiben in Datei</p>";							
		
				
			} else {
				//Erfolgsfall
				
if(DEBUG)	echo "<p class='debug ok'>Erfolgreich in der Datei geschrieben</p>";	
				// Inhalt der Datei auslesen
				echo "<p><i>". nl2br(file_get_contents("dateioperationen2.txt")) ."</i></p>";
				
				// Inhalt der Datei überschreiben
				file_put_contents("dateioperationen2.txt", "Hier steht mein neuer Content");
				echo "<p><i>". nl2br(file_get_contents("dateioperationen2.txt")) ."</i></p>";
			}
		?>
		<p>- - -</p>

		<h4>Inhalt an vorhandenen Inhalt anhängen</h4>
		<p>
			Um in Dateien schreiben zu können, existiert in PHP die Funktion
			<b>file_put_contents($filename,$content)</b>. Als Argument erwartet die 
			Funktion als erstes des Dateipfad und als zweites die Daten, die 
			in die Datei geschrieben werden sollen. Als dritter optionaler Parameter
			kann das Flag <b>FILE_APPEND</b> gesetzt werden. Hierdurch wird der Inhalt der Datei
			nicht überschrieben, sondern der neue Inhalt wird an das Ende des vorhandenen Inhalts
			angehängt.<br>
			<br>
			Ist die Datei (noch) nicht vorhanden, wird sie kurzerhand erzeugt.<br>
			Ist die Datei bereits vorhanden, wird ihr Inhalt nicht überschrieben.
		</p>
			<?php
				if(!file_put_contents("dateioperationen3.txt", "Hier steht mein Content...\r\n")){
					//fehlerfall
if(DEBUG)			echo "<p class='debug err'>Fehler beim Schreiben in Datei</p>";								
					
				} else {
					//erfolgsfall
if(DEBUG)			echo "<p class='debug ok'>Erfolgreich in der Datei geschrieben</p>";		
					// Inhalt der Datei auslesen
					echo "<p><i>". nl2br(file_get_contents("dateioperationen3.txt")) ."</i></p>";
					
					// Inhalt an Datei anhängen
					file_put_contents("dateioperationen3.txt", "Hier steht mein neuer Content...\r\n", FILE_APPEND);
if(DEBUG)			echo "<p class='debug ok'>Inhalt wird an Datei angehangen</p>";	
					
					//erneut auslesen
					echo "<p><i>". nl2br(file_get_contents("dateioperationen3.txt")) ."</i></p>";
					
				}
			?>
		
		<br>
		<hr>
		<br>
		
		<h2>Datei löschen</h2>
		<p>Mittels der Funktion <b>unlink()</b> kann eine Datei auf dem Server gelöscht werden.</p>
		
		<?php
			if(!@unlink("dateioperationen3.txt")){
				//Fehlerfall
if(DEBUG)		echo "<p class='debug err'>Fehler beim Schreiben in Datei</p>";					
			}else{
				//Erfolgsfall
if(DEBUG)		echo "<p class='debug ok'>Datei wurde gelöscht</p>";					
			}
		?>
		
		<br>
		<hr>
		<br>
		
		<h3>Ein Besucherzähler mit PHP und einer Textdatei</h3>
		<p>
			Ein Besucherzähler soll auf der Webseite anzeigen, wie oft die Seite
			bereits aufgerufen wurde. Hierzu wird eine Textdatei angelegt, in der 
			der Zähler gespeichert werden und vor jedem Speichervorgang hochgezählt
			werden soll.
		</p>
		
		<?php 
			// 1. Zählerstand auslesen
			$zaehler = file_get_contents("besucherzaehler.txt");
			
			// 2. Zähler hochzählen
			$zaehler++;
			
			// 3. Zählerstand ausgeben
			
			echo "<hr>";
			echo "<p style='text-align:center'>Sie sind Besucher Nr. <strong>$zaehler</strong></p>";
			echo "<hr>";
			
			// 4. Neuer Zählerstand speichern
			file_put_contents("besucherzaehler.txt", $zaehler);
			
		?>

</body>

</html>