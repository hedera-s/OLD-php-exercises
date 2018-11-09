<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>Vorlage Debugging in PHP</title>
		<!-- <link rel="stylesheet" href="css/main.css"> -->
		<!-- <link rel="stylesheet" href="css/debug.css"> -->
		<style>
			/********** MAIN STYLES **********/
			body {
				font-family: verdana;
				font-size: 12px;
				box-sizing: border-box;
			}
			
			/********** DEBUG STYLES **********/
			.debug,.debugCleanString,.debugCheckInputString,.debugCheckEmail,.debugImageUpload,.debugDb,.debugClass  {
				background-color: dodgerblue;
				padding: 2px 5px;
				margin-bottom: 2px;
				margin-top: 2px;
				font-family: arial;
				font-size: 0.8em;
				color: white;
				margin-left: 10px;
			}
			.debugCleanString {
				background-color: palegreen;
				color: black;
			}
			.debugCheckInputString {
				background-color: springgreen;
				color: black;
			}
			.debugCheckEmail {
				background-color: chartreuse;
				color: black;
			}
			.debugImageUpload {
				background-color: darkcyan;
			}
			.debugDb {
				background-color: darkorange;
			}
			.debugClass {
				background-color: lightblue;
				font-family: courier new;
				font-size: 0.9em;
				color: #333;
			}
			.err {
				border-left: 10px solid red;
				border-radius: 0.7em 0 0 0.7em;
				margin-left: 0px;
			}
			.ok {
				border-left: 10px solid lime;
				border-radius: 0.7em 0 0 0.7em;
				margin-left: 0px;
			}
		</style>
	</head>

	<body>
		<h1>Vorlage Debugging in PHP</h1>
		
		<br>
		<hr>
		<br>
		
<?php
/********************************************************************************************/


				/****************************************************************************/
				/********** IN DIESEM DOKUMENT VERWENDETE VARIABLEN INITIALISIEREN **********/
				/****************************************************************************/
				
				$variable 			= "Variable";
				$bedingung1 		= "Bedingung 1";
				$bedingung2 		= "Bedingung 2";
				$parameter 			= "Parameter";
				$array				= array("Key1"=>"Value1", "Key2"=>"Value2", "Key3"=>"Value3", "Key4"=>"Value4");
				$hiddenFieldName 	= "formsentLogin";
				$urlParameter 		= "tuIrgendwas";


/********************************************************************************************/


				/***************************************************************/
				/********** KONSTANTEN ZUR DEBUG-STEUERUNG DEFINIEREN **********/
				/***************************************************************/
				
				define("DEBUG", 	true);	// Debugging für Hauptdokument ein-/ausschalten
				define("DEBUG_F", true);	// Debugging für Funktionen ein-/ausschalten
				define("DEBUG_C", true);	// Debugging für Klassen ein-/ausschalten


/********************************************************************************************/


				/********************************************/
				/********** EINFACHE DEBUGAUSGABEN **********/
				/********************************************/

				echo "<p>Einfache Ereignismeldung:</p>";
if(DEBUG)	echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Ereignis XY. <i>(" . basename(__FILE__) . ")</i></p>";

				echo "<p>Variablenwert ausgeben:</p>";
if(DEBUG)	echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: \$variable: $variable <i>(" . basename(__FILE__) . ")</i></p>";
				
				echo "<p>Ein Vorgang wird gestartet:</p>";
if(DEBUG)	echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Formulardaten werden verarbeitet... <i>(" . basename(__FILE__) . ")</i></p>";				
				
				echo "<br>";
				echo "<hr>";
				echo "<br>";

/********************************************************************************************/


				/***********************************************************************/
				/********** VARIABLENWERTE MIT ERFOLGS-/FEHLERKLASSE AUSGEBEN **********/
				/***********************************************************************/

				echo "<p>Debug-Ausgabe als Erfolgsmeldung:</p>";
if(DEBUG)	echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Inhalt der Erfolgsmeldung. <i>(" . basename(__FILE__) . ")</i></p>";				

				echo "<p>Debug-Ausgabe als Fehlermeldung:</p>";
if(DEBUG)	echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: FEHLER: Inhalt der Fehlermeldung! <i>(" . basename(__FILE__) . ")</i></p>";				
		
				echo "<br>";
				echo "<hr>";
				echo "<br>";
				
		
/********************************************************************************************/
		
				
				/*************************************************/
				/********** ARRAYS UND OBJEKTE AUSGEBEN **********/
				/*************************************************/
				
				echo "<p>Den Inhalt eines Arrays oder Objekts ausgeben:</p>";
if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>";					
if(DEBUG)	print_r($array);					
if(DEBUG)	echo "</pre>";

				echo "<br>";
				echo "<hr>";
				echo "<br>";


