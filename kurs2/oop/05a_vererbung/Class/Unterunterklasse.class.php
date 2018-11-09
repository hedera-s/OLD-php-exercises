<?php
/*******************************************************************************************/


				/***************************************/
				/********** CLASS KLASSENNAME **********/
				/***************************************/

				/*
					Die Klasse ist quasi der Bauplan/die Vorlage für alle Objekte, die aus ihr erstellt werden.
					Sie gibt die Eigenschaften/Attribute eines späteren Objekts vor (Variablen) sowie 
					die "Handlungen" (Methoden/Funktionen), die das spätere Objekt vornehmen kann.

					Jede Objekt einer Klasse ist nach dem gleichen Schema aufgebaut (gleiche Eigenschaften und Methoden), 
					besitzt aber i.d.R. unterschiedliche Werte (Variablenwerte).
				*/

				
/*******************************************************************************************/


				class Unterunterklasse extends Unterklasse {
					
					/*******************************/
					/********** ATTRIBUTE **********/
					/*******************************/
					
					// Innerhalb der Klassendefinition müssen Attribute nicht zwingend initialisiert werden
					
					
					
					
					
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
					
					public function HelloWorld(){
if(DEBUG_C) 			echo "<h3 class='debugClass'><b>Line " . __LINE__ . "</b>: Aufruf " . __METHOD__ . "() (<i>" . basename(__FILE__) . "</i>)</h3>";						
						
						echo "<h3>Name: ". $this->name ."</h3>";
						
						// Methode "HelloWorld" der Unterklasse aufrufen:
						parent::HelloWorld();
						
						echo "<h4>Unterunterklasse sagt: <i>Ich bin die Unterunterklasse. Eben habe ich eine Methode meiner Elternklasse aufgerufen.</i></h4>";
						echo "<h4>Und jetzt habe ich fertig.</h4>";
					}
					
					
					
					/***********************************************************/
					
				}
				
				
/*******************************************************************************************/
?>