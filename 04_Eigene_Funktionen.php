<?php
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
		<title>Eigene Funktionen</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<!--<link rel="stylesheet" type="text/css" href="style.css"> -->
		<link rel="stylesheet" type="text/css" href="css/debug.css">
	</head>

	<body>
		<h1>Eigene Funktionen</h1>

		<p>
			In der Programmierung gibt es sich ständig wiederholende Aufgaben, 
			sei es eine Formularüberprüfung, eine mathematische Berechnung 
			oder auch eine spezielle Abfrage von Daten aus einer Datenbank. Damit man 
			diesen Code nicht jedes Mal neu schreiben muss, lagert man ihn 
			in eine Funktion aus, die dann von überall immer wieder aufrufbar ist.
		</p>

		<h3>Funktion definieren</h3>
		<p class="ex">
			function Funktionsname(optional: zu übergebende Parameter) {<br>
			&nbsp;&nbsp;&nbsp;...code...<br>
			&nbsp;&nbsp;&nbsp;Optional: Rückgabewert<br>
			}
		</p>

		<?php
/**********************************************************************************************/
			
			/***********************************/
			/************ KAPSELUNG ************/
			/***********************************/
			
			$name = "Ainane";
			
			
			/*******************************************************/
			function meineFunktion1(){
				// Kapselung 1: Aus einer Funktion heraus kann nicht auf Variablen zugegriffen werden,
				// die außerhalb der Funktion definiert wurden
					
				echo $name;
			}
			/*******************************************************/
			
			meineFunktion1();
			// Kapselung 2: Außerhalb einer Funktion kann nicht auf Variablen zugegriffen werden,
			// die innerhalb der Funktion definiert wurden
			
/**********************************************************************************************/
		
			/******************************************************/
			/********* PARAMETERÜBERGABE UND RÜCKGABEWERT *********/
			/******************************************************/
			
			$name = "Aaainane";
			
			/******************************************************/
			// Um innerhalb der Funktion auf den Wert einer Variablen, die außerhalb
			// definiert wurde, zugreifen zu können, muss der Funktion bei ihrem Aufruf
			// der WERT der Variablen übergeben werden
			function meineFunktion2($param){
if(DEBUG)		echo "<p class='debug'>Aufruf: meineFunktion2</p>";
				echo $param;
				
				$alter = 13;
				// Um außerhalb der Funktion auf eine Variable zugreifen zu können, die innerhalb
				// der Funktion definiert wurde, muss der WERT dieser Variablen von der Funktion
				// nach außen zurückgegeben werden
				
				return $alter;
			}
			/******************************************************/
			
			// Um den Rückgabewert einer Funktion entgegenzunehmen, muss dieser
			// beim Aufruf der Funktion in eine Variable gespeichert werden
			$result = meineFunktion2($name);
			echo "<p>$result</p>";
			
			
/********************************************************************************************/


		
		?>
		
		<br>
		<hr>
		<br>
		<h2>Pflichtparameter</h2>
		<p>
			Eine Funktion kann beliebig viele Parameter erhalten. 
			Wichtig ist, dass diese Parameter in der Funktionsdefinition 
			vorhanden sind. Der Aufruf der Funktion muss dann mit allen 
			nötigen Parametern in der richtigen Reihenfolge erfolgen.
		</p>
		
		<?php
/********************************************************************************************/
			
			/******************************************************/
			/************* PFLICHTPARAMETERÜBERGSBE ***************/
			/******************************************************/

			
			/********************************************************************************/
			function meineFunktionMitParametern($zahl1, $zahl2) {
if(DEBUG)		echo "<p class='debug'>Aufruf: meineFunktionMitParametern ($zahl1, $zahl2) </p>";
				$ergebnis = $zahl1 + $zahl2;
				
				return $ergebnis;
			}
			
			
			/********************************************************************************/
			
			echo "<p>" . meineFunktionMitParametern (2,6) . "</p>";
			echo "<p>" . meineFunktionMitParametern (5,7.2) . "</p>";
			echo "<p>" . meineFunktionMitParametern (12,6.6) . "</p>";
			
/********************************************************************************************/
					
		?>
		
		<br>
		<hr>
		<br>
		<h2>Optionale Parameter</h2>
		
		<p>
			Man kann die Parameter einer Funktion auch mit Default-Werten 
			vorbelegen, so dass nicht zwingend alle Parameter übergeben 
			werden müssen. Man muss hier allerdings auf die Reihenfolge der 
			Parameter achten: Will man Werte an die Funktion übergeben, kann 
			man diese nur „von vorne nach hinten“ übergeben – man darf also 
			keinen Parameter am Anfang oder in der Mitte auslassen, sondern 
			darf lediglich die Parameter am Ende auslassen.
		</p>
		
		<?php
