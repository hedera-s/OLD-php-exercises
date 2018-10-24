<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>Stringoperationen</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<h1>Stringoperationen</h1>
		
		<?php
			$meinString1 = "Das ist ein String.";
			$meinString2 = "Und das hier ist noch ein String.";
			
		?>
		
		<h3>Ausgangssituation:</h3>
		<p>$meinString1: <i><?php echo $meinString1 ?></i></p>
		<p>$meinString2: <i><?php echo $meinString2 ?></i></p>
		
		<br>
		<hr>
		<br>
		
		<h2>str_replace() - kann Zeichen innerhalb eines Strings ersetzen</h2>
		<p class="ex">str_replace(needle,replacement,haystack)</p>
		<p>Ziel: Aus <i>Das ist ein String.</i> soll werden <i>Das ist ein Hund.</i></p>
		<?php echo str_replace("String", "Hund", $meinString1) ?>
		
		<h2>str_shuffle() - mischt alle Zeichen eines Strings durcheinander</h2>
		<p class="ex">str_shuffle(String)</p>
		<?php echo str_shuffle("Hallo") ?>
		
		<h2>mb_strlen() - liest die Anzahl der Zeichen innerhalb eines Strings aus</h2>
		<p class="ex">strlen(String)</p>
		<?php echo mb_strlen($meinString1) ?>
		
		<p class="w">
			Achtung: Die Funktion strlen() zählt nicht wirklich Zeichen, sondern die Bytes, die von diesen Zeichen im Speicher belegt 
			werden.<br>
			Umlaute belegen mehr Bytes als einfache Zeichen und geben daher eine falsche String-Länge zurück. Um dieses Problem zu umgehen, 
			muss für UTF-8-kodierte Strings die Funktion Multibyte-StringLength (mb_strlen()) verwendet werden, der man die aktuelle 
			Zeichenkodierung als Parameter mitgeben kann.<br><br>
			Beispiel: echo mb_strlen($string, 'UTF-8')
		</p>
		
		<h2>str_word_count() - zählt die Anzahl der Worte in einem String</h2>
		<p class="ex">str_word_count(String, 0, "äÄöÖüÜß")</p>
		<?php echo str_word_count($meinString1)?>
		
		<h2>strpos() - findet das erste Vorkommen eines Teilstrings innerhalb eines Strings (fängt bei 0)</h2>
		<p class="ex">strpos(haystack, needle)</p>
		<p class="w">Die Variante str<b>i</b>pos() ist case insensitive.</p>
		<?php echo strpos($meinString1, "ein") ?>
		
		<h2>substr() - schneidet einen Teil Strings aus und gibt diesen Teil zurück</h2>
		<p class="ex">substr(haystack, startposition [, length])</p>
		<p>Schneinde einen Teilstring ab Zeichen 12 aus: <i><?php echo substr($meinString1, 12) ?></i></p>
		<p>Schneinde von Vorn 20 Zeichen aus: <i><?php echo substr($meinString2, 0, 20) ?></i></p>
		<p>Schneinde ab Zeichen 13 die folgenden 8 Zeichen aus: <i><?php echo substr($meinString2, 13, 8) ?></i></p>
		<p>Schneinde von hinten gezählt 20 Zeichen aus: <i><?php echo substr($meinString2, -20) ?></i></p>
		<p>Schneinde von hinten gezählt ab Zeichen 20 die folgenden 8 Zeichen aus: <i><?php echo substr($meinString2, -20, 8) ?></i></p>
		
		
		
		<h3>Praxisbeispiel: Dateiendung auslesen</h3>
		<?php 
			$meineDatei = "meinBild.jpg";
			$position = stripos($meineDatei, ".");
					
		?>
		<p>Position des Punkts im Dateistring <?php echo $position ?></p>
		<p>Dateiendung von <i><?php echo $meineDatei ?></i>: <?php echo substr($meineDatei, $position +1) ?></p>
		
		
		
		
		
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