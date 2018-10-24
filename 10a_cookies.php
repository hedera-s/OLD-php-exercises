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
			
			
/**********************************************************************************/


				/***********************************************/
				/********** URL-PARAMETERVERARBEITUNG **********/
				/***********************************************/
				
				// Schritt 1 URL: Prüfen, ob Parameter übergeben wurde
				if( isset($_GET['action']) ) {
if(DEBUG)		echo "<p class='debug'>URL-Parameter 'action' wurde übergeben.</p>";

					// Schritt 2 URL: Werte auslesen, entschärfen, DEBUG-Ausgabe
					$action = cleanString( $_GET['action'] );
if(DEBUG)		echo "<p class='debug'>\$action: $action</p>";

					// Schritt 3 URL: i.d.R. Verzweigung
					
					/********** COOKIE SETZEN **********/
					if( $action == "setCookie" ) {
if(DEBUG)			echo "<p class='debug'>Cookie wird gesetzt...</p>";

						// Schritt 4 URL: Daten weiterverarbeiten
						
						// setcookie("Name des Cookies", "Wert des Cookies" [, Ablaufzeit des Cookies (Timestamp)])
						setcookie("username", "Ingmar", strtotime("+1 day"));

						
					/********** COOKIE LÖSCHEN **********/	
					} elseif( $action == "deleteCookie" ) {
if(DEBUG)			echo "<p class='debug'>Cookie wird gelöscht...</p>";						
						
						// Schritt 4 URL: Daten weiterverarbeiten
						
						// Ablaufdatum des Cookies auf 1 Stunde in der Vergangenheit setzen
						setcookie("username", "Ingmar", strtotime("-1 hour"));
	
					}

				}


/**********************************************************************************/
?>

<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>Cookies</title>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/debug.css">
	</head>

	<body>
		<h1>Cookies</h1>
		<p>
			Mit Cookies hat man die Möglichkeit, bestimmte Daten während einer Folge von Aufrufen einer 
			Website festzuhalten. Mit Cookies können Daten über die Sitzung hinaus speichern (z.B. 100 Tage nach der 
			Speicherung), denn Cookies werden als Datei auf dem Computer des Besuchers gespeichert.
		</p>
		<p>
			Allerdings kann der Besucher uns natürlich verbieten, auf seinem Computer ein Cookie zu speichern, darum verwendet man 
			nur für die Speicherung von Daten während einer Folge von Aufrufen einer Website lieber Sessions. Ein Cookie benutzt man 
			z.B., um Besucher auch nach Ablauf der Session, also i.d.R. nach dem Verlassen der Homepage, eindeutig zu identifizieren. 
			Dies kann z.B. bei Umfragen benutzt werden, oder als "Wiederkehrfunktion" bei einem Forum.
		</p>
		
		<h2>Wie funktioniert das technisch?</h2>
	
		<p>
			Cookies werden auf dem PC den Seitenaufrufers gespeichert und können dort problemlos ausgelesen und manipuliert werden.
			Man sollte also keinesfalls sicherheitsrelevante Daten in einem Cookie speichern!
		</p>
		
		<p>
			Setzen eines Cookies: setcookie(Name des Cookies, Wert des Cookies [,Gültigkeitsdauer des Cookies]).<br>
			Gültigkeitsdauer: 0=bis zum Schließen des Browserfensters, ansonsten Anzahl der Sekunden seit 01.01.1970, 
			bis zum Ablauf des Gültigkeitszeitraums.<br>
			Diesen Wert berechnet man folgendermaßen: time() + 60*60*24.<br>
			Hier wird ein aktueller Timestamp erzeugt und zu diesem der Zeitraum in Sekunden addiert, für den das Cookie gültig
			sein soll.
		</p>
		<h2>Löschen des Cookies</h2>
		<p>
			Um ein Cookie per Hand zu löschen, muss man ihm einen neuen Gültigkeitswert zuweisen, der in
			der Vergangenheit liegt. Dadurch erkennt der Client-Browser, dass dieses Cookie abgelaufen ist
			und löscht es.<br>
			Es kann einige Zeit dauern, bis der Browser das Cookie tatsächlich gelöscht hat.
		</p>
		
		<hr>
		
		<p><a href="<?= $_SERVER['PHP_SELF'] ?>">Seitenaufruf ohne Parameter</a></p>
		<p><a href="?action=setCookie">Cookie setzen</a></p>
		<p><a href="?action=deleteCookie">Cookie löschen</a></p>
		
		<hr>
		
		<h2>Cookie auslesen</h2>
		
		<?php
			// Prüfen, ob ein Cookie vorhanden ist
			if( isset($_COOKIE['username']) ) {
if(DEBUG)	echo "<p class='debug'>Cookie 'username' wurde gefunden und wird nun ausgelesen...</p>";

				// Wert des Cookies auslesen, entschärfen, DEBUG-Ausgabe
				$username = cleanString($_COOKIE['username']);
if(DEBUG)	echo "<p class='debug'>\$username: $username</p>";	

				// Cookie verarbeiten
				echo "<h2>Hallo $username :)</h2>";

			} else {
if(DEBUG)	echo "<p class='debug'>Es wurde kein Cookie 'username' gefunden.</p>";				
			}
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
		
	</body>

</html>





























