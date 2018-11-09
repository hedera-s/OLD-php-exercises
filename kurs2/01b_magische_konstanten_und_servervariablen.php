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
			
			
/**********************************************************************************/
?>

	<!doctype html>

	<html>

		<head>
			<meta charset="utf-8">
			<title>Magische Konstanten & Servervariablen</title>
			<link rel="stylesheet" href="css/main.css">
			<link rel="stylesheet" href="css/debug.css">
		</head>

		<body>
			<h1>Magische Konstanten & Servervariablen</h1>
			
			<h2>Magische Konstanten</h2>
			<p>
				Es gibt in PHP 9 sog. magische Konstanten, die, abhängig davon, wo sie eingesetzt werden, 
				einen unterschiedlichen Wert haben/ausgeben.<br>
				Beispielsweise liefert die Konstante __LINE__ diejenige Zeilennummer des Codes zurück,
				in der sie aufgerufen wurde.
			</p>
			
			<ul>
				<li>__LINE__: Liefert die Zeilennummer im Code zurück, in der sie aufgerufen wurde</li>
				<li>__FILE__: Liefert den vollständigen Pfad- und Dateinamen derjenigen Datei zurück, 
				in der sie aufgerufen wurde</li>
				<li>__DIR__: Liefert den Namen des Verzeichnisses zurück, aus dem sie aufgerufen wurde</li>
				<li>__FUNCTION__: Liefert den Namen der Funktion zurück, in der sie aufgerufen wurde</li>
				<li>__CLASS__: Liefert den Namen der Klasse zurück, in der sie aufgerufen wurde</li>
				<li>__METHOD__: Liefert den Namen der Methode zurück, in der sie aufgerufen wurde</li>
			</ul>
			
			<p>
				Vollständige Liste der magischen Konstanten:<br>
				<a href="http://php.net/manual/de/language.constants.predefined.php">http://php.net/manual/de/language.constants.predefined.php</a>
			</p>
			
			<h3>Beispiele:</h3>
			<p><b>__LINE__:</b> Ich wurde aufgerufen in Zeile <i><?= __LINE__ ?></i>.</p>
			<p><b>__FILE__:</b> Ich wurde aufgerufen in Datei <i><?= __FILE__ ?></i>.</p>
			<p><b>__DIR__:</b> Ich wurde aufgerufen in Verzeichnis <i><?= __DIR__ ?></i>.</p>
			
			<br>
			<hr>
			<br>
			<?php
if(DEBUG)	echo "<p class='debug'>Zeile <b>" . __LINE__ . "</b>: Irgendeine Debug-Ausgabe...</p>";			
			?>
			
			<br>
			<hr>
			<br>
			
			<h2>Servervariablen</h2>
			<p>
				Ebenfalls gibt es in PHP einige sog. Servervariablen, die Informationen zurückliefern, die 
				serverseitig erfasst werden.<br>
				Beispielsweise liefert die Servervariable $_SERVER['SCRIPT_NAME'] den Dateinamen des aktuell 
				ausgeführten Skripts, relativ zum Document Root zurück.
			</p>
			
			<ul>
				<li>$_SERVER['SCRIPT_NAME']: Liefert den Dateinamen des aktuell ausgeführten Skripts, relativ zum Document Root zurück</li>
				<li>$_SERVER['HTTP_USER_AGENT']: Liefert die Kennung des Browsers zuück, mit dem die Seite aktuell aufgerufen wurde</li>
				<li>$_SERVER['REMOTE_ADDR']: Liefert die IP-Adresse des Clients zuück, von dem aus die Seite aktuell aufgerufen wurde</li>	
			</ul>

			<h3>
				SICHERHEIT: Es existieren noch zwei Varianten zu $_SERVER['SCRIPT_NAME']: $_SERVER['PHP_SELF'] und $_SERVER['REQUEST_URI'].
				Diese sind jedoch anfällig für sog. XSS-Attacken, also Cross-Server-Scripting. Wenn ein Hacker hinter die URL mittels eines 
				/ Schadcode einfügt, wird dieser bei beiden Varianten ausgeführt.<br>
				<br>
				Die Variante $_SERVER['SCRIPT_NAME'] hingegen ignoriert bei Ausführung alle Werte, die nach 
				dem eigentlichen Dateinamen notiert wurden (also ?action=... und /file/hack.php etc.). In der 
				URL notierter Schadcode wird dadurch nicht serverseitig ausgeführt. Deshalb gilt einzig die
				Variante $_SERVER['SCRIPT_NAME'] als einigermaßen sicher.
			</h3>

			<p>
				Vollständige Liste der PHP-Servervariablen:<br>
				<a href="http://php.net/manual/de/reserved.variables.server.php">http://php.net/manual/de/reserved.variables.server.php</a>
			</p>
			
			<h3>Beispiele:</h3>
			<p><b>$_SERVER['SCRIPT_NAME']:</b> Ich wurde aufgerufen in Datei <i><?= $_SERVER['SCRIPT_NAME'] ?></i></p>
			<p><b>$_SERVER['HTTP_USER_AGENT']:</b> Ich wurde aufgerufen mit dem Browser <i><?= $_SERVER['HTTP_USER_AGENT'] ?></i></p>
			<p><b>$_SERVER['REMOTE_ADDR']:</b> Ich wurde aufgerufen von IP Adresse <i><?= $_SERVER['REMOTE_ADDR'] ?></i></p>
			
			<br>
			<hr>
			<br>
			
			<h3>Debug-Ausgabe mit Pfadangabe:</h3>
			<?php
if(DEBUG)	echo "<p class='debug'>Zeile <b>" . __LINE__ . "</b>: Irgendeine Debug-Ausgabe... <i>(" . $_SERVER['SCRIPT_NAME'] . ")</i></p>";			
			?>
			
			<br>
			<hr>
			<br>
			
			<h3>Nur den Dateinamen ohne Pfad auslesen:</h3>
			<p>
				Manchmal benötigt man lediglich oder ausschließlich den aktuellen Dateinamen ohne Pfadangaben.<br>
				In diesem Fall schneidet die PHP-Funktion basename() lediglich den letzten String-Bestandteil
				des Pfades inkl. der Dateiendung aus.
			</p>
			
			<?php
if(DEBUG)	echo "<p class='debug'>Zeile <b>" . __LINE__ . "</b>: Irgendeine Debug-Ausgabe... <i>(" . basename(__FILE__) . ")</i></p>";			
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
			
		</body>

	</html>




























