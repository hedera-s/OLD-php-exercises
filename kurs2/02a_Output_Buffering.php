<?php
/*************************************************************************************/


				/***********************************/
				/********** CONFIGURATION **********/
				/***********************************/

				/********** INCLUDES **********/
				// include(Pfad zur Datei): Bei Fehler wird das Skript weiter ausgeführt. Problem mit doppelter Einbindung derselben Datei
				// require(Pfad zur Datei): Bei Fehler wird das Skript gestoppt. Problem mit doppelter Einbindung derselben Datei
				// include_once(Pfad zur Datei): Bei Fehler wird das Skript weiter ausgeführt. Kein Problem mit doppelter Einbindung derselben Datei
				// require_once(Pfad zur Datei): Bei Fehler wird das Skript gestoppt. Kein Problem mit doppelter Einbindung derselben Datei
				require_once("include/config.inc.php");


/*************************************************************************************/
?>

<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>Output Buffering</title>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/debug.css">
	</head>

	<body>
		<h1>Output Buffering</h1>
		<p>
			Output Buffering erstellt auf dem Server einen Speicherbereich, in dem Frontend-Ausgaben 
			gespeichert (und nicht sofort im Frontend ausgegeben) werden, bis der Buffer-Inhalt
			explizit gesendet werden soll.
		</p>
		<?php
			// output Buffering aktivieren
			if(ob_start()){
if(DEBUG)		echo "<p class='debug ok'><b>Line " . __LINE__ . ":</b> Output Buffering erfolgreich gestartet <i>(" . basename(__FILE__) . ")</i></p>";
				
			}else{
if(DEBUG)		echo "<p class='debug err'><b>Line " . __LINE__ . ":</b> Fehlet beim Starten des Output Bufferings <i>(" . basename(__FILE__) . ")</i></p>";		
			
			}
		?>
		
		<p>
			Alle Frontendausgaben werden nun zwischengespeichert und NICHT sofort im Frontend ausgegeben.
			So wie diese hier. Jedenfalls im Prinzip. Denn am Ende des Codes wird der Output Buffer
			immer automatisch gesendet, wenn er nicht vorher gelöscht wurde.<br>
			<br>
			Die Inhalte im Buffer können mittels ob_get_contents() ausgelesen und zwischengespeichert werden:
		</p>
		
		<?php
			//Anzeigen des Buffer-Status
if(DEBUG)		echo "<pre class='debug'><b>Line  " . __LINE__ .  "</b> <i>(" . basename(__FILE__) . ")</i>:<br>";					
if(DEBUG)		print_r(ob_get_status());					
if(DEBUG)		echo "</pre>";	

				//Speichern des Buffe-Inhalts als String in eine Variable
				$bufferContent1 = ob_get_contents();
				
				//Löschen des Buffer-Inhalts
				ob_clean();
				
		?>
		
		<p>
			Durch das Löschen des Buffer-Inhalts wird nun keine Frontendausgabe erzeugt. Allerdings befindet
			sich die Ausgabe nun in der Variable $content, die nun gezielt mittels echo ausgegeben
			werden kann. Die oben erzeugten Frontend-Ausgaben werden jetzt also unter diesem Absatz 
			ausgegeben:
		</p>
		
		<?=$bufferContent1 ?>
		
		<p>
			Mittels ob_end_flush() kann der Bufferinhalt an das Frontend gesendet und der 
			Buffer anschließend gelöscht werden. Das Output Buffering wird hierbei automatisch 
			beendet.
		</p>

		<p>
			Buffering lässt sich nach Belieben verschachteln.
		</p>
		
		<h3 class="error">
			Hinweis: Output Buffering sollte unbedingt mit großer Vorsicht verwendet werden,
			da man explizit den Workflow des PHP-Dokuments ändert. Fehler und Inkonsistenzen sind hierbei
			oftmals quasi vorprogrammiert.
		</h3>

		<h4 class="success">
			Bei der Verwendung von session_start() oder der header()-Funktion kann das Output Buffering
			allerdings gute Dienste leisten, falls man doch einmal zwingend eine Frontend-Ausgabe vor
			deren Verwendung benötigt. Das Output Buffering speichert nämlich auch den HTTP-Header 
			zwischen, so dass trotz bereits abgesendetem HTTP-Header noch eine Session oder eine Umleitung 
			eingefügt werden kann.
		</h4>

		<p>
			Bei Verwendung des Output Bufferings muss einem bewusst sein, dass man mittels vorzeitigem
			Einsatz von ob_flush() etc. des Workflow des Codes durcheinanderanderbringt (vor allem natürlich 
			auch bei verschachteltem Buffering). Man muss hierbei schon sehr genau wissen, was man tut. 
			Sicherer ist es, den Buffer nicht per Hand zu senden. Wenn das Script zuende abgearbeitet ist, #
			wird der Bufferinhalt automatisch gesendet und geleert, so dass die Reihenfolge der gepufferten #
			Ausgaben erhalten bleibt.
		</p>
		
		<?php
			// Output Buffering aktivieren
			if( ob_start() ) {
				if(DEBUG) echo "<p class='debug ok'>Line " . __LINE__ . ": Output Buffering gestartet...</p>"; 
			}
			echo "<p>Das ist eine Ausgabe VOR dem Anlegen einer Session.</p>";

		?>
		<p>
			Auf einem Live-System würde an dieser Stelle vermutlich folgende Fehlermeldung 
			geworfen werden:<br>
			<br>
			<b>Warning: Cannot modify header information - headers already sent by 
			(output started at /some/file.php:12) in /some/file.php on line 23</b>
		</p>
		<?php
			session_start();

			// Output Buffer-Inhalt senden und Buffer löschen
		if( ob_end_flush() ) {
			if(DEBUG) echo "<p class='debug ok'>Line " . __LINE__ . ": Output Buffer-Inhalt gesendet und anschließend gelöscht. Buffering ist deaktiviert.</p>"; 
		}
		?>
		
		<h3 class="info">
			Dennoch handelt sich beim Output Buffering quasi um eine Art 'Hack'. Der Workflow des Codes wird korrumpiert 
			und abgeändert, was eine Verfolgung der Programmabläufe extrem erschweren kann.<br>
			Aus diesem grund ollte das Output Buffering am besten einmal am Beginn der Seite gestartet 
			und ganz am Ende schließlich übertragen werden. Somit bleibt der eigentliche Workflow der Seite intakt.
		</h3>
				
		
		
	</body>

</html>