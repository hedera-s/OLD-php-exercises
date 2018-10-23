<?php
/********************************************************************************************/

			/**
			*
			* Entschärft und bereinigt die Whitespaces
			*
			* @param 	String 	$inputString 	Der zu entscärfende und bereinigente 
			* 
			* @return 	String					Der entschärfte und bereinigte String
			*
			*/

			function cleanString($inputString){
if(DEBUG_F)		echo "<p class='debugCleanString'><b>Line  " . __LINE__ .  "</b>: Aufruf " . __FUNCTION__ . "($inputString) <i>(" . basename(__FILE__) . ")</i></p>";		
				
				// trim() entfernt am Anfang und am Ende eines Strings alle 
				// sog. Whitespaces (Leerzeichen, Tabulatoren, Zeilenumbrüche)
				$inputString= trim($inputString);
				
				// htmlspecialchars() entschärft HTML-Steuerzeichen wie < > & '' ""
				// und ersetzt sie durch &lt;, &gt;, &amp;, &apos; &quot;
				$inputString = htmlspecialchars($inputString);
				
				// bereinigten und entschärften String zurückgeben
				return $inputString;
				
				
			}
	
/********************************************************************************************/	

			/**
			* Prüft einen String auf Leerstring, Mindest- und maximallänge
			*
			* @param 	String 	$inputString 	Der zu prüfende String
			* @param	[Int	$minLength]		Die erforderliche Mindestlänge
			* @param	[Int	$maxLength]		Die erforderliche Maximallänge
			*
			* @return 	String/NULL				Ein String bei Fehler, ansonsten NULL
			*/
			
			function checkInputString($inputString, $minLength=INPUT_MIN_LENGTH, $maxLength=INPUT_MAX_LENGTH){
if(DEBUG_F) echo "<p class='debugCheckInputString'><b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "($inputString, [$minLength], [$maxLength]) <i>(" . basename(__FILE__) . ")</i></p>";
				
				$errorMessage = NULL;
				
				//Prüfen auf Leerstring
				if($inputString === ""){
					$errorMessage = "Dies ist ein Pflichtfeld!";
					//Prüfen auf Mindestlänge
				} elseif(mb_strlen($inputString) < $minLength){
					$errorMessage = "Darf mind. $minLength Zeichen lang sein!";
					//Prüfen auf Maximale Länge
				} elseif(mb_strlen($inputString) > $maxLength){
					$errorMessage = "Darf max. $maxLength Zeichen lang sein!";
				}
								
				return $errorMessage;
				
			}


/********************************************************************************************/	
			
			/**
			* Prüft ob ein übergebener String eine Valide Email-adresse enthält
			*
			* @param 	String 	$inputString 	Der zu prüfende String
			* 
			*
			* @return 	String/NULL				Ein String bei Fehler, ansonsten NULL
			*/

			function checkEmail($inputString){
if(DEBUG_F) echo "<p class='debugCheckEmail'><b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "($inputString) <i>(" . basename(__FILE__) . ")</i></p>";
				
				$errorMessage = NULL;
				//Prüfen auf Leerstring
				if($inputString === ""){
					$errorMessage = "Dies ist ein Pflichtfeld!";
				// Auf Validität prüfen
				} elseif( !filter_var($inputString, FILTER_VALIDATE_EMAIL) ){
					$errorMessage = "Dies ist ekeine gültige Email-Adresse";
				}
				
				return $errorMessage;
			
			}

/********************************************************************************************/	

?>