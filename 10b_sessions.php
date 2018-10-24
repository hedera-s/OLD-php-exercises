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
		<title>Sessions</title>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/debug.css">
	</head>

	<body>
		<h1>Sessions</h1>
		<p>
			Um Daten in PHP seitenübergreifend speichern zu können, dienen sog. Sessions. Eine Session ist im Grunde genommen
			ein Array, das außerhalb der PHP-Seite in einem speziellen Verzeichnis des Webservers in Form einer Textdateigespeichert
			gespeichert wird.
		</p>
		<p>
			Sessions werden auf dem Server unter eine Session-ID (bspw. sess_dadafb244bbcb4bb84116d38f0ebd077) gespeichert 
			und sind damit vor Zugriffen von Außen geschützt.<br>
			In Sessions werden i.d.R. Variablen bzw. Werte "bis zum Ende der Session" gespeichert. 
		</p>
		<p>
			Zu jeder Session gehört ein Cookie, das auf dem Rechner des Benutzers gespeichert wird und in dem die ID der Session 
			gespeichert ist. Hierdurch wird die eindeutige Verbindung zwischen Benutzer und Session gewährleistet. Schließt der 
			Benutzer seinen Browser, wird das Cookie in seinem Browser gelöscht und die Session auf dem Server ist verwaist.
		</p>
		<p>
			Eine Session sollte nach Möglichkeit ganz am Anfang des Codes gestartet bzw. fortgesetzt werden.
			Auf jeder Seite, auf der die Session gültig sein bzw. auf der auf die Session zugegriffen 
			werden soll, muss am Anfang der Seite der Befehl session_start() gesetzt werden.
		</p>
		<p>
			<b>Aufruf:</b> session_start(). Fertig. Die Session steht nun, ähnlich wie $_GET, $_POST und $_COOKIE
			als Array zur Verfügung. In dieses Array können bliebig viele Schlüssel-Werte-Paare geschrieben 
			und später wieder ausgelesen werden.
		</p>
		
		<h3>Session starten</h3>
		<?php
			session_name("sessiontest");
			session_start();
		?>
		
		<h3>In eine Session speichern</h3>
		<p>
			Es soll der Username Ingmar in eine Session gespeichert werden. Der Befehl hierfür 
			lautet: $_SESSION['username'] = "Ingmar".
		</p>
		<?php
			$_SESSION['username'] = "Ingmar";
		?>
		
		<h3>Session auslesen</h3>
		<?php
			echo "<p>Hallo " . $_SESSION['username'] . "</p>";
		?>
		
		<h3>Weitere Werte in die Session schreiben</h3>
		<?php
			$time = date("H:i:s");
			$_SESSION['time'] = $time;
			
			echo "<h4>Hallo " . $_SESSION['username'] .  "! Schön, dass Du wieder da bist.
			Dein letzter Besuch war um " . $_SESSION['time'] . " Uhr.</h4>";
		?>
		
		<h3>Session löschen</h3>
		<h4>Einen einzelnen Wert aus der Session löschen</h4>
		<p>Die Uhrzeit soll aus der Session entfernt werden.</p>
		<?php
			// Ein einzelnes Schlüssel-Werte-Paar aus einem Array entfernen
			unset( $_SESSION['time'] );
			
			echo "<pre>";
			print_r($_SESSION);
			echo "</pre>";
			
			echo "<h4>Hallo " . $_SESSION['username'] .  "! Schön, dass Du wieder da bist.
			Dein letzter Besuch war um " . $_SESSION['time'] . " Uhr.</h4>";
		?>
		
		<h4>Die gesamte Session löschen</h4>
		<p>Das Löschen der Session kann einige Millisekunden dauern.</p>
		<?php
			// die komplette Session löschen:
			session_destroy();
			echo "<h4>Hallo " . $_SESSION['username'] .  "! Schön, dass Du wieder da bist.
			Dein letzter Besuch war um " . $_SESSION['time'] . " Uhr.</h4>";
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
		
	</body>

</html>























