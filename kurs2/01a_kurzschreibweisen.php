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
				require_once("include/db.inc.php");


/*************************************************************************************/
?>

<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>Kurzschreibweisen in PHP</title>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/debug.css">
	</head>

	<body>
		<h1>Kurzschreibweisen in PHP</h1>
		
		<h2>echo-Ausgaben innerhalb von HTML-Code als Kurzform</h2>
		
		<p><?php echo "Hallo!" ?></p>
		<p><?= "Hallo!" ?></p>
		
		<h3>Oder mit Variable:</h3>
		<?php
			$sayHi = "Hallo!";
		?>
		<p><?php echo $sayHi ?></p>
		<p><?= $sayHi ?></p>
		
		<br>
		<hr>
		<br>
		
		<h2>Array in Kurzschreibweise definieren</h2>
		
		<?php
			// Laaaaaange Schreibweise:
			$meinArray1 = array("Wert1", "Wert2", "Wert3", "Wert4");
			$meinArray2 = array("Index1" => "Wert1", "Index2" => "Wert2", "Index3" => "Wert3", "Index4" => "Wert4");
		
			// Kurzschrbws:
			$meinArray1 = ["Wert1", "Wert2", "Wert3", "Wert4"];
			$meinArray2 = ["Index1" => "Wert1", "Index2" => "Wert2", "Index3" => "Wert3", "Index4" => "Wert4"];
		
if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>";					
if(DEBUG)	print_r($meinArray1);					
if(DEBUG)	echo "</pre>";	