/********************************************************************************************/


				/********************************************/
				/********** VERZWEIGUNGEN ANZEIGEN **********/
				/********************************************/
				
				echo "<p>Debug-Ausgaben innerhalb von Verzweigungen:</p>";
				if( $bedingung1 ) {
if(DEBUG)		echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Bedingung 1 wird ausgeführt... <i>(" . basename(__FILE__) . ")</i></p>";
					
				} elseif( $bedingung2 ) {
if(DEBUG)		echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Bedingung 2 wird ausgeführt... <i>(" . basename(__FILE__) . ")</i></p>";					
				
				} else {
if(DEBUG)		echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Bedingungen wurden nicht erfüllt. <i>(" . basename(__FILE__) . ")</i></p>";									
				}
				
				echo "<br>";
				echo "<hr>";
				echo "<br>";


/********************************************************************************************/


				/********************************/
				/********** FUNKTIONEN **********/
				/********************************/
				
				function testfunktion($parameter) {
if(DEBUG_F)		echo "<p class='debug'><b>Line  " . __LINE__ .  "</b>: Aufruf " . __FUNCTION__ . "($parameter) <i>(" . basename(__FILE__) . ")</i></p>";	

				}
				
				
/********************************************************************************************/


				echo "<p>Debug-Ausgabe für Funktionsauf:</p>";
				testfunktion("Testwert");
				
				echo "<br>";
				echo "<hr>";
				echo "<br>";


/********************************************************************************************/


				/*****************************/
				/********** KLASSEN **********/
				/*****************************/
				
				class Testklasse {
					
					private $attribute1;
					private $attribute2;
					private $attribute3;
					
					
					/*************************************************************************/
					
					public function getAttribute1() {
						return $this->attribute1;
					}
					public function setAttribute1($value) {
						$this->attribute1 = $value;
					}
					public function getAttribute2() {
						return $this->attribute2;
					}
					public function setAttribute2($value) {
						$this->attribute2 = $value;
					}
					public function getAttribute3() {
						return $this->attribute3;
					}
					public function setAttribute3($value) {
						$this->attribute3 = $value;
					}
					
					
					/*************************************************************************/
					
					
					/********** KONSTRUKTOR **********/
					public function __construct($value1, $value2, $value3="Wert 3") {
if(DEBUG_C)				echo "<h3 class='debugClass'><b>Line  " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "($value1, $value2, $value3)  (<i>" . basename(__FILE__) . "</i>)</h3>";						

						$this->setAttribute1($value1);
						$this->setAttribute2($value2);
						$this->setAttribute3($value3);
						
if(DEBUG_C)				echo "<pre class='debugClass'><b>Line  " . __LINE__ .  "</b> <i>(" . basename(__FILE__) . ")</i>:<br>";					
if(DEBUG_C)				print_r($this);					
if(DEBUG_C)				echo "</pre>";	
					}
					
					
					/*************************************************************************/
					
					
					/********** METHODEN **********/
					public function methodenname($parameter) {
if(DEBUG_C)				echo "<h3 class='debugClass'><b>Line  " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "($parameter) (<i>" . basename(__FILE__) . "</i>)</h3>";
						
					}
					
					
					/*************************************************************************/
					
				}
				
				
/********************************************************************************************/


				echo "<p>Debug-Ausgabe für Objekterstellung:</p>";
				$object = new Testklasse("Wert 1", "Wert 2");
				
				echo "<p>Debug-Ausgabe für Methodenaufruf:</p>";
				$object->methodenname("Wert 1");
				
				echo "<br>";
				echo "<hr>";
				echo "<br>";
				
				
/********************************************************************************************/


				/***********************************************/
				/********** URL-PARAMETERVERARBEITUNG **********/
				/***********************************************/
				
				echo "<p>Debug-Ausgabe für URL-Parameterverarbeitung:</p>";
				if(isset($urlParameter)) {
if(DEBUG)		echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: URL-Parameter 'Parametername' wurde übergeben. <i>(" . basename(__FILE__) . ")</i></p>";					
					
				}
				
				echo "<br>";
				echo "<hr>";
				echo "<br>";


/********************************************************************************************/


				/******************************************/
				/********** FORMULARVERARBEITUNG **********/
				/******************************************/
				
				echo "<p>Debug-Ausgabe für Formularverarbeitung:</p>";
				if(isset($hiddenFieldName)) {
if(DEBUG)		echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Formular 'Hiddenfieldname' wurde abgeschickt. <i>(" . basename(__FILE__) . ")</i></p>";					
					
				}
				
				echo "<br>";
				echo "<hr>";
				echo "<br>";
				

/********************************************************************************************/


				/**********************************************************/
				/********** DEBUG-AUSGABE FÜR OR DIE()-KONSTRUKT **********/
				/**********************************************************/
				
				echo "<p>Debug-Ausgabe für OR DIE()-Konstrukt:</p>";
				// Original:
				// $statement->execute() OR DIE( "<p class='debug'>Line <b>" . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>" );
				DIE( "<p class='debug'>Line <b>" . __LINE__ . "</b>: " . "ERROR: You have an error in your SQL-syntax. Check near... <i>(" . basename(__FILE__) . ")</i></p>" );


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
	
	</body>

</html>