/********************************************************************************************/	
		
			
			/******************************************************/
			/*********** OPTIONALE PARAMETERÜBERGABE **************/
			/******************************************************/
			
			/********************************************************************************/
			function meineFunktionMitOptionalenParametern($zahl1, $zahl2=0){
if (DEBUG)		echo "<p class='debug'>Aufruf: meineFunktionMitOptionalenParametern ($zahl1, $zahl2) </p>";
				$result = $zahl1 + $zahl2;
				return $result;
			}
			
			/********************************************************************************/
			
			echo "<p>" . meineFunktionMitOptionalenParametern(2,6) . "</p>";
			echo "<p>" . meineFunktionMitOptionalenParametern(2) . "</p>";
			echo "<p>" . meineFunktionMitOptionalenParametern(200) . "</p>";

	
/********************************************************************************************/		
		?>
		
		<br>
		<hr>
		<br>
		<h2>Reihenfolge der übergebenden Parameter</h2>
		<p>Die Parameter einer Funktion müssen in genau der Reihenfolge übergeben werden, 
		in der sie in der Funktiondeklaration notiert sind.</p>
		
		<?php
/********************************************************************************************/	
			
			/******************************************/	
			/*******REIHENFOLGE DER PARAMETER**********/
			/******************************************/
			
			/********************************************************************************/
			// ist ausgelagert in "include/functions.inc.php"
			/********************************************************************************/
			
			echo "<p>" . rechne1(2, "+", 5) . "</p>";
			echo "<p>" . rechne1(67, "/", 5) . "</p>";
			echo "<p>" . rechne1(67, "q", 5) . "</p>";
			

/********************************************************************************************/	
		
		?>
		
		<br>
		<hr>
		<br>
		<h2>Reihenfolge optionaler Parameter</h2>
		
		
		<?php
/********************************************************************************************/	
		
		/*************************************************/	
		/*******REIHENFOLGE OPTIONALER PARAMETER**********/
		/*************************************************/
		
		/********************************************************************************/
			// ist ausgelagert in "include/functions.inc.php"
		/********************************************************************************/
			
			echo "<p>" . rechne2() . "</p>";
			echo "<p>" . rechne2(5,"-") . "</p>";
			echo "<p>" . rechne2(3,"*",7) . "</p>";
			echo "<p>" . rechne2(10,"/",3) . "</p>";
			echo "<p>" . rechne2(2, "-") . "</p>";
			

/********************************************************************************************/			
		
		?>
		
		<br>
		<hr>
		<br>
		<h2>Reihenfolge pflicht- und optionaler Parameter</h2>
		
		<?php
/********************************************************************************************/	

		/**************************************************************/	
		/*******REIHENFOLGE PFLICHT- UND OPTIONALER PARAMETER**********/
		/**************************************************************/
		
		/********************************************************************************/
			// ist ausgelagert in "include/functions.inc.php"
		/********************************************************************************/
			
			echo "<p>" . rechne3(2,5) . "</p>";
			echo "<p>" . rechne3(7, 3, "-") . "</p>";
		
/********************************************************************************************/			
		
		?>
		
		<br>
		<hr>
		<br>
		<h2>Mehrere Rückgabewerte</h2>
		
		<?php
/********************************************************************************************/
		
		/**************************************/	
		/*******MEHRERE RÜCKGABEWERTE**********/
		/**************************************/
		
		/********************************************************************************/
		
		// ist ausgelagert in "include/functions.inc.php"
			
		/********************************************************************************/
			
			$text = "Dies ist ein Beispiel. Und es ist ein ziemlich einfaches Beispiel.";
			echo "<p>$text</p>";
			
			$rueckArr = suchenUndErsetzenUndZaehlen($text, "ist", "war");
			echo "<pre>";
			print_r($rueckArr);
			echo "</pre>";
			
			
			echo "<p>Anzahl der Vorkommen von <i>ist</i> in <i>$text</i>: $rueckArr[anzahl]</p>";
			echo "<p>Der String nach Ersetzung lautet: <i>$rueckArr[string]</i></p>";

/********************************************************************************************/

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
	</body>

</html>












































