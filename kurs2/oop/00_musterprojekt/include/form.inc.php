<?php
/**********************************************************************************/


				/**
				*
				*	Entschärft und säubert einen String
				*
				*	@param String $inputString - Der zu entschärfende und zu bereinigende String
				*
				*	@return String - Der entschärfte und bereinigte String
				*
				*/
				function cleanString( $inputString ) {
if(DEBUG_F)		echo "<p class='debugCleanString'><b>Line " . __LINE__ . ":</b> Aufruf " . __FUNCTION__ . "('$inputString') <i>(" . basename(__FILE__) . ")</i></p>";
				
					// trim() entfernt am Anfang und am Ende eines Strings alle 
					// sog. Whitespaces (Leerzeichen, Tabulatoren, Zeilenumbrüche)
					$inputString = trim($inputString);
					
					// htmlspecialchars() entschärft HTML-Steuerzeichen wie < > & '' ""
					// und ersetzt sie durch &lt;, &gt;, &amp;, &apos; &quot;
					$inputString = htmlspecialchars($inputString, ENT_QUOTES | ENT_HTML5);
					
					// bereinigten und entschäften String zurückgeben
					return $inputString;
					
				}
				

/**********************************************************************************/

			
				/**
				*
				*	Prüft einen String auf Leerstring, Mindest- und Maxmimallänge
				*
				*	@param String $inputString - Der zu prüfende String
				*	@param [Integer $minLength] - Die erforderliche Mindestlänge
				*	@param [Integer $maxLength] - Die erlaubte Maximallänge
				*
				*	@return String/NULL - Ein String bei Fehler, ansonsten NULL
				*	
				*/
				function checkInputString( $inputString, $minLength=MIN_INPUT_LENGTH, $maxLength=MAX_INPUT_LENGTH ) {
if(DEBUG_F)		echo "<p class='debugCheckInputString'><b>Line " . __LINE__ . ":</b> Aufruf " . __FUNCTION__ . "('$inputString' [min: $minLength, max: $maxLength]) <i>(" . basename(__FILE__) . ")</i></p>";				
				
					$errorMessage = NULL;
					
					// Prüfen auf Leerstring
					if( $inputString === "" ) {
						$errorMessage = "Dies ist ein Pflichtfeld!";
					
					// Auf Mindestlänge prüfen
					} elseif( mb_strlen($inputString) < $minLength ) {
						$errorMessage = "Muss mindestens $minLength Zeichen lang sein!";
						
					// Auf Maximallänge prüfen	
					} elseif( mb_strlen($inputString) > $maxLength ) {
						$errorMessage = "Darf maximal $maxLength Zeichen lang sein!";
					}
					
					return $errorMessage;
				}
				

