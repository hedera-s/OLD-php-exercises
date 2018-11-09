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


				class Book {
					
					/*******************************/
					/********** ATTRIBUTE **********/
					/*******************************/
					
					// Innerhalb der Klassendefinition müssen Attribute nicht zwingend initialisiert werden
					private $title;
					private $releaseyear;
					private $price;
					private $author;
					
									
					
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
					
					public function __construct($title=NULL, $releaseyear=NULL, $price=NULL, $author=NULL){
if(DEBUG_C)				echo "<h3 class='debugClass'><b>Line  " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "()  (<i>" . basename(__FILE__) . "</i>)</h3>";
						
						// Setter nur aufrufen, wenn die jeweiligen Parameter einen gültigen Wert hat
						if($title) 			$this->setTitle($title);
						if($releaseyear) 	$this->setReleaseyear($releaseyear);
						if($price) 			$this->setPrice($price);
						if($author) 		$this->setAuthor($author);

if(DEBUG_C)				echo "<pre class='debugClass'><b>Line  " . __LINE__ .  "</b> <i>(" . basename(__FILE__) . ")</i>:<br>";					
if(DEBUG_C)				print_r($this);					
if(DEBUG_C)				echo "</pre>";
						
							
					}
					
					
					
					
					
					
					/***********************************************************/

					
					/*************************************/
					/********** GETTER & SETTER **********/
					/*************************************/
				
					/********** TITLE ***********/
					public function getTitle(){
						return $this->title;
					}
					
					public function setTitle($title){
						$this->title = $title;
					}
					
					/********** RELEASEYEAR ***********/
					public function getReleaseyear(){
						return $this->releaseyear;
					}
					
					public function setReleaseyear($releaseyear){
						$this->releaseyear = $releaseyear;
					}
					
					/********** AUTHOR ***********/
					public function getAuthor(){
						return $this->author;
					}
					
					public function setAuthor($author){
						
						// Vor dem Schreiben auf Datentyp Objekt prüfen
						if(!$author instanceof Author){
							//Fehlerfall
if(DEBUG_C)					echo "<p class='debugClass err'>Line <b>" . __LINE__ . "</b>: Dies ist kein Objekt <i>(" . basename(__FILE__) . ")</i></p>";							
							
						}else{
							//Erfolgsfall
							$this->author = $author;
						}
						
						
					}
					
					
					
					
					/********** PRICE ***********/
					public function getPrice(){
						return $this->price;
					}
					
					public function setPrice($price){
						$this->price = $price;
					}
					
					
					/********** Delegation für Author ***********/
					
					public function getAuthorFullname(){
						return $this->getAuthor()->getFullname();
					}
					
					
					/********** VIRTUELLE ATTRIBUTE **********/
					/*
					Ein virtuelles Attribut ist kein wirklich existierendes Attribut. Es besteht allerdings 
					ein Getter, der das virtuelle Attribut beim Aufruf "zusammenbaut"
					Das folgende virtuelle Attribut fullname gibt den fertig zusammengesetzten first- und lastname
					des Objekts zurück:
					*/
					
					
					
					
					/***********************************************************/
					

					/******************************/
					/********** METHODEN **********/
					/******************************/
					
				
					
					public function beispielMethode(){
if(DEBUG_C)				echo "<h3 class='debugClass'><b>Line  " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "() (<i>" . basename(__FILE__) . "</i>)</h3>";						
						return "<p><i>Hallo, ich bin eine Klassenmethode der Klasse 'User' Name: $this->firstname.</i></p>";
					}
					
					public function fetchFullName(){
if(DEBUG_C)				echo "<h3 class='debugClass'><b>Line  " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "() (<i>" . basename(__FILE__) . "</i>)</h3>";						
						return  $this->firstname ." ". $this->lastname;
					}
					
					
					
					
					/***********************************************************/
					
				}
				
				
/*******************************************************************************************/
?>