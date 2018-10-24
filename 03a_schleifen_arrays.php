<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>Schleifen und Arrays (Felder)</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<h1>Schleifen und Arrays (Felder)</h1>
		<h2>Schleifen</h2>

		<p>
			Schleifen dienen in PHP dazu, automatisiert Datensätze zu
			durchsuchen bzw. automatisiert Daten zu erzeugen.<br>
			<br>
			Eine Schleife besteht aus einer Bedingung, in der festgelegt wird,
			wie oft die Schleife ausgeführt wird sowie einem Schleifenrumpf, in 
			dem der Code notiert wird, der in jedem einzelnen Schleifendurchlauf 
			ausgeführt werden soll.<br>
			<br>
			Beispiel:
		</p>
		
		<h3>for-schleife</h3>
		<p>
			Die for-Schleife funktioniert wie folgt:<br>
			Als erstes wird ein Zähler deklariert und initialisiert.<br>
			Dann wird eine Abbruchbedingung definiert.<br>
			Dann wird der Schleifenrumpf ausgeführt.<br>
			Zum Schluss wird der Zähler hoch- oder runtergezählt.<br>
			In jedem weiteren Schleifendurchlauf wird nun zuerst die Abbruchbedingung überprüft,
			danach der Schleifenrumpf ausgeführt und zum Schluss der Zähler modifiziert.
		</p>
		
		<?php
			// for( Initialisierung des Zählers; wie lange soll die Schleife laufen; Änderung des Zählers je Durchlauf ) {
			// Code, der in jedem Schleifendurchlauf ausgeführt werden soll 
			// }		
			for($i = 0; $i<5; $i++) {
				echo "\$i: $i ";
			}
			
			
			echo "<p>- - -</p>";
			
			//Gib die 12 Monate des Jahres aus (von 1 bis 12):
			for($i=1; $i<=12; $i++){
				echo "$i ";
			}
			
			echo "<p>- - -</p>";
			
			for($i=12; $i>=1; $i--){
				echo "$i ";
			}
			
			echo "<p>- - -</p>";
			
			// gerade Monate
			for($i=1; $i<=12; $i++){
				if($i%2 == 0) {
				echo "$i ";
				}
			}
			
			
		?>
		<hr>
		
		<h3>do-while-Schleife</h3>
		<p>
			Im Gegensatz zur for-Schleife wird die do-while-Schleife immer mindestens 1 Mal ausgeführt.<br>
			<br>
			Die do-while-Schleife funktioniert wie folgt:<br>
			Zuerst wird außerhalb der Schleife der Iterator definiert und initialisiert.<br>
			Dann wird der Schleifenrumpf ausgeführt, in dem auch der Iterator hoch- oder runtergezählt wird.<br>
			Zum Schluss wird die Bedingung überprüft.
		</p>
		
		<?php
			$i = 0;
			do {
				echo "$i ";
				$i++;
			} while($i<5);
			
			
		?>
		
		<br>
		<br>
		<hr>
		<hr>
		<br>
		
		<h2>Arrays (Felder)</h2>
		<p>
			Ein Array ist eine Variable, die mehrere Werte beinhalten kann. 
			Ein Array kann auch andere Arrays beinhalten. In diesem Fall spricht man von 
			mehrdimensionalen Arrays. Ein Array kann Werte von unterschiedlicher Art enthalten, 
			also beispielsweise sowohl Strings als auch Integers.<br />
			<br>
			Ein Array besteht immer aus einem Wertepaar, nämlich dem sogenannten Key und dem zum Key gehörigen Wert. 
			Üblicherweise wird der Key eines Arrays im Form eines Zähl-Index automatisch gesetzt.
		</p>	
		
		<h3>Numerische Array</h3>
		
		<?php
			//Numerisches Array initializieren und befüllen
			$wochentage = array("Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag", "Sonntag");
			echo "<pre>";
			//var_dump($wochentage);
			print_r($wochentage);
			echo "</pre>";
			
			//Einzelnen Wert aus dem Array über dessen Key/Index auslesen
			echo "<p>Einen einzelnen Wert aus dem Array über dessen Key/Index auslesen (Mittwoch)</p>";
			echo "<p>$wochentage[2]</p>";
			echo "<p>Einen einzelnen Wert aus dem Array über dessen Key/Index auslesen (Samstag)</p>";
			echo "<p>$wochentage[5]</p>";
			
		?>
		
		<br>
		<hr>
		<br>
		
		<p>Neuen Wert an ein bestehendes Array anhängen ("Feiertag"):</p>
		
		<?php
			$wochentage[] = "Feiertag";
			echo "<pre>";
			print_r($wochentage);
			echo "</pre>";
		?>
		<br>
		<hr>
		<br>
		
		<p>Bestehenden Wert im Array überschreiben:</p>
		
		<?php
			$wochentage[1] = "Badetag";
			echo "<pre>";
			print_r($wochentage);
			echo "</pre>";
		?>
		<br>
		<hr>
		<br>
		
		<p>Bestehenden Wert aus dem Array löschen:</p>
		
		<?php
			//unset($wochentage[1]);
			$wochentage[1] = NULL;
			echo "<pre>";
			print_r($wochentage);
			echo "</pre>";
		?>
		<br>
		<hr>
		<br>
		
		<h4>Numerisches Array mittels Schleife auslesen:</h4>
		<h5>for-Schleife</h5>
		<?php
			for($i=0; $i<=7; $i++){
				echo "$wochentage[$i] ";
			}
			
			//Noch einen Wert an das Array Anhängen
			$wochentage[]= "Badetag";
			echo "<pre>";
			print_r($wochentage);
			echo "</pre>";
			
			//count() liefert die Anzahl der Eintäge in einem Array zurück
			echo count($wochentage);
			for($i=0; $i < count($wochentage); $i++){
				echo "$wochentage[$i] ";
			}
		?>
		
		<hr>
		
		<h5>do-while-Schleife</h5>
		<?php
			$i = 0;
			do {
				echo "$wochentage[$i], ";
				$i++;
			} while($i < count($wochentage));
		?>
		
		<hr>
		
		<h5>while-Schleife</h5>
		
		<?php
			$i = 0;
			while($i < count($wochentage)){
				echo "$wochentage[$i], ";
				$i++;				
			}
		?>
		
		<hr>
		
		<h5>foreach-Schleife</h5>
		
		<?php
			foreach($wochentage AS $value){
				echo "$value, ";
			}
			
			echo "<p>- - -</p>";
			
			foreach($wochentage AS $key=>$value){
				echo "$key: $value, ";
			}
		?>
		
		
		<br>
		<hr>
		<hr>
		<br>
		
		<h3>Asoziatives Array</h3>
		<p>
			Assoziative Arrays sind Arrays, die als Index (Key) keine Nummerierung besitzen, 
			sondern einen selbst definierten Schlüsselnamen.
		</p>
		
		<p>Asoziatives Array definieren und befüllen</p>
		<?php
			$weekdays = array("mon"=>"Monday", "tue"=>"Tuesday", "wed"=>"Wednesday", "thu"=>"Thursday", "fri"=>"Friday", "sat"=>"Saturday", "sun"=>"Sunday");
			echo "<pre>";
			print_r($weekdays);
			echo "</pre>";
		?>
		
		<hr>
		
		<p>Neuen Wert an ein bestehendes Array anhängen ("Feiertag"):</p>
		
		<?php
			$weekdays["hol"] = "Holiday";
			echo "<pre>";
			print_r($weekdays);
			echo "</pre>";
		?>
		<br>
		<hr>
		<br>
		
		<p>Einen Wert innerhalb eines asoziativen Arrays überschreiben:</p>
		
		<?php
			$weekdays["tue"] = "Bathday";
			echo "<pre>";
			print_r($weekdays);
			echo "</pre>";
		?>
		<br>
		<hr>
		<br>
		
		<p>Bestehenden Wert aus dem asoziativen Array löschen:</p>
		
		<?php
			unset($weekdays["tue"]);
			echo "<pre>";
			print_r($weekdays);
			echo "</pre>";
		?>
		
		<hr>
		
		<h4>Asoziative Array mittels Schleife auslesen</h4>
		<p class="w">
			Asoziative Arrays werden immer mittels foreach-Schleife ausgelesen, da alle anderen Schleifen
			Zählschleifen sind.
		</p>
		<?php
			foreach($weekdays AS $key=>$value){
				echo "$key: $value, <br> ";
			}
		?>
		
		<hr>
		
		<h3>Mehrdimensionales Array</h3>
		<p>
			Ein mehrdimensionales Array ist ein Array, das mindestens 
			ein weiteres Array enthält
		</p>

		<p>Mehrdimensionales definieren und befüllen:</p>
		
		<?php
			//Mehrdimensionales definieren und befüllen
			$firma = array(
							"Vertrieb" 		=> 	array("Hugo", "Paul", "Lisa"),
							"Produktion" 	=> 	array("Klaus", "Frederike")
						);
			echo "<pre>";
			print_r($firma);
			echo "</pre>";
			
			echo "<p>- - -</p>";
			
			//Auslesen
			foreach($firma AS $key=>$value){
				echo "<b>Abteilung:</b> $key <br>";
				foreach($value AS $name) {
					echo "- $name <br>";
				}
				echo "<br>";
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
		<br>
		<br>
		<br>
		<br>
		<br>

</body>

</html>