<?php
/*************************************************************************************/

			/******************************************/
			/********** GLOBAL CONFIGURATION **********/
			/******************************************/

			// Konstanten werden in PHP mittels der Funktion define() definiert.
			// Konstanten besitzen im Gegensatz zu Variablen kein $-Präfix
			// Üblicherweise werden Konstanten komplett GROSS geschrieben.
			
			
			/********** DATABASE CONFIGURATION **********/
			define("DB_SYSTEM", "mysql");
			define("DB_HOST", "localhost");
			define("DB_NAME", "benutzerverwaltung");
			define("DB_USER", "root");
			define("DB_PWD", "");
			
			
			/********** FORMULAR CONFIGURATION **********/
			define("MIN_INPUT_LENGTH", 2);
			define("MAX_INPUT_LENGTH", 255);
			
			
			/********** IMAGE UPLOAD CONFIGURATION **********/
			define("IMAGE_MAX_WIDTH", 800);
			define("IMAGE_MAX_HEIGHT", 800);
			define("IMAGE_MAX_SIZE", 128*1024);
			define("IMAGE_UPLOAD_PATH", "uploaded_images/");
			define("IMAGE_ALLOWED_MIMETYPES", array("image/jpg", "image/jpeg", "image/gif", "image/png"));
			
			
			/********** STANDARD PATHS CONFIGURATION **********/
			define("AVATAR_DUMMY_PATH", "css/images/avatar_dummy.png");
			
			
			/********** DEBUGGING **********/
			define("DEBUG", true);
			define("DEBUG_F", true);
			define("DEBUG_DB", true);
			

/*************************************************************************************/
?>