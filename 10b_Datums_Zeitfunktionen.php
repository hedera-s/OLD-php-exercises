<?php
/**********************************************************************************************/
			// Timestamp für Benchmark erzeugen
			$starttime  = microtime(true);
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
		<title>Datums- und Zeitfunktionen in PHP</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="css/debug.css">
	</head>

	<body>
		<h1>Datums- und Zeitfunktionen in PHP</h1>
		<p>Es gibt in PHP prinzipiell 4 wichtige Funktionen zum Thema Zeit & Datum:</p>
		<ul>
			<li>time()</li>
			<li>date()</li>
			<li>strtotime()</li>
			<li>microtime()</li>
		</ul>
		
		<br>
		<hr>
		<br>
		
		<h2>time()</h2>
		<p>
			<b>time()</b> erzeugt einen klassischen UNIX-Timestamp (Anzahl der vergangenen Sekunden
			seit dem 01.01.1970 um 00:00:00 Uhr).
		</p>
		
		<?php
			$timestamp = time();
			echo "<p>timestamp: $timestamp</p>";
		?>
		
		<p>Timestamp von vor 1 Woche:</p>
		<?php 
			$timestampOld = time() - (60*60*24*7); //Sekunden*Minuten*Stunden*Tage
			echo "<p>timestampOld: $timestampOld</p>";
			
			
		?>
		<p>Wir viele Sekunden sind seit genau 1 Woche vergangen?</p>
		<p><?php echo $timestamp - $timestampOld ?></p>
		
		<p>
			Um einen Timestamp in einen sinnvollen Wert umzuwandeln, müssen die Sekunden
			wahlweise in Minuten, Stunden oder Tage etc. umgerechnet werden.
		</p>
		
		<p>Vergangene Sekunde seit 01.01.1970 um 00:00:00 Uhr:<b><?php echo time() ?></b></p>
		<p>Vergangene Minuten seit 01.01.1970 um 00:00:00 Uhr:<b><?php echo round(time()/60) ?></b></p>
		<p>Vergangene Stunden seit 01.01.1970 um 00:00:00 Uhr:<b><?php echo round(time()/60/60) ?></b></p>
		<p>Vergangene Tage seit 01.01.1970 um 00:00:00 Uhr:<b><?php echo round(time()/60/60/24) ?></b></p>
		<p>Vergangene Jahre seit 01.01.1970 um 00:00:00 Uhr:<b><?php echo floor(time()/60/60/24/365) ?></b></p>
		
		<br>
		<hr>
		<br>
		
		<h2>date()</h2>
		<p>Dient der Formatierung eines Timestamps in ein beliebiges Datums-/Zeitformat.</p>
		<p>
			<b>date()</b> gibt einen formatierten String anhand eines vorzugebenden Musters zurück. 
			Dabei wird entweder der angegebene Timestamp oder die gegenwärtige Zeit berücksichtigt, 
			wenn kein Timestamp angegegeben wird.<br>
			Mit anderen Worten ausgedrückt: der Parameter Timestamp ist optional und falls dieser 
			nicht angegeben wird, wird der Wert der Funktion <b>time()</b> angenommen. 
		</p>

		<p>
			Werte für die Formatierung von date():<br>
			<a href="http://php.net/manual/de/function.date.php" target="_blank">date() auf php.net</a>
		</p>
		<p class='ex'><i>Beispiel: date("d.m.Y - H:i:s")</i><p>
		<?php 
			$dateTime = date("d.m.Y - H:i:s");
			echo "<p>Datum und Uhrzeit: $dateTime</p>";
			$year = date("Y");
			echo "<p>Jahr: $year</p>";
			$time = date("H:i");
			echo "<p>time: $time</p>";
			$dateOld = date("d.m.Y", $timestampOld);
			echo "<p>Vor einer woche hatten wir $dateOld</p>";
			
			$dayOld = date("l", 0);
			echo "<p>Der 01.01.1970 war ein <b> $dayOld</b></p>";
			
			
			
		?>
		
		
		<br>
		<hr>
		<br>
		
		<h3>date()</h3>
		<p>Hilft bei der Berechnung von Daten anhand eines Datumsstrings.</p>
		<p>
			strtotime() erwartet einen String mit einem Datum im ISO (YYYY-MM-DD), American (MM/DD/YYYY) 
			oder European (DD.MM.YYYY) Datumsformat und versucht, dieses Format in einen Unix-Timestamp zu übersetzen.<br>
			Wenn nicht anders angegeben, wird die Angabe relativ zum Timestamp der aktuellen Zeit ausgewertet. 
		</p>
		
		<?php
			//ISO-Format YYYY-MM-DD
			
			$timestamp = strtotime("2009-05-31");
		?>
		
		
		<p><i>ISO-Format</i> 2009-05-31: <b><?php echo $timestamp ?></b><br>
		<?php echo $timestamp ?> entspricht dem Datum <?php echo date("Y-m-d", $timestamp)?>
		</p>
		
		
		<p><i>American-Format</i> 05/31/2009: <b><?php echo $timestamp ?></b><br>
		<?php echo $timestamp ?> entspricht dem Datum <?php echo date("m/d/Y", $timestamp)?>
		</p>
		
		
		
		<?php
			//ISO-Format YYYY-MM-DD
			
			$timestamp = strtotime("31.05.2009");
		?>
		
		<p><i>EU-Format</i> 31.05.2009: <b><?php echo $timestamp ?></b><br>
		<?php echo $timestamp ?> entspricht dem Datum <?php echo date("d.m.Y", $timestamp)?>
		</p>
		
		<p>- - -</p>
		
		<p>
			Anhand bestimmter reservierter Schlüsselworte wie "day", "week", "month" etc. lassen sich mittels 
			strtotime() auch Zeitintervalle in einen Timestamp umwandeln:
		</p>
		
		<?php 
			echo "<p>strtotime('+1day'):".strtotime('+1 day')."<br>
			enspricht dem Datum ".date('d.m.Y', strtotime('+1 day'))."
			</p>";
			echo "<p>strtotime('+1 week'):".strtotime('+1 week')."<br>
			enspricht dem Datum ".date('d.m.Y', strtotime('+1 week'))."
			</p>";
			echo "<p>strtotime('next wednesday'):".strtotime('next wednesday')."<br>
			enspricht dem Datum ".date('d.m.Y', strtotime('next wednesday'))."
			</p>";
			echo "<p>strtotime('last sunday'):".strtotime('last sunday')."<br>
			enspricht dem Datum ".date('d.m.Y', strtotime('last sunday'))."
			</p>";
			echo "<p>strtotime('+1 week 2 days 4 hours 12 minutes'):".strtotime('+1 week 2 days 4 hours 12 minutes')."<br>
			enspricht dem Datum ".date('d.m.Y - H:i', strtotime('+1 week 2 days 4 hours 12 minutes'))."
			</p>";
			
			
		?>
		
		<h2>microtime()</h2>		
		<p>microtime() gibt den aktuellen Unix-Timestamp/Zeitstempel mit Mikrosekunden zurück.</p>
		<p>
			Standardmäßig gibt microtime() einen String im Format "Mikrosekunden Sekunden" zurück.
			Die Sekunden stellen die Anzahl der Sekunden dar, die seit dem 01.01.1970 um 00:00:00 Uhr vergangen sind.
			Die Mikrosekunden geben zuzüglich zu den vergangen Sekunden die fehlenden Microsekunden an.
		</p>
		<p>
			Wird microtime(true) als optionaler Parameter "true" mitgegeben, erfolgt die Rückgabe 
			des Timestamps als Float.
		</p>
		<?php
			echo "<p>microtime(true): " . microtime(true) . "</p>";
		?>
		
		<hr>
		
		<h3>microtime() als Timer bzw. Benchmark</h3>
		<p>
			microtime() kann beispielsweise als Timer bzw. Benchmark eingesetzt werden, um zu prüfen, 
			wie lange die Ausführung eines PHP-Skripts dauert:
		</p>

		<p>
			Der Timer wird hierzu am Anfang des PHP-Skripts gestartet, indem der Rückgabewert von
			microtime() in eine Variable geschrieben wird. Am Ende des Skripts wird ebenfalls der Wert
			von microtime() in eine zweite Variable geschrieben. Zieht man nun den Wert der Startvariable
			vom Wert der Endvariable ab, erhält man die Zeit, die das Skript benötigt hat, um den Code 
			zwischen diesen beiden Markern auszuführen.
		</p>
		
		<?php
		// Für eine längere Ausführungszeit des PHP-Skripts wird ein länger dauernder Prozess angestoßen
		for($i=0; $i < 15; $i++){
			//Simulation einer Bruteforce-Attake
			//md5("test"); 								// 3 000 000 Durchläufe / Sekunde
			//sha1("test"); 							// 3 000 000 Durchläufe / Sekunde
			password_hash("test", PASSWORD_DEFAULT); 	// 15 Durchläufe / Sekunde
		}
		
		$stoptime = microtime(true);
		//Ausführungszeit berechnen
		
		$bench = $stoptime - $starttime;
		$bench = round($bench, 4);
		
		//Ausgabe im Frontend ausgeben
		echo "<hr>";
		echo "<p>Ausführungszeit des PHP-Scripts:</p><br> <h1>$bench Sekunden</h1>";
		echo "<hr>";
		?>
		
		
		
		
		
		
		
		
		
		
		
		
</body>

</html>