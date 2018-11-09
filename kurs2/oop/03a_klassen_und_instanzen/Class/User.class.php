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
					public $firstname;
					public $lastname;
					public $email;
					public $birthdate;
					
									
					
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
				
					/********** ATTRIBUTSNAME **********/
					
					
					
					
					
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