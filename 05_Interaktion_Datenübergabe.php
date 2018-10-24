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
					
					
					
/**********************************************************************************************/	
			
			/**********************************************/
			/*********** INITIALIZE VARIBLES **************/
			/**********************************************/
			
			$content = NULL;
			
/**********************************************************************************************/	
					

			/**************************************************/
			/*********** URL-PARAMETERVERARBEITUNG ************/
			/**************************************************/

			
			// Schritt 1 URL: Prüfen, ob URL-Parmeter übergeben wurden
			if(isset($_GET['action'])){
if(DEBUG)		echo "<p class='debug'>URL-Peremeter 'action' wurde übergeben</p>";
				
				// Schritt 2 URL: Werte auslesen, entschärfen, DEBUG-Ausgabe
				
				// SICHERHEIT: Damit so etwas nicht passiert: ?action=<script>alert("HACK!")</script>
				// muss der empfangene String ZWINGEND entschärft werden!
				// htmlspecialchars() wandelt potentiell gefährliche Steuerzeichen wie
				// < > "" & in HTML-Code um (&lt; &gt; &quot; &amp;)
				// trim() entfernt vor und nach dem String alle Leerzeichen, Tabulatoren und Zeilenumbrüche
				$action = htmlspecialchars($_GET['action']);
if(DEBUG)		echo "<p class='debug'>action: $action</p>";	

				//Schritt 3 URL: in der Regel Verzweigen

				/*************** ZEIGE NEWS ****************/	
				if( $action == "showNews" ){
if(DEBUG)			echo "<p class='debug'>Zeige News...</p>";	
					
					// Schritt 4 URL: Daten weiterverarbeiten
					
					$content = "<h3>Heute frisch aus den Nachrichten</h3>";
					$content .= "<p>Blablabla bla bla blabla blaaa!</p>";
					
				/*************** ZEIGE WETTER **************/
				} elseif ($action == "showWeather") {
if(DEBUG)			echo "<p class='debug'>Zeige Weather...</p>";
						
					// Schritt 4 URL: Daten weiterverarbeiten
					$content = "<h3>Heute frisch aus den Nachrichten</h3>";
					$content .= "<p>Wir werden alle sterben! Huraaaa!</p>";

				}
				
			}
			

/**********************************************************************************************/

			/*********************************************/
			/*********** FORMULARVERARBEITUNG ************/
			/*********************************************/
			
			
			// Schritt 1 FORM: Prüfen, ob Formular abgesendet wurde
			if(isset($_POST['formsent'])){
if(DEBUG)		echo "<p class='debug'>Formular wurde abgeschickt.</p>";

				//Schritt 2 FORM: Werte auslesen , entschärfen, DEBUG-Ausgabe
				
				// SICHERHEIT: Damit so etwas nicht passiert: ?action=<script>alert("HACK!")</script>
				// muss der empfangene String ZWINGEND entschärft werden!
				// htmlspecialchars() wandelt potentiell gefährliche Steuerzeichen wie
				// < > "" & in HTML-Code um (&lt; &gt; &quot; &amp;)
				// trim() entfernt vor und nach dem String alle Leerzeichen, Tabulatoren und Zeilenumbrüche
				$firstname = trim(htmlspecialchars($_POST['firstname']));
				$lastname = trim(htmlspecialchars($_POST['lastname']));
				$birthdate = trim(htmlspecialchars($_POST['birthdate']));
if(DEBUG)		echo "<p class='debug'>firstname: $firstname</p>";			
if(DEBUG)		echo "<p class='debug'>lastname: $lastname</p>";			
if(DEBUG)		echo "<p class='debug'>birthdate: $birthdate</p>";

				// Schritt 3 FORM: Optional: Werte Validieren
				
				// Schritt 4 FORM: Daten weiterverarbeiten
				$content = "<p>Hallo $firstname $lastname<br>
							Dein Geburtsdatum ist der $birthdate</p>";
				
			}

/**********************************************************************************************/	
?>
<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>Interaktion - Datenübergabe ($_GET, $_POST)</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="css/debug.css">
	</head>

	<body>
		<h1>Interaktion - Datenübergabe ($_GET, $_POST)</h1>
		
		<p>
			Daten werden innerhalb von PHP-Seiten entweder über die URL (Linkparameter) 
			oder über ein Formular von einer Seite an die nächste weitergereicht.<br>
			Diese Daten/Parameter werden vom PHP-Code abgefangen und anschließend weiterverarbeitet.
		</p>
		<p>
			Diese Daten werden in PHP mittels der Methoden $_GET bzw. $_POST von einer
			PHP-Seite an eine andere (oder an sich selbst) übergeben.<br>
		<br>
			Auf der nächsten Seite können diese übergebenen Werte dann ausgelesen und 
			anschließend weiterverarbeitet werden.
		</p>
		<p class="w">
			<b>Merke:</b> Alle Daten, egal ob via URL-Parameter oder via Formularfelder werden
			als Datentyp String übergeben. Genau deshalb verfügt PHP von Hause aus über 
			keine feste Datentypisierung und interpretiert bei mathematischen Berechnungen 
			oder vergleichen einen String als Integer.
		</p>
		
		<br>
		<hr>
		<br>
		<h2>$_GET (Parameterübergabe via URL)</h2>
		<p>
			Die "Methode" $_GET liest Parameter aus, die über die URL übergeben wurden,
			also beispielsweise www.meineseite.de?action=showNews&range=lastMonth.
		</p>
		<p>
			Die Syntax zu dieser URL folgt dem Schema "name-der-webseite?parameter1=wert1&amp;parameter2=wert2 ..."
		</p>
		<h4>Links für die Seitensteuerung</h4>
		<p><a href="<?php echo $_SERVER['SCRIPT_NAME'] ?>">Seitenaufruf ohne Parameter</a></p>
		<p><a href="?action=showNews">Zeige Nachrichten</a></p>
		<p><a href="?action=showWeather">Zeige Wetter</a></p>
		
		<br>
		<hr>
		<br>
		
		<?php echo $content ?>
		
		<br>
		<hr>
		<br>
		
		<h2>$_POST (Datenübergabe mittels Formular)</h2>
		<p>
			Diese Methode funktioniert ausschließlich mit HTML-Formularen. Jedes Formularfeld 
			dient hierbei als Wert, den es zu übergeben gilt.<br>
		<br>
			Der Name des Feldes ist automatisch der Name des Keys(Indizes), über den später auf den jeweiligen
			Wert zugegriffen werden kann.
		</p>
		
		<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
			
			<input type="hidden" name="formsent">
				
			<input type="text" name="firstname" placeholder="Vorname"><br>
			<input type="text" name="lastname" placeholder="Nachname"><br>
			<input type="text" name="birthdate" placeholder="Geburtsdatum"><br>
			<input type="submit" value="Absenden"><br>
			
			
		</form>
		
		
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