if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>";					
if(DEBUG)	print_r($meinArray2);					
if(DEBUG)	echo "</pre>";		
		?>
		
		<br>
		<hr>
		<br>
		
		<h2>Der Spaceshipoperator (neu in PHP7)</h2>
		<p>
			Der Spaceshipoperator <=> vergleicht zwei Zahlenwerte miteinander und gibt 
			zurück, welche der Zahlen größer ist bzw. ob die Zahlen den gleichen Wert besitzen.
			Ist die 1. Zahl die Größere, wird 1 zurückgegeben, ist die 2. Zahl die Größere, 
			wird -1 zurückgegeben. Haben beide Zahlen den gleichen Wert, wird 0 zurückgegeben.<br>
			Alternativ können auch 2 Strings alphabetisch miteinander vergleichen werden.
		</p>
		<p>Ergebnis (10<=>5): 	<?= 10<=>5 ?></p>
		<p>Ergebnis (5<=>10): 	<?= 5<=>10 ?></p>
		<p>Ergebnis (10<=>10): 	<?= 10<=>10 ?></p>
		<p>Ergebnis ("2018-11-05"<=>"2018-03-28"): 	<?= "2018-11-05"<=>"2018-03-28" ?></p>
		<p>Ergebnis ("Müller"<=>"Maller"): 	<?= "Müller"<=>"Maller" ?></p>
		
		<br>
		<hr>
		<br>
		
		<h2>if/elseif/else in Kurzform: Ternäre Operatoren</h2>
		<p>(wenn Ausdruck wahr) ? (mache das hier) : (ansonsten das hier)</p>
		
		<h3>Beispiel 1 (if/else)</h3>
		<?php
			$variable = true;
			
			// Langform:
			if( $variable ) {
				echo "<p>\$variable ist true</p>";
			} else {
				echo "<p>\$variable ist false</p>";
			}
			
			// Kurzform mit Ternären Operatoren
			echo ($variable) ? "<p>\$variable ist true</p>" : "<p>\$variable ist false</p>";
		?>
		
		
		<p>- - -</p>
		
		<h3>Beispiel 2 (if/else)</h3>
		
		<?php
		$time = 5;
		
		//Langform
		echo "<p>Du wars zuletzt eingeloggt vor $time Stunde";
		if($time === 1){
			//lediglich das schießende p-Tag anhängen
			echo ".</p>";
			
		}else{
			// Plural-n und schließenden p-Tag ausgeben
			echo "n.</p>";
		}
		
		// Kurzform mit Ternären Operatoren
		// Die Klammern um die Verzweigung dienen dazu, dass das Ergebnis aus der Verzweigung
		// an den ursprünglichen String angehängt (konkateniert) wird
		echo "<p>Du wars zuletzt eingeloggt vor $time Stunde" . (($time === 1) ? ".</p>" : "n.</p>" );
		?>
		
		<p>- - -</p>
		
		<h3>Beispiel 3 (if/elseif/else)</h3>
		<?php
			$genderId = 1;
			
			//Langform:
			if($genderId === 1){
				$gender = "männlich";
			}elseif($genderId === 2){
				$gender = "weiblich";
			}else{
				$gender = "anders";
			}
			
			echo "<p>Dein Geschlecht ist $gender.</p>";
			
			//Kurzform mit ternären Operatoren
			$gender = ($genderId === 1) ? "männlich" : (($genderId === 2) ? "weiblich" : "'speziel'");
			echo "<p>Dein Geschlecht ist $gender.</p>";
		?>
		
		
		<br>
		<hr>
		<br>
		
		<h2>Der Koaleszenzoperator - NULL-Coalesce (neu in PHP7)</h2>
		<p>
			Der Koasleszensoperator ?? prüft wie isset() auf die Existenz einer Variable 
			und den Wert NULL. Wenn die Variable existiert und einen anderen Wert 
			als Null besitzt, wird der Wert der Variablen ausgegeben. Ansonsten erfolgt
			das, was nach den ?? notiert wurde.
		</p>
		<?php
			$lagerbestand_iPhone = 56;
			
			// Langform
			if(isset($lagerbestand_iPhone)){
				echo "<p>Lagebestand iPhone: $lagerbestand_iPhone</p>";
			}else{
				echo "<p>Der Artikel ist nicht am lager.</p>";
			
			}
			
			// Kurzform mit Koaleszenzoperator
			echo "<p>Lagebestand iPhone: ". ($lagerbestand_iPhone ?? "Der Artikel ist nicht am lager. ") ."</p>";
			
		?>
		
		<br>
		<hr>
		<br>
		
		<h2>Platzhalter für Statements als Kurzform</h2>
		<p>
			Die Platzhalter im SQL-Statement müssen nicht zwingend einen Namen haben. Für die Kurzschreibweise reicht 
			es aus, ein ? als Platzhalter zu verwenden.<br>
			<br>
			Im execute-Array werden nun die Platzhalter in Form eines numerischen Arrays (also ohne benannten Index)
			befüllt, wobei hier zu beachten ist, dass die Reihenfolge der Werte im Array zwingend der Reihenfolge der 
			?-Platzhalter entsprechen muss: Die Arraywerte müssen also in der Reihenfolge der entsprechenden ?-Platzhalter
			notiert werden.
		</p>
		
		<?php
			/*********** Datenbankoperation **************/
			
			$category = "Gemüse";
			$price_min = 0.5;
			$price_max = 1;
			
			// Verbindung aufbauen
			$pdo = dbConnect("market");
			
			//SQL-Statement Vorbereiten
			//Langform
			
			/* 
			$statement = $pdo->prepare("SELECT * FROM products
										WHERE prod_category = :ph_prod_category
										AND prod_price BETWEEN :ph_price_min AND :ph_price_max
										");
			$statement->execute(array(
									"ph_prod_category" => $category,
									"ph_price_min" => $price_min,
									"ph_price_max" => $price_max	)
								
									)OR DIE( "<p class='debug err'>Line <b>" . __LINE__ . "</b>: " . "ERROR: You have an error in your SQL-syntax. Check near... <i>(" . basename(__FILE__) . ")</i></p>" );
		*/
			//Kurzfom
			
			$statement = $pdo->prepare("SELECT * FROM products
										WHERE prod_category = ?
										AND prod_price BETWEEN ? AND ?
										");
			$statement->execute(array(
									$category,
									$price_min,
									$price_max	)
								
									)OR DIE( "<p class='debug err'>Line <b>" . __LINE__ . "</b>: " . "ERROR: You have an error in your SQL-syntax. Check near... <i>(" . basename(__FILE__) . ")</i></p>" );


		
			$row = $statement->fetchAll();
		?>
		
		<!-- Ausgabe der Ergebnistabelle -->
		<table>
			<tr>
				<th>Bezeichnung</th>
				<th>Beschreibung</th>
				<th>Kategorie</th>
				<th>Preis in Euro</th>
			</tr>
			<?php foreach( $row AS $product ): ?>
				<tr>
					<td><?= $product['prod_name'] ?></td>
					<td><?= $product['prod_description'] ?></td>
					<td><?= $product['prod_category'] ?></td>
					<td><?= $product['prod_price'] ?></td>
				</tr>
			<?php endforeach ?>
		</table>
		
		
		
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






























