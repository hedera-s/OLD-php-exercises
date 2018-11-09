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


				class Author {
					
					/*******************************/
					/********** ATTRIBUTE **********/
					/*******************************/
					
					// Innerhalb der Klassendefinition müssen Attribute nicht zwingend initialisiert werden
					private $firstname;
					private $lastname;
					private $birthplace;
					
									
					
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
					
					public function __construct($firstname=NULL, $lastname=NULL, $birthplace=NULL){
if(DEBUG_C)				echo "<h3 class='debugClass'><b>Line  " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "()  (<i>" . basename(__FILE__) . "</i>)</h3>";
						if($firstname) $this->setFirstname($firstname);
						if($lastname) $this->setLastname($lastname);
						if($birthplace) $this->setBirthplace($birthplace);
						
if(DEBUG_C)				echo "<pre class='debugClass'><b>Line  " . __LINE__ .  "</b> <i>(" . basename(__FILE__) . ")</i>:<br>";					
if(DEBUG_C)				print_r($this);					
if(DEBUG_C)				echo "</pre>";
					}
					
					
					
					
					
					/***********************************************************/

					
					/*************************************/
					/********** GETTER & SETTER **********/
					/*************************************/
				
					/********** FIRSTNAME **********/
					public function getFirstname(){
						return $this->firstname;
					}
					
					public function setFirstname($firstname){
						
						$this->firstname = $firstname;
						
					}
					
					/********** LASTNAME **********/
					public function getLastname(){
						return $this->lastname;
					}
					
					public function setLastname($lastname){
						
						$this->lastname = $lastname;
						
					}
					
					/********** BIRTHPLACE **********/
					public function getBirthplace(){
						return $this->birthplace;
					}
					
					public function setBirthplace($birthplace){
						$this->birthplace = $birthplace;
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
						$fullname = $this->getFirstname(). " " . $this->getLastname();
						return $fullname;
					}
					
					/***********************************************************/
					

					/******************************/
					/********** METHODEN **********/
					/******************************/
					
				
					
					
					
					/***********************************************************/
					
				}
				
				
/*******************************************************************************************/
?>