/**********************************************************************************/

			
				/**
				*
				*	Prüft eine Email-Adresse auf Leerstring und Validität
				*
				*	@param String $inputString - Die zu prüfende Email-Adresse
				*
				*	@return String/NULL - Ein String bei Fehler, ansonsten NULL
				*
				*/
				function checkEmail($inputString) {
if(DEBUG_F)		echo "<p class='debugCheckEmail'><b>Line " . __LINE__ . ":</b> Aufruf " . __FUNCTION__ . "('$inputString') <i>(" . basename(__FILE__) . ")</i></p>";				
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
				

/**********************************************************************************/


				/**
				*
				*	Speichert und prüft ein hochgeladenen Bild auf MIME-Type, Datei- und Bildgröße
				*
				*	@param Array $uploadedImage		- Das hochzuladende Bild aus $_FILES
				*	@param [Int $maxWidth]				- Die maximal erlaubte Bildbreite in Px
				*	@param [Int $maxHeigth]				- Die maximal erlaubte Bildhöhe in Px
				*	@param [Int $maxSize]				- Die maximal erlaubte Dateigröße in Bytes
				*	@param [String $uploadPath]		- Das Speicher-Verzeichnis auf dem Server
				*	@param [Array $allowedMimeTypes]	- Whitelist der erlaubten MIME-Types
				*
				*	@return Array {String/NULL - Fehlermeldung im Fehlerfall, String - Der Speicherpfad auf dem Server}
				*
				*/
				function imageUpload($uploadedImage,
											$maxWidth 			= IMAGE_MAX_WIDTH,
											$maxHeight 			= IMAGE_MAX_HEIGHT,
											$maxSize 			= IMAGE_MAX_SIZE,
											$uploadPath 		= IMAGE_UPLOAD_PATH,
											$allowedMimeTypes = IMAGE_ALLOWED_MIMETYPES
											) {
if(DEBUG_F)		echo "<p class='debugImageUpload'><b>Line " . __LINE__ . ":</b> Aufruf " . __FUNCTION__ . "() <i>(" . basename(__FILE__) . ")</i></p>";

					/*
						Das Array $_FILES['avatar'] bzw. $uploadedImage enthält:
						Den Dateinamen [name]
						Den generierten (also ungeprüften) MIME-Type [type]
						Den temporären Pfad auf dem Server [tmp_name]
						Die Dateigröße in Bytes [size]
					*/
if(DEBUG_F)		echo "<pre class='debugImageUpload'><b>Line " . __LINE__ . ":</b> ";
if(DEBUG_F)		print_r($uploadedImage);
if(DEBUG_F)		echo "</pre>";				
					
					
					/********** BILDINFORMATIONEN SAMMELN **********/
					
					// Dateiname
					$fileName = $uploadedImage['name'];
					// ggf. Leerzeichen im Dateiname durch "_" ersetzen
					$fileName = str_replace(" ", "_", $fileName);
					// Dateinamen in Kleinbuchstaben umwandeln
					$fileName = strtolower($fileName);
				
					// Dateigröße
					$fileSize = $uploadedImage['size'];
					
					// Temporärer Pfad auf dem Server
					$fileTemp = $uploadedImage['tmp_name'];
					
					// zufälligen Dateinamen generieren
					$randomPrefix = rand(1,999999) . str_shuffle("abcdefghijklmnopqrstuvwxyz") . time();
					$fileTarget = $uploadPath . $randomPrefix . "_" . $fileName;
					
if(DEBUG_F)		echo "<p class='debugImageUpload'><b>Line " . __LINE__ . ":</b> \$fileName: $fileName <i>(" . basename(__FILE__) . ")</i></p>";				
if(DEBUG_F)		echo "<p class='debugImageUpload'><b>Line " . __LINE__ . ":</b> \$fileSize: " . round($fileSize/1024, 2) . " kB <i>(" . basename(__FILE__) . ")</i></p>";				
if(DEBUG_F)		echo "<p class='debugImageUpload'><b>Line " . __LINE__ . ":</b> \$fileTemp: $fileTemp <i>(" . basename(__FILE__) . ")</i></p>";				
if(DEBUG_F)		echo "<p class='debugImageUpload'><b>Line " . __LINE__ . ":</b> \$fileTarget: $fileTarget <i>(" . basename(__FILE__) . ")</i></p>";				
				
					// Geneure Informationen zum Bild holen
					$imageData = @getimagesize($fileTemp);
					
					/*
						Die Funktion getimagesize() liefert bei gültigen Bildern ein Array zurück:
						Die Bildbreite in PX [0]
						Die Bildhöhe in PX [1]
						Einen für die HTML-Ausgabe vorbereiteten String für das IMG-Tag
						(width="480" height="532") [3]
						Die Anzahl der Bits pro Kanal ['bits']
						Die Anzahl der Farbkanäle (somit auch das Farbmodell: RGB=3, CMYK=4) ['channels']
						Den echten(!) MIME-Type ['mime']
					*/
if(DEBUG_F)		echo "<pre class='debugImageUpload'><b>Line " . __LINE__ . ":</b> ";
if(DEBUG_F)		print_r($imageData);
if(DEBUG_F)		echo "</pre>";						
					
					$imageWidth 	= $imageData[0];
					$imageHeight 	= $imageData[1];
					$imageMimeType	= $imageData['mime'];
if(DEBUG_F)		echo "<p class='debugImageUpload'><b>Line " . __LINE__ . ":</b> \$imageWidth: $imageWidth px <i>(" . basename(__FILE__) . ")</i></p>";				
if(DEBUG_F)		echo "<p class='debugImageUpload'><b>Line " . __LINE__ . ":</b> \$imageHeight: $imageHeight px <i>(" . basename(__FILE__) . ")</i></p>";				
if(DEBUG_F)		echo "<p class='debugImageUpload'><b>Line " . __LINE__ . ":</b> \$imageMimeType: $imageMimeType <i>(" . basename(__FILE__) . ")</i></p>";


					/********** BILD PRÜFEN **********/
					
					// MIME-Type prüfen
					// Whitelist mit erlaubten Bildtypen
					// $allowedMimeTypes = array("image/jpg", "image/jpeg", "image/gif", "image/png");
					
					if( !in_array($imageMimeType, $allowedMimeTypes) ) {
						$errorMessage = "Dies ist kein gültiger Bildtyp!";
						
					// Maximal erlaubte Bildhöhe	
					} elseif( $imageHeight > $maxHeight ) {
						$errorMessage = "Die Bildhöhe darf maximal $maxHeight Pixel betragen!";
					
					// Maximal erlaubte Bildbreite 					
					} elseif( $imageWidth > $maxWidth ) {
						$errorMessage = "Die Bildbreite darf maximal $maxWidth Pixel betragen!";
					
					// Maximal erlaubte Dateigröße 					
					} elseif( $fileSize > $maxSize ) {
						$errorMessage = "Die Dateigröße darf maximal " . round($maxSize/1024, 2) . " kB betragen!";
					
					// Wenn es keinen Fehler gab  					
					} else {
						$errorMessage = NULL;
					}

					
					/********** BILD SPEICHERN **********/
					
					if( !$errorMessage ) {
						// Erfolgsfall
if(DEBUG_F)			echo "<p class='debugImageUpload'><b>Line " . __LINE__ . ":</b> Die Bildprüfung ergab keine Fehler. <i>(" . basename(__FILE__) . ")</i></p>";
						
						// Bild an seinen endgültigen Speicherort verschieben
						if( @move_uploaded_file($fileTemp, $fileTarget) ) {
							// Erfolgsfall
if(DEBUG_F)				echo "<p class='debugImageUpload'><b>Line " . __LINE__ . ":</b> Das Bild wurde erfolgreich unter $fileTarget gespeichert. <i>(" . basename(__FILE__) . ")</i></p>";													
						} else {
							// Fehlerfall
							$errorMessage = "FEHLER beim Speichern der Datei auf dem Server!";	
						}	
					}
					
					
					/********** FEHLERMELDUNG UND BILDPFAD ZURÜCKGEBEN **********/
					
					// Um mehrere Werte zurückgeben zu können, muss return ein Array zurückgeben
					return array( "imageError" => $errorMessage, "imagePath" => $fileTarget );
					
				}
				

/**********************************************************************************/
?>



















