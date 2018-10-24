<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>Verzweigungen, Bedingungen</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<h1>Verzweigungen, Bedingungen</h1>
		<p>
			PHP arbeitet den Quellcode i.d.R. sequenziell, d.h. von oben nach unten ab.
			Programme sollten allerdings auch je nach Situation unterschiedliche Dinge ausführen.
			Hierfür dienen in der Programmierung sogenannte Verzweigungen.
		</p>
		<p>
			Eine Verzweigung bedeutet, dass eine bestimmte Bedingung erfüllt sein muss, um zu einer
			anderen Stelle im Quellcode zu springen. Hierzu werden Werte aus beispielsweise Variablen
			auf bestimmte Zustände abgefragt und mit einem Referenzwert verglichen.
		</p>
		<p>Syntax:</p>
		<pre class="ex">
			if( Bedingung ) { 
			auszuführender Code, wenn die Bedingung erfüllt ist;
			}
			Unabhängig von der Bedingung geht es anschließend hier weiter...
		</pre>

		<p>
			Ein einfaches = ist ein Zuweisungsoperator, der einer Variablen einen Wert zuweist.<br>
			Ein doppeltes == ist ein Vergleichsoperator, der den Inhalt einer Variablen mit einem
			definierten Wert vergleicht.
		</p>

		<h3>Vergleichsoperatoren</h3>
		<p>
			true/false: In der if-Bedingung werden zwei Werte anhand einer Bedingung miteinander verglichen.<br>
			Trifft die Bedingung zu, liefert die Abfrage true zurück. Trifft die Bedingung nicht zu, liefert die Abfrage false zurück.
		</p>
		<p>
			Beispiel:<br>
	
			Bedingung: Wert1 ist gleich Wert2 -> Ergebnis: true, wenn Wert1 gleich Wert2 ist. Ansonsten false.<br>
			Bedingung: Wert1 ist größer als Wert2 -> Ergebnis: true, wenn Wert1 größer ist als Wert2. Ansonsten false.<br>
			Bedingung: Wert1 ist ungleich Wert2 -> Ergebnis: true, wenn Wert1 ungleich Wert2 ist. Ansonsten false. 
		</p>

		<h4>Liste der Vergleichsoperatoren</h4>
		<ul>
			<li>== (ist gleich): prüft, ob eine Bedingung zutrifft (Bedingung ist erfüllt, wenn das Prüfkonstrukt "true" ergibt)</li>
			<li>!= (ist ungleich): prüft, ob eine Bedingung nicht zutrifft (Bedingung ist erfüllt, wenn das Prüfkonstrukt "false" ergibt)</li>
			<li>=== (ist gleich gleich): prüft, ob ein Wert gleich ist und ob der Typ gleich ist (Bedingung ist erfüllt, wenn das Prüfkonstrukt "true" ergibt)</li>
			<li>!== (ist ungleich ungleich): prüft, ob ein Wert ungleich ist und ob der Typ ungleich ist (Bedingung ist erfüllt, wenn das Prüfkonstrukt "false" ergibt)</li>
			<li>> (größer): Bedingung trifft zu (true), wenn geprüfter Wert größer als ... ist</li>
			<li>< (kleiner): Bedingung trifft zu (true), wenn geprüfter Wert kleiner als ... ist</li>
			<li>>= (größer/gleich): Bedingung trifft zu (true), wenn geprüfter Wert größer als oder gleich groß ... ist</li>
			<li><= (kleiner/gleich): Bedingung trifft zu (true), wenn geprüfter Wert kleiner als oder gleich klein ... ist</li>
			<li>isset() : Prüft, ob eine Variable existiert und ob sie einen anderen Wert hat als NULL</li>
		</ul>
		
		<br>
		<hr>
		<br>
		
		<h4>Beispiel: Ein Türsteher muss das Alter eines Gastes wissen, um entscheiden zu können,
			ob der Gast den Club betreten darf oder nicht.</h4>
			
		<h3>if-else</h3>
		<?php
			$meinAlter = "minderjährig";
			echo "<p>\$meinAlter: $meinAlter</p>";
			
			if($meinAlter == "mienderjährig") {
				//Wenn die Bedingung erfüllt ist
				echo "<p><i>Du darfst eintreten.</i></p>";
			} else {
				echo "<p><i>Du musst drausen bleiben.</i></p>";
			}
			//unabhängig von der Erfüllung der Bedingung gehr es hier weiter...
			echo "<p><i>Ein schönen Abend noch</i></p>";
		?>
		
		<hr>
		
		<h3>if-elseif</h3>
		<p>Mit "if-elseif" kann eine alternative Bedingung formuliert werden</p>
		<p>
		Wenn eine Bedingung innerhalb eines if-/elseif-Konstrukts erfüllt wurde, werden keine 
		weiteren Bedingungen mehr geprüft!
		</p>
		<?php
		$meinAlter = "volljährig";
		
		echo "<p>\$meinAlter: $meinAlter</p>";
		
		if($meinAlter == "volljährig") {
				//Wenn die Bedingung erfüllt ist
				echo "<p><i>Du darfst eintreten.</i></p>";
			} elseif($meinAlter == "mienderjährig") {
				echo "<p><i>Du musst drausen bleiben.</i></p>";
			}
			//unabhängig von der Erfüllung der Bedingung gehr es hier weiter...
			echo "<p><i>Ein schönen Abend noch</i></p>";
			
			
		?>
		
		<hr>
		
		<h5>Zahlenwerte prüfen</h5>
		
		<p class="w">
		PHP kann Strings als Zahlenwerte interpretieren, wenn mit diesen Strings eine mathematische
		Operation bzw. ein mathematischer Vergleich durchgeführt wird.<br>
		Der String wird hierbei von links nach rechts auf interpretierbare Zahlenwerte durchsucht. Ab
		dem ersten Zeichen, das nicht eindeutig als Zahl interpretiert werden kann, wird der restliche
		String ignoriert.<br>
		Enthält ein String keinerlei als Zahl interpretierbaren Wert, wird der gesamte String als 0 interpretiert.
		</p>
		<p>
		Der Grund für dieses Verhalten ist, dass PHP aus HTML-Formularen und HTML-Links ausschließlich den Datentyp
		String erhält.
		</p>
		<?php
		$meinAlter = 55;
		echo "<p>\$meinAlter: $meinAlter</p>";
		
		if($meinAlter < 18) {
				echo "<p><i>Du musst drausen bleiben.</i></p>";
			} elseif ($meinAlter >=50) {
				echo "<p><i>Das ist kein Ü50-Party</i></p>";
			} elseif($meinAlter >= 18) {
				echo "<p><i>Du darfst eintreten.</i></p>";
			};
		?>
		
		<hr>
		
		<h5>Abfrage auf Existenz</h5>
		<p>
			Prüfen, ob eine Variable existiert, ob sie einen gültigen Wert besitzt. Alles was nicht NULL, 0, "" oder false ist.
		</p>
		
		<p>Variante 1: isset()</p>
		<?php 
			//Variable deklarieren und initializieren
			$vorname = "ыфв";
			// isset() prüft, ob eine Variable existiert UND ob ihr Wert ungleich NULL ist
			// isset() erwartet als Parameter den Namen der Variablen, die geprüft werden soll
			if(isset($vorname)){ 
				echo "<p>Die Variable existiert und hat einen anderen Wert als NULL</p>";
			} else {
				echo "<p>Die Variable existiert nicht ODER hat den Wert NULL</p>";
			}
		?>
		<p>- - -</p>
		
		<p>Variante 2: prüfen auf Existenz und gültigen Wert (s.o.)</p>
		
		<?php
			if($vorname) {
				echo "<p>Die Variable existiert UND hat einen anderen Wert als NULL, 0, '' oder false</p>";
			} else {
				echo "<p>Die Variable existiert  NICHT ODER hat den Wert NULL, 0, '' oder false</p>";
			}
		?>
		
		<hr>
		
		<h5>Abfrage auf Inhalt plus Datentyp einer Variablen</h5>
		<p>Manchmal ist es zwingend notwendig, zusätzlich zum Wert einer Variablen auf ihren Datentyp zu prüfen</p>
		<?php 
		$variable = 10;
		echo "<p>\$variable: $variable</p>";
		// Zwei == prüfen auf den Wert
		if ($variable == 10) {
			echo "<p>Der Wert stimmt. Der Datentyp wurde NICHT überprüft</p>";
		} else {
			echo "<p>Der Wert stimmt NICHT. Der Datentyp wurde NICHT überprüft</p>";
		};
		// Drei === prüfen auf den Wert UND auf den Datentyp
		if ($variable === "10") {
			echo "<p>Der Wert und der Datentyp stimmen</p>";
		} else {
			echo "<p>Der Wert ODER der Datentyp stimmen NICHT</p>";
		};
		
		
		
		?>
		
		<br>
		<hr>
		<br>
		
		<h3>Logische Operatoren</h3>
		<p>Bedingungen (Vergleiche) lassen sich mittels logischer Operatoren miteinander verknüpfen.</p>
		<p>
		Es gibt die beiden logischen Operatoren AND (&&) und OR (||).<br>
		AND (&&) bedeutet: <b>Alle</b> Bedingungen müssen erfüllt sein, damit das Gesamtkonstrukt der if-Abfrage wahr (true) ist.<br>
		OR (||) bedeutet: Es muss nur <b>1</b> Bedingung erfüllt sein, damit das Gesamtkonstrukt der if-Abfrage wahr (true) ist.
		</p>
		<h5>Beispiel für logische Operatoren</h5>

		<p>Aufgabenstellung:</p>
		<ol>
			<li>Wenn Ingmar volljährig ist, darf er in den Club</li>
			<li>Wenn Ingmars Job "Putze" ist UND er volljährig ist, muss er die Klos putzen</li>
			<li>Wenn Ingmar berühmt ist (Rennfahrer oder Filmstar), darf er unabhängig von 
			seinem Alter in die VIP-Lounge</li>
		</ol>
		
		<?php
			$alter = 10;
			echo "<p>\$alter: $alter</p>";
			$job = "Filmstar";
			echo "<p>\$job: $job</p>";
			
			//egal wie alt: Wenn Ingmar Rennfahrer oder Filmstar ist, darf er in die VIP-Lounge
			if($job == "Rennfahrer" || $job == "Filmstar"){
				echo "<p><i>Herzlich willkommen!</i></p>";
			} elseif($job == "Putze" && $alter >= 18) {
				echo "<p><i>Putz mal die Klos!</i></p>";
			} elseif ($alte >= 18) {
				echo "<p><i>Du darfst eintreten.</i></p>";
			} elseif($alter < 18){
				echo "<p><i>Du musst drausen bleiben.</i></p>";
			}
		?>
		
		
		<br>
		<hr>
		<br>
		
		<h2>Switch Case</h2>
		<p>
			Die switch Anweisung entspricht in etwa einer Folge von if Anweisungen, die jeweils den gleichen Ausdruck 
			prüfen. Es kommt oft vor, dass man dieselbe Variable (oder denselben Ausdruck) gegen viele verschiedene 
			mögliche Werte prüfen (und abhängig davon unterschiedlichen Code ausführen) möchte.<br>
			Da das Auslesen des Wertes der zu prüfenden Variable im Switch lediglich einmal geschieht und
			anschließend ihr Wert nur noch gegen die Cases geprüfte wird kann ein switch bei einer Anzahl von 
			vielen Prüfungen auf dieselbe Variable schneller sein, als mehrere if-elseifs.
		</p>
		<p>
			Die Möglichkeiten des Switches sind gegenüber des if-elseif-Konstrukts deutlich eingeschränkt: So lassen 
			sich beispielsweise nicht mehrere Variablen auf einmal überprüfen, und auch eine logische AND-Verknüpfung
			ist für den Switch nicht vorgesehen. Eine Oder-Verknüpfung hingegen kann mittels des sog. "Fall through"s 
			erreicht werden.
		</p>
		
		<?php 
			$alter = 55;
			echo "<p>\$alter: $alter</p>";
			
			switch($alter) {
				case ($alter < 18): 	echo "<p><i>Du musst drausen bleiben.</i></p>";
										break;
				case ($alter > 50): 	echo "<p><i>Das ist kein Ü50-Party</i></p>";
										break;
				case ($alter >= 18): 	echo "<p><i>Du darfst eintreten</i></p>";
										break;
				
			}
		?>
		
		<p>- - -</p>
		
		<h4>Fall Through:</h4>
		<p>
		Fall Through beim Switch bedeutet, dass man ein oder mehrere Breaks weglassen kann.
		In diesem Fall werden alle Cases bis zum nächsten break; durchlaufen (Fall Through) und es wird der Befehl im
		letzten Case ausgeführt. Dieses Verhalten entspricht einer logischen OR-Verknüpfung.
		</p>
		
		<?php
			$weather = "sturm";
			echo "<p>\$weather: $weather</p>";
			
			switch($weather) {
				case "regen":			
				case "graupel":			echo "<p><i>Du brauchst einen Regenschirm.</i></p>";
										break;
				case "schnee":			echo "<p><i>Du brauchst Schneeschuhe.</i></p>";
										break;				
				case "sonne":			echo "<p><i>Du brauchst einen Sonnenhut.</i></p>";
										break;
				case "wind":			
				case "sturm":			echo "<p><i>Du brauchst einen Schutzraum!</i></p>";
										break;
				default:				echo "<p><i>Das Wetter ist heute unberechenbar</i></p>";
				
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

</body>

</html>