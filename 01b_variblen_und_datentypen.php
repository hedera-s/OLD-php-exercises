<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>Variablen und Datentypen</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<h1>Variablen und Datentypen</h1>
		<h2>Datentypen für Variablen</h2>
		<p>
			PHP benutzt sog. Variablen, um Werte zu speichern und weiter zu verarbeiten.
			Diese Variablen können mit einer bestimmten Art von Werten umgehen. Hierzu gehören:
		</p>
		<ul>
			<li>Zeichenketten (String)</li>
			<li>Ganze Zahlen (Integer)</li>
			<li>Zahlen mit Nachkommastellen (Double/float)</li>
			<li>Felder (Array)</li>
			<li>Objekte</li>
			<li>Wahrheitswert (Boolean)</li>
		</ul>

		<p>
			Anders als in sog. Hochsprachen wird der Datentyp in PHP nicht vom Programmierer
			festgelegt, sondern richtet sich nach dem aktuellen Inhalt der Variable. So kann in einer
			Variable beispielsweise anfangs ein String stehen, später vielleicht aber ein Integer.
		</p>
		<h2>Namen bzw. Benennung von Variablen</h2>
		<p>
			Der Name einer Variablen in PHP beginnt immer mit einem Dollarzeichen ($).<br>
			Der Name selbst ist frei wählbar (solange er nicht gleichlautend mit vorbelegten PHP-Funktionen ist).
			Der Name kann aus großen und/oder kleinen Buchstaben, Ziffern und _ bestehen.<br>
			Beginnen muss der Name immer mit einem Buchstaben. Es gilt also:
		</p>
		<ul>
			<li>keine Leerzeichen</li>
			<li>keine Sonderzeichen außer _</li>
			<li>erlaubt sind Buchstaben (case sensitive) und Zahlen</li>
			<li>muss mit einem Buchstaben beginnen</li>
			<li>sollte kein von PHP reserviertes Wort darstellen (echo, exit, date...)</li>
			<li>sollte "sprechend" und selbsterklärend sein (Name des Users: $username = gut; $u = schlecht)</li>
			<li>sollte aus Kleinbuchstaben oder aus einer Mischung aus Klein- und Großbuchstaben bestehen
			(keine reinen GROSSBUCHSTABEN)</li>
		</ul>
		
		<?php
			// Beispiele für Variablennamen
			// Eine Variable wird in PHP zuerst deklariert (benannt)
			// und schließend mittels = initialisiert (mit einem Wert gefüllt)
			$firstname		= "Ingmar";				// Datentyp String
			$lastname 		= "Ehrig";				// Datentyp String
			$age			= 28;					// Datentyp Integer
			$amountOfCars 	= "2"; 					// String
			$price 			= 199.3;				// float
			$claim			= "Ainane naneschechki";// String
			$isOnline		= true;					// Boolean
			$isOffline 		= false;				// Boolean
			
			// In PHP lassen sich alle Datentypen und alle Werte aus Boolsche Werte interpretieren.
			// Solange ein Wert "messbar" ist, ergibt er true, ansonsten false
			$isOnline		= 1;					// Datentyp Integer -> Boolean true
			$isOffline 		= 0;					// Datentyp Integer -> Boolean false
			$isOnline		= -10.5;				// Datentyp Float 	-> Boolean true	
			$isOnline		= "Ein Wert";			// Datentyp String 	-> Boolean true	
			$isOnline		= "";					// Datentyp String 	-> Boolean false	
			$isOnline		= " ";					// Datentyp String 	-> Boolean true	
			$isOffline		= "false";				// Datentyp String 	-> Boolean true	
			$isOffline		= NULL;					// KEIN Datentyp 	-> Boolean false	
			
		?>
		
		<br>
		<hr>
		<br>
		
		<h3>Ausgabe der Variablen im Frontend</h3>
		<?php
		// Unterschied zwischen doppelten " und einfachen ':
		// Alles, was zwischen ' und ' steht, wird als String interpretiert und
		// entsprechend 1:1 mittels echo ausgegeben
			echo '<p>Variable $firstname: $firstname</p>' ;
			// Innerhalb von " und " können einfache Variablenwerte direkt als Wert ausgegeben
			// (interpretiert) werden
			echo "<p>Variable $firstname: $firstname</p>" ;
			// Sollen innerhalb von ' und ' Variablenwerte ausgegeben werden, muss der String
			// konkateniert (aneinandergereiht) werden
			echo '<p>Variable $firstname: ' . $firstname . '</p>';
			// Soll eine Variable innerhalb von " und " nicht als Wert interpretiert werden, 
			// muss sie mittels \ entschärft (escaped) werden
			echo "<br>";
			echo "<p>Variable \$firstname: $firstname</p>" ;
			echo "<p>Variable \$lastname: $lastname</p>" ;
			echo "<p>Variable \$age: $age</p>" ;
			echo "<p>Variable \$amountOfCars: $amountOfCars</p>" ;
			echo "<p>Variable \$price: $price</p>" ;
			echo "<p>Variable \$claim: $claim</p>" ;
			echo "<p>Variable \$isOnline: $isOnline</p>" ;
			echo "<p>Variable \$isOffline: $isOffline</p>" ;
			
		?>
		
		<h4>Ausgabe von Boolschen Werten - true/false</h4>
		<?php
			$wahr 	= true;
			$unwahr = false;
			echo "<p>\$wahr: $wahr</p>";
			echo "<p>\$unwahr: $unwahr</p>";
		?>
		<br>
		<hr>
		<br>
		
		<h3>Rechnen mit Datentyp Number (Integer / Float)</h3>
		<?php
			$zahl1 = 5; 		// Datentyp Integer
			$zahl2 = 10; 		// Datentyp Integer
			
			// Addition
			$ergebnis = $zahl1 + $zahl2;
			echo "<p>Rechenoperation: $zahl1 + $zahl2</p>";
			echo "<p>Ergebnis: <u>$ergebnis</u></p>";
			echo "<p>- - -</p>";
			
			// Subtraktion
			$ergebnis = $zahl1 - $zahl2;
			echo "<p>Rechenoperation: $zahl1 - $zahl2</p>";
			echo "<p>Ergebnis: <u>$ergebnis</u></p>";
			echo "<p>- - -</p>";
			
			// Multiplikation
			$ergebnis = $zahl1 * $zahl2;
			echo "<p>Rechenoperation: $zahl1 * $zahl2</p>";
			echo "<p>Ergebnis: <u>$ergebnis</u></p>";
			echo "<p>- - -</p>";
			
			// Division
			$ergebnis = $zahl1 / $zahl2;
			echo "<p>Rechenoperation: $zahl1 / $zahl2</p>"; 
			echo "<p>Ergebnis: <u>$ergebnis</u></p>"; // Datentyp hat sich geändert von Integer auf Float
			echo "<p>- - -</p>";
			
			
		?>
</body>

</html>