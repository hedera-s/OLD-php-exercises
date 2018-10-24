<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>PHP in HTML einbetten</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<h1>PHP in HTML einbetten</h1>
		<p>Ein Absatz in HTML</p>
		<?php
			//Einzeiliger Kommentar in PHP
			echo "<p>Das ist ein Absatz in PHP</p>";
			/* 
			Mehrzeiliger
			Kommentar
			*/			
		?>
		<br>
		<hr>
		<br>
		
		<h3>Listen in HTML und PHP</h3>
		
		<ul>
			<li>Listepunkt 1</li>
			<li>Listepunkt 2</li>
			<li>Listepunkt 3</li>
		</ul>
		
	
		<?php
		// Die gleiche Liste in PHP
		// mittels echo wird der Code zwischen den Anführungszeichen im Frontend ausgegeben
		// STEUERZEICHEN: \r\n = carriage_return new_line
		// \t = Tabulator
		// Steuerzeichen wirken sich in diesem Fall nur im Quellcode aus
		// und dienen hier zur sauberen Einrückung des mittels PHP erzeugten HTML-Codes
			echo "<h4>Liste in PHP</h4>\r\n";
			echo "\t\t<ul>\r\n";
			echo "\t\t\t<li>Listepunkt 1</li>\r\n";
			echo "\t\t\t<li>Listepunkt 2</li>\r\n";
			echo "\t\t\t<li>Listepunkt 3</li>\r\n";
			echo "\t\t</ul>\r\n";
		?>
		
		<br>
		<hr>
		<br>
		
		<h3>Anführungszeichen innerhalb von PHP-Code ausgeben</h3>
		<p style="color:orange">Ein Absatz mit Style</p>
		<?php
			// Variante 1: Doppelte Anführungszeichen für den String, darin einfache Anführungszeichen
			echo "\t\t\t<p style='color:tomato'>Ein Absatz mit Style</p>";
			// Variante 2: Einfach Anführungszeichen für den String, darin doppelte Anführungszeichen
			echo '\t\t\t<p style="color:teal">Ein Absatz mit Style</p>';
			// Variante 3: Anführungszeichen für den String, darin Anführungszeichen
			// mittels Backslash escapen (entschärfen)
			echo "\t\t\t<p style=\"color:green\">Ein Absatz mit Style</p>";
			
			
		?>

</body>

</html>