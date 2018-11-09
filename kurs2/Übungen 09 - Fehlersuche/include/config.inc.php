<?php
/****************************************************************************************/


				/******************************************/
				/********** GLOBAL CONFIGURATION **********/
				/******************************************/
				
				// Konstanten werden in PHP mittels der Funktion define() definiert.
				// Konstanten besitzen im Gegensatz zu Variablen kein $-Präfix
				// Üblicherweise werden Konstanten komplett GROSS geschrieben.

				/********** DATABASE CONFIGURATION **********/
				define("DB_SYSTEM", "mysql");
				define("DB_HOST", "localhost");
				define("DB_NAME", "felersuche");
				define("DB_USER", "root");
				define("DB_PWD", "");
			
				/********** FORMULAR CONFIGURATION **********/
				define("INPUT_MIN_LENGTH", 2);
				define("INPUT_MAX_LENGTH", 255);
				

				/********** DEBUGGING **********/
				define("DEBUG", true);
				define("DEBUG_F", true);
				define("DEBUG_DB", true);


/****************************************************************************************/				
?>