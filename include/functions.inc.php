<?php
/********************************************************************************/

		/**
		*
		* Zählt, wie häufig ein Teilstring innerhalb eines Strings vorkommt
		* Ersetzt den Teilstring innerhalb des Strings durch einen anderen String
		*
		* @param String		$haystack		Der zu durchsuchende String
		* @param String		$needle			Der zu suchende Teilstring
		* @param String		$replacement	Die Ersetzung für den zu suchenden Teilstring
		*
		* @return Array		(Int "anzahl", String "string") Anzahl der gefundenen Treffer, Der aktualisierte String
		*
		*/

			function suchenUndErsetzenUndZaehlen($haystack, $needle, $replacement){
if(DEBUG)		echo "<p class='debug'>Aufruf: suchenUndErsetzenUndZaehlen() </p>";
if(DEBUG)		echo "<p class='debug'>haystack: $haystack</p>";				
if(DEBUG)		echo "<p class='debug'>needle: $needle</p>";				
if(DEBUG)		echo "<p class='debug'>replacement: $replacement</p>";		

				//1. Zählen, wie häufig $needle in $haystack vorkommt
				$anzahl = substr_count($haystack, $needle); //Liefert Anzahl von $needle in $haystack
if(DEBUG)		echo "<p class='debug'>anzahl: $anzahl</p>";		
				
				//2. Alle Vorkommen von $needle in $haystack ersetzen durch $replacement
				$newString = str_replace($needle, $replacement, $haystack);
if(DEBUG)		echo "<p class='debug'>newString: $newString</p>";	
				
				//3. Anzahl und neuen String zurückgeben
				return array("anzahl" =>$anzahl, "string"=>$newString);
			
			}
/********************************************************************************/

		/**
		*
		* Rechnet mit 2 Zahlwerten in den 4 Grungrechenarten
		*
		* @param Int/Float	$zahl1			1. Zahlenwert
		* @param [Int/Float	$zahl1			2. Zahlenwert]
		* @param String		$operator="+"	Der anzuwendende Rechenoperator
		*
		* @return Mixed						Das Rechenergebnis/ bei ungültigem Operator eine Fehlermeldung
		*
		*/

			function rechne3($zahl1, $zahl2, $operator="+"){
if(DEBUG)		echo "<p class='debug'>Aufruf: rechne3($zahl1, $zahl2, $operator) </p>";
				switch($operator){
					case "+":	$ergebnis = $zahl1+$zahl2;
								break;					
					case "-":	$ergebnis = $zahl1-$zahl2;
								break;
					case "*":	$ergebnis = $zahl1*$zahl2;
								break;
					case "/":	$ergebnis = $zahl1/$zahl2;
								break;
					default:	$ergebnis = "Ungültiger Rechenoperator";
					
					
				}
				return $ergebnis;
			}

/********************************************************************************/
		/**
		*
		* Rechnet mit 2 Zahlwerten in den 4 Grungrechenarten
		*
		* @param [Int/Float	$zahl1=5		1. Zahlenwert]
		* @param [String	$operator="+"	Der anzuwendende Rechenoperator]
		* @param [Int/Float	$zahl1=10		2. Zahlenwert]
		*
		* @return Mixed					Das Rechenergebnis/ bei ungültigem Operator eine Fehlermeldung
		*
		*/

			function rechne2($zahl1=5, $operator="+", $zahl2=10){
if(DEBUG)		echo "<p class='debug'>Aufruf: rechne2($zahl1, $operator, $zahl2) </p>";
				switch($operator){
					case "+":	$ergebnis = $zahl1+$zahl2;
								break;					
					case "-":	$ergebnis = $zahl1-$zahl2;
								break;
					case "*":	$ergebnis = $zahl1*$zahl2;
								break;
					case "/":	$ergebnis = $zahl1/$zahl2;
								break;
					default:	$ergebnis = "Ungültiger Rechenoperator";
					
				
				}
				return $ergebnis;
			}
/********************************************************************************/

		/**
		*
		* Rechnet mit 2 Zahlwerten in den 4 Grungrechenarten
		*
		* @param Int/Float	$zahl1		1. Zahlenwert
		* @param String		$operator	Der anzuwendende Rechenoperator
		* @param Int/Float	$zahl1		2. Zahlenwert
		*
		* @return Mixed					Das Rechenergebnis/ bei ungültigem Operator eine Fehlermeldung
		*
		*/
			function rechne1($zahl1, $operator, $zahl2){
if(DEBUG)		echo "<p class='debug'>Aufruf: rechne1($zahl1, $operator, $zahl2) </p>";
				switch($operator){
					case "+":	$ergebnis = $zahl1+$zahl2;
								break;					
					case "-":	$ergebnis = $zahl1-$zahl2;
								break;
					case "*":	$ergebnis = $zahl1*$zahl2;
								break;
					case "/":	$ergebnis = $zahl1/$zahl2;
								break;
					default:	$ergebnis = "Ungültiger Rechenoperator";
					
				
				}
				return $ergebnis;
			}
			
/********************************************************************************/
?>