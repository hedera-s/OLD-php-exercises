<?php
/*************************************************************************************/


				/**
				*
				*	Entschärft und bereinigt die Whitespaces eines String
				*
				*	@param String		$inputString	Der zu entschärfende und zu bereinigende String
				*
				*	@return String							Der entschärfte und bereinigte String
				*
				*/
				function cleanString($inputString) {
if(DEBUG_F)		echo "<p class='debugCleanString'>Aufruf cleanString($inputString)</p>";					
					
					// trim() entfernt am Anfang und am Ende eines Strings alle 
					// sog. Whitespaces (Leerzeichen, Tabulatoren, Zeilenumbrüche)
					$inputString = trim($inputString);
					
					// htmlspecialchars() entschärft HTML-Steuerzeichen wie < > & '' ""
					// und ersetzt sie durch &lt;, &gt;, &amp;, &apos; &quot;
					$inputString = htmlspecialchars($inputString);
					
					// bereinigten und entschärften String zurückgeben
					return $inputString;
				}

				
/*************************************************************************************/


				/**
				*
				*	Prüft einen String auf Leerstring, Mindest- und Maximallänge
				*
				*	@param String	$inputString		Der zu prüfende String
				*	@param [Int		$minLength]			Die erforderliche Mindestlänge
				*	@param [Int		$maxLength]			Die erlaubte Maximallänge
				*
				*	@return String/NULL					Ein String bei Fehler, ansonsten NULL
				*
				*/
				function checkInputString($inputString, $minLenght=INPUT_MIN_LENGTH, $maxLength=INPUT_MAX_LENGTH) {
if(DEBUG_F)		echo "<p class='debugCheckInputString'>Aufruf checkInputString($inputString)</p>";					
					
					$errorMessage = NULL;
					
					// Prüfen auf Leerstring
					if( $inputString === "" ) {
						$errorMessage = "Dies ist ein Pflichtfeld!";
					
					// Prüfen auf Mindestlänge
					} elseif( mb_strlen($inputString) < $minLenght ) {
						$errorMessage = "Muss mindestens $minLenght Zeichen lang sein!";
					
					// Prüfen auf Maximallänge
					} elseif( mb_strlen($inputString) > $maxLength ) {
						$errorMessage = "Darf maximal $maxLength Zeichen lang sein!";
					}
					
					return $errorMessage;
					
				}


/*************************************************************************************/


				/**
				*
				*	Prüft, ob ein übergebener String eine valide Email-Adresse enthält
				*
				*	@param String		$inputString		Der zu prüfende String
				*
				*	@return String/NULL						Ein String bei Fehler, ansonsten NULL
				*
				*/
				function checkEmail($inputString) {
if(DEBUG_F)		echo "<p class='debugCheckEmail'>Aufruf checkEmail($inputString)</p>";

					$errorMessage = NULL;

					// Prüfen auf Leerstring
					if( $inputString === "" ) {
						$errorMessage = "Dies ist ein Pflichtfeld!";
					
					// Email auf Validität prüfen
					} elseif( !filter_var($inputString, FILTER_VALIDATE_EMAIL) ) {
						$errorMessage = "Dies ist keine gültige Email-Adresse!";
					}

					return $errorMessage;
					
				}


/*************************************************************************************/
?>


























