<?php
/*******************************************************************************************/


				/***************************************/
				/************* CLASS USER **************/
				/***************************************/

				/*
					Die Klasse ist quasi der Bauplan/die Vorlage für alle Objekte, die aus ihr erstellt werden.
					Sie gibt die Eigenschaften/Attribute eines späteren Objekts vor (Variablen) sowie 
					die "Handlungen" (Methoden/Funktionen), die das spätere Objekt vornehmen kann.

					Jedes Objekt einer Klasse ist nach dem gleichen Schema aufgebaut (gleiche Eigenschaften und Methoden), 
					besitzt aber i.d.R. unterschiedliche Werte (Variablenwerte).
				*/

				
/*******************************************************************************************/


				class User {
					
					/*******************************/
					/********** ATTRIBUTE **********/
					/*******************************/
					
					// Innerhalb der Klassendefinition müssen Attribute nicht zwingend initialisiert werden
					private $firstname;
					private $lastname;
					private $email;
					private $birthdate;
					
									
					
					/***********************************************************/
					
					
					/*********************************/
					/********** KONSTRUKTOR **********/
					/*********************************/
					
					/*
						Der Konstruktor erstellt eine neue Klasseninstanz/Objekt.
						Soll ein Objekt beim Erstellen bereits mit Attributwerten versehen werden,
						muss ein eigener Konstruktor geschrieben werden. Dieser nimmt die Werte in 
						Form von Parametern	(genau wie bei Funktionen) entgegen und ruft seinerseits 
						die entsprechenden Setter auf, um die Werte zuzuweisen.					
					*/
					
					
					
					
					
					/***********************************************************/

					
					/*************************************/
					/********** GETTER & SETTER **********/
					/*************************************/
				
					/********** FIRSTNAME **********/
					public function getFirstname(){
						return $this->firstname;
					}
					
					public function setFirstname($firstname){
						
						//Vor dem Schreiben auf krrekten Datentyp prüfen
						if(!is_string($firstname)){
							//Fehlerfall
							echo "<p class='error'>Datentyp muss String sein</p>";
						}else{
							//Erfolgsfall
							
							//Wert entschärfen
							$firstname = cleanString($firstname);
							
							// übergebenen Wert in das Attribut schreiben
							$this->firstname = $firstname;
						}
						
						
					}
					
					/********** LASTNAME **********/
					public function getLastname(){
						return $this->lastname;
					}
					
					public function setLastname($lastname){
						
						//Vor dem Schreiben auf krrekten Datentyp prüfen
						if(!is_string($lastname)){
							//Fehlerfall
							echo "<p class='error'>Datentyp muss String sein</p>";
						}else{
							//Erfolgsfall
							
							//Wert entschärfen
							$lastname = cleanString($lastname);
							
							// übergebenen Wert in das Attribut schreiben
							$this->lastname = $lastname;
						}
						
						
					}
					
					/********** EMAIL **********/
					public function getEmail(){
						return $this->email;
					}
					
					public function setEmail($email){
						
						//Vor dem Schreiben auf krrekten Datentyp prüfen
						if(!is_string($email)){
							//Fehlerfall
							echo "<p class='error'>Datentyp muss String sein</p>";
						
						}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
							//Fehlerfall
							echo "<p class='error'>$email ist keine gültige Email-Adresse</p>";
							
						
						}else{
							//Erfolgsfall
							
							//Wert entschärfen
							$email = cleanString($email);
							
							// übergebenen Wert in das Attribut schreiben
							$this->email = $email;
						}
						
						
					}
					
					/********** birthdate **********/
					public function getBirthdate(){
						return $this->birthdate;
					}
					
					
					// Type-Hinting: Der Datentyp wird direkt bei Parameterübergaben gecastet (umgewandelt)
					// und muss somit nicht mehr geprüft werden.
					// VORSICHT: Durch das Casten können ggf. ungültige Werte entstehen (String->Integer, Float->Boolean etc.)!
					public function setBirthdate(string $birthdate){
												
						//Wert entschärfen
						$birthdate = cleanString($birthdate);
						
						// übergebenen Wert in das Attribut schreiben
						$this->birthdate = $birthdate;
			
					}
					
					/********** VIRTUELLE ATTRIBUTE **********/
					/*
					Ein virtuelles Attribut ist kein wirklich existierendes Attribut. Es besteht allerdings 
					ein Getter, der das virtuelle Attribut beim Aufruf "zusammenbaut"
					Das folgende virtuelle Attribut fullname gibt den fertig zusammengesetzten first- und lastname
					des Objekts zurück:
					*/
					/******** FULLNAME ********/
					public function getFullname(){
						return  "<i>$this->firstname $this->lastname</i>";
					}
					
					
					
					/***********************************************************/
					

					/******************************/
					/********** METHODEN **********/
					/******************************/
					
				
					
					public function beispielMethode(){
						return "<p><i>Hallo, ich bin eine Klassenmethode der Klasse 'User' Name: $this->firstname.</i></p>";
					}
					
					public function fetchFullName(){
						
						return  "<p><i>$this->firstname $this->lastname</i></p>";
					}
					
					
					
					
					/***********************************************************/
					
				}
				
				
/*******************************************************************************************/
?>