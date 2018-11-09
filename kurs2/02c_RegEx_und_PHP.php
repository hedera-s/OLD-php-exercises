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
		<title>Reguläre Ausdrücke (RegEx) und PHP</title>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/debug.css">
	</head>

	<body>
		<h1>Reguläre Ausdrücke (RegEx) und PHP</h1>
		<p>
			Reguläre Ausdrücke dienen dazu, zumeist einen String auf einen bestimmten Inhalt zu überprüfen, bspw.
			ob sich in ihm ausschließlich Zahlen oder Buchstaben, Sonderzeichen etc. befinden.<br>
			<br>
			Hierfür wird mittels eines Regulären Ausdrucks ein Muster erstellt, anhand dessen dann 
			der String geprüft wird. Für diese Prüfung dient in PHP die Funktion preg_match(), die 
			true zurückliefert, wenn der String dem Muster entspricht, oder false, wenn der String 
			nicht dem Muster entspricht.
		</p>
		<p>
			Ein Regulärer Ausdruck ist immer ein String, der mit jeweil einem / beginnt und endet.
			Zwischen den beiden /.../ befindet sich das eigentliche Muster.
		</p>
		<p>
			Beispiel: $pattern = '/1[0123456789]/';
		</p>
		<p>
			Die [] stehen in diesem Fall für eine Stelle des Strings, in dem sich eine der innerhalb der []
			notierten Ziffern befinden muss. Die 1 vor den [] bedeutet, dass der String mit 
			einer 1 beginnen muss.
		</p>
		<p>
			<strong>Hinweis</strong>: Da PHP innerhalb von doppelten Anführungszeichen ("") ggf. 
			vorhandene Steuerzeichen interpretiert, sollten RegEx-Muster besser innerhalb von 
			einfachen Anführungszeichen ('') notiert werden, damit bestimmte Steuerzeichen wie 
			beispielsweise $ nicht PHP-seitig interpretiert werden.
		</p>

		<br>
		<hr>
		<br>
		
		
		<h2>Beispiel 1 für ein einfaches Muster</h2>
		<p>Es soll geprüft werden, ob ein String eine Zahl zwischen 10 und 19 enthält:</p>
		
		<?php
			// Die 1 ist Pflicht, dahinter muss eine beliebige Ziffer zwischen 0 und 9 
			// stehen, jedes weitere Zeichen im String wird nicht geprüft
			$pattern = '/1[0123456789]/';
			$string = "Peter ist 1 Jahre alt";
			echo "<p><i>string: $string</i></p>";
			
			if(preg_match($pattern, $string)){
				//Erfolgsfall
				echo "<p class='success'>Der String enthält das vorgegebene Muster</p>";
			}else{
				//Fehlerfall
				echo "<p class='error'>Der String enthält nicht das vorgegebene Muster</p>";
			}
			
			echo preg_match($pattern, $string) ? "<p class='success'>Der String enthält das vorgegebene Muster</p>" : "<p class='error'>Der String enthält nicht das vorgegebene Muster</p>";
			/*
			Ausgabe/in Variable speichern BEDINGUNG ? falls true, tue dies : falls false, tue das
			*/
		?>
		
		<br>
		<hr>
		<br>
		
		<h2>Beispiel 2 für ein einfaches Muster</h2>
		<p>Es soll geprüft werden, ob ein String eine ungerade Zahl zwischen 501 und 999 enthält:</p>
		
		<?php
			// 1. Ziffer muss 5,6,7,8 oder 9 lauten;
			// 2. Ziffer muss zwischen 0 und 9 lauten;
			// 3. Ziffer muss 1,3,5,7 oder 9 lauten (ungerade)
			// alternativ zu [0123456789] kann man auch [0-9] schreiben
			
			$pattern = '/[56789][0-9][13579]/';
			$string = "Peters Hamster hat 54345 Junge geworfen";
			
			echo "<p><i>string: $string</i></p>";
			
			if(preg_match($pattern, $string)){
				//Erfolgsfall
				echo "<p class='success'>Der String enthält das vorgegebene Muster</p>";
			}else{
				//Fehlerfall
				echo "<p class='error'>Der String enthält nicht das vorgegebene Muster</p>";
			}
			
			
		?>
		
		<br>
		<hr>
		<br>

		<h2>Beispiel 3 für ein etwas komplexeres Muster</h2>
		<p>
			Es soll geprüft werden, ob ein String mindestens 3 Buchstaben gefolgt von
			mindestens 2 Ziffern enthält:
		</p>
		<?php
			// Mindestens 3 Zeichen müssen Buchstaben sein (groß oder klein)
			// gefolgt von mindestens 2 Zeichen als Ziffern
			// Die {} geben an, wie oft das vorher notierte Element MINDESTENS vorkommen muss
			
			$pattern 	= '/[a-zA-ZäÄöÖüÜß]{3}[0-9]{2}/';
			$string 	= "Peters Hamster hält nun seit rrasdßr12 Stunden ein Nickerchen"; 
			
			echo "<p><i>string: $string</i></p>";
			
			if(preg_match($pattern, $string)){
				//Erfolgsfall
				echo "<p class='success'>Der String enthält das vorgegebene Muster</p>";
			}else{
				//Fehlerfall
				echo "<p class='error'>Der String enthält nicht das vorgegebene Muster</p>";
			}
			
		?>
		
		<br>
		<hr>
		<br>

		<h2>Beispiel 4 für ein noch komplexeres Muster</h2>
		<p>
			Es soll geprüft werden, ob ein String genau 3 Buchstaben gefolgt von
			genau 2 Ziffern enthält:
		</p>
		
		<?php
		
		// ^ steht für den Anfang des Strings
		// $ steht für das Ende des Strings
		// Zwischen ^ und $ sind keine Abweichungen vom Muster erlaubt
		//Bei fester begrenzung des Patterns wird aus den {}-mindestens ein {}-genau
		//Mann kann jedoch mittels {2,6} eine quantitative Range erstellen
				
		$pattern = '/^[a-zA-Z]{3,5}[0-9]{2}$/';
		$string = "daswd23";
		
		echo "<p><i>string: $string</i></p>";
			
		if(preg_match($pattern, $string)){
			//Erfolgsfall
			echo "<p class='success'>Der String enthält das vorgegebene Muster</p>";
		}else{
			//Fehlerfall
			echo "<p class='error'>Der String enthält nicht das vorgegebene Muster</p>";
		}
		
		
		?>
		
		
		<br>
		<hr>
		<br>
		
		<h2>Beispiel 5 für ein komplexes Muster (Email-Validierung)</h2>
		<p>
			Es soll geprüft werden, ob eine Email-Adresse ausgeführt<br>
			mindestens 1 Zeichen gefolgt von<br>
			genau einem @-Zeichen gefolgt von<br>
			mindestens 1 Zeichen gefolgt von<br>
			genau 1 Punkt (.) gefolgt von<br>
			mindestens 1 Buchstaben besteht:
		</p>
		
		<?php
			// Es sind erlaubt alle Klein- und Großbuchstaben inkl. Umlauten sowie alle Ziffern und . - _
			// gefolgt von genau 1 @
			// gefolgt von beliebigen Klein- und Großbuchstaben inkl. Umlauten oder allen Ziffern und . - _
			// gefolgt von genau 1 Punkt (.)
			// gefolgt von beliebigen Klein- und Großbuchstaben inkl. Umlauten
			// Das + bedeutet, das vor dem + notierte Pattern MUSS mindestens 1mal vorkommen
			$pattern = '/^[a-zA-ZäÄöÖüÜß0-9.-_]+@[a-zA-ZäÄöÖüÜß0-9.-_]+.[a-zA-ZäÄöÖüÜß]+$/';
			$string = "asd@btutzu.czzuuz";
			
			echo "<p><i>string: $string</i></p>";
			
			if(preg_match($pattern, $string)){
				//Erfolgsfall
				echo "<p class='success'>Der String entspricht dem vorgegebenen Muster</p>";
			}else{
				//Fehlerfall
				echo "<p class='error'>Der String  entspricht nicht dem vorgegebenen Muster</p>";
			}
			
			
			
		?>
		
		<br>
		<hr>
		<br>

		<h2>preg_replace() - Ersetzung mittels RegEx</h2>
		<p>
			Neben der Funktion preg_match() gibt es noch weitere PHP-Funktionen, die 
			mit Hilfe regulärer Ausdrücke arbeiten. preg_replace beispielsweise arbeitet 
			ähnlich wie str_replace() und ersetzt einen Teilstring anhand eines Musters.<br>
			<br>
			<code>preg_replace($pattern, $replacement, $haystack)</code>
		</p>
		<h3>Beispiel: Wir bauen uns einen einfachen Schimpfwortfilter:</h3>
		
		<?php
			// Es muss der Teilstring 'scheiß' bzw. 'Scheiß' vorkommen,
			// optional gefolgt von einem 'e' (ohne das 'e' würde von
			// 'Scheiße' das 'e' unverändert stehenbleiben)
			// Das ? bedeutet, dass das vorherige Zeichen optional ist
			
			$pattern = '/scheiß[e]?[n]?|Scheiß[e]?[n]?/';
			// alternativ (besser, weil hier auch Schreibweisen wie 'SchEiße' mit abgefangen werden):
			// das 'i' hinter dem letzten / bedeutet, dass Groß- bzw. Kleinschreibung im String ignoriert wird
			$pattern = '/scheiß[e]?|scheiss[e]?/i';
			$string = "Ainane scheiße scheisstralala lala bla lbabla Ainane! Scheiße! Yay!";
			
			$replacement = "&#9724;&#9724;&#9724;&#9724;";
			
			echo "<p><i>". preg_replace($pattern, $replacement, $string) . "</i></p>";
			
			
		?>
		
		<br>
		<hr>
		<br>

		<h3>Einige Beispiele für RegEx-Notationen:</h3>
		<ul>
			<li><b>[abc]</b> - A single character: a, b or c</li>
			<li><b>[^abc]</b> - Any single character but a, b, or c</li>
			<li><b>[a-z]</b> - Any single character in the range a-z</li>
			<li><b>[a-zA-Z]</b> - Any single character in the range a-z or A-Z</li>
			<li><b>^</b> - Start of line</li>
			<li><b>$</b> - End of line</li>
			<li><b>\A</b> - Start of string</li>
			<li><b>\z</b> - End of string</li>
			<li><b>.</b> - Any single character</li>
			<li><b>\s</b> - Any whitespace character</li>
			<li><b>\S</b> - Any non-whitespace character</li>
			<li><b>\d</b> - Any digit</li>
			<li><b>\D</b> - Any non-digit</li>
			<li><b>\w</b> - Any word character (letter, number, underscore)</li>
			<li><b>\W</b> - Any non-word character</li>
			<li><b>\b</b> - Any word boundary character</li>
			<li><b>(...)</b> - Capture everything enclosed</li>
			<li><b>(a|b)</b> - a or b</li>
			<li><b>a?</b> - Zero or one of a</li>
			<li><b>a*</b> - Zero or more of a</li>
			<li><b>a+</b> - One or more of a</li>
			<li><b>a{3}</b> - At least 3 of a</li>
			<li><b>a{3,}</b> - 3 or more of a</li>
			<li><b>a{3,6}</b> - Between 3 and 6 of a</li>
		</ul>

		<br>
		<hr>
		<br>

		<h2>Weiterführende Links</h2>

		<p><a href="http://www.rexegg.com/regex-quickstart.html">Regex Cheat Sheet</a></p>
		<p><a href="http://www.php.net/manual/de/ref.pcre.php">PCRE-Funktionen in PHP.net</a></p>

		<br>
		<hr>
		<br>
		
	</body>

</html>