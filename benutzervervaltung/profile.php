<?php


/**********************************************************************************************/	
					/************************************************/
					/************* Session fortführen ***************/
					/************************************************/
					
					// session_start() legt eine neue Session an, ODER führt eine bestehende Session fort
					// session_start() holt sich das Session-Cookie vom Browser und vergleicht, ob es eine 
					// passende Session dazu auf dem Server gibt. Falls ja, wird diese Session fortgeführt;
					// falls nein (Cookie existiert nicht/Session existiert nicht), wird eine neue Session angelegt
					
					session_name("benutzerverwaltung");
					session_start();


/**********************************************************************************************/	
					/****************************************************/
					/*************** Seitenzugriffschutz ****************/
					/****************************************************/
					
					if(!isset($_SESSION['usr_id'])){
						//Session löschen
						session_destroy();
						//Umleiten auf index.php
						header("Location: index.php");
						exit;
						
					}



/**********************************************************************************************/	
					/********************************/
					/******** CONFIGURATION *********/
					/********************************/
					
					
					
					/********* INCLUDES *************/
					
					// include(Pfad zur Datei): Bei Fehler wird das Skript weiter ausgeführt. Problem mit doppelter Einbindung derselben Datei
					// require(Pfad zur Datei): Bei Fehler wird das Skript gestoppt. Problem mit doppelter Einbindung derselben Datei
					// include_once(Pfad zur Datei): Bei Fehler wird das Skript weiter ausgeführt. Kein Problem mit doppelter Einbindung derselben Datei
					// require_once(Pfad zur Datei): Bei Fehler wird das Skript gestoppt. Kein Problem mit doppelter Einbindung derselben Datei
					require_once("include/config.inc.php");
					require_once("include/db.inc.php");
					require_once("include/form.inc.php");
					
					
/**********************************************************************************************/	
					/*******************************************/
					/******** Variablen Initializieren *********/
					/*******************************************/
					$monthsArray = array("01"=>"Januar","02"=>"Februar","03"=>"März","04"=>"April","05"=>"Mai","06"=>"Juni","07"=>"Juli","08"=>"August","09"=>"September","10"=>"Oktober","11"=>"November","12"=>"Dezember");
					$day = NULL;
					$month = NULL;
					$year = NULL;
				
					
					$errorFirstname = NULL;
					$errorLastname = NULL;
					$errorEmail = NULL;
					$errorImageUpload = NULL;
					$errorPassword = NULL;


/**********************************************************************************************/
					/**************************************************************/
					/************ User und Accountdaten aus DB auslesen ***********/
					/**************************************************************/
					
					//1DB: Verbindung
					$pdo = dbConnect();
					
					//2DB: SQL-Statement Vorbereiten
					$statement = $pdo->prepare("SELECT * FROM accounts
												INNER JOIN users USING(usr_id)
												INNER JOIN state USING(sta_id)
												INNER JOIN role USING(rol_id)
												WHERE usr_id = :ph_usr_id
												");
					//3DB: Statement ausführen
					$statement->execute(array(
											"ph_usr_id" => $_SESSION['usr_id']
										)) OR DIE( "<p class='debug'>Line <b>" . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>"); 
					
					//4DB: Weiterverarbeiten
					$row = $statement->fetch(PDO::FETCH_ASSOC);
					echo "<pre>";
					print_r($row);
					echo "</pre>";
					
					//Aus Tabelle "users"
					$firstname = $row['usr_firstname'];
					$lastname  = $row['usr_lastname'];
					$email 		 = $row['usr_email'];
					$street  = $row['usr_street'];
					$housenumber  = $row['usr_housenumber'];
					$zip  = $row['usr_zip'];
					$city  = $row['usr_city'];
					$country  = $row['usr_country'];
					
					//Aus Tabelle "accounts"
					$signature   = $row['acc_signature'];
					$info   = $row['acc_info'];
					$avatar  = $row['acc_avatarpath'];
					$accountname  = $row['acc_name'];
					
					//Aus Tabelle "roles"
					$rolelabel = $row['rol_label'];
					
					//Aus Tabelle "state"
					$statelabel = $row['sta_label'];
	
/**********************************************************************************************/	
					/**************************************************/
					/************ URL-Parameterverarbeitung ***********/
					/**************************************************/
					
					//1URL: Prüfen, ob Parameter übergeben wurde
					if(isset($_GET['action'])){
if(DEBUG)				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: URL-Paranmeter 'action wurde übergeben'<i>(" . basename(__FILE__) . ")</i></p>";	
						$action = cleanString($_GET['action']);
if(DEBUG)				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: action: $action'<i>(" . basename(__FILE__) . ")</i></p>";	

						//3URL: Verzweigen
						/************ LOGOUT ***********/
						if($action=="logout"){
if(DEBUG)					echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Logout wird durchgeführt action: $action'<i>(" . basename(__FILE__) . ")</i></p>";	
						
							//4URL: Daten weiterverarbeiten
							
							/*********** LOgouttimestamp in DB schreiben *************/
							/************* DB-Operation ***************/
							//1DB: Verbindung herstellen
							$pdo = dbConnect();
							
							//2DB: SQL-Statement vorbereiten
							$statement = $pdo->prepare("UPDATE accounts
														SET
														acc_lastlogout = NOW()
														WHERE usr_id = :ph_usr_id
														");
							//3DB: SQL-Statement ausführen, Platzhalter füllen
							$statement->execute(array(
														"ph_usr_id" => $_SESSION['usr_id']
														))OR DIE( "<p class='debug'>Line <b>" . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>");
							
							//4DB: Daten weiterverarbeiten
							//Bei Update: Schreiberfolg
							$updateSuccess = $statement->rowCount();
if(DEBUG) 					echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: updateSuccess: $updateSuccess <i>(" . basename(__FILE__) . ")</i></p>";										
										
							if(!$updateSuccess){
								//Fehler
if(DEBUG) 						echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Fehler beim Scheriben des LOgout Timestamps <i>(" . basename(__FILE__) . ")</i></p>";											
							}else{
								//Erfolg
if(DEBUG) 						echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Timestamp wurde erfolgreich in DB geschrieben <i>(" . basename(__FILE__) . ")</i></p>";											
							}
										
							// Unabhängig davon, ob das Schreiben des Logout-Timestamps erfolgreich war,
							// geht es hier weiter
											
							
							/*********** Session löschen *************/
							session_destroy();
							
							
							/*********** Weiterleiten auf Indexseite *************/
							header("Location: index.php");
							exit;


							
						} // Logout Ende
						
					} // URL-Parameterverarbeitung Ende



/**********************************************************************************************/	
?>
<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>Benutzerverwaltung - Profile</title>
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<link rel="stylesheet" type="text/css" href="css/debug.css">
	</head>

	<body>
		<br>
		<header class="loginHeader">
		<p><a href="?action=logout"><< Logout</a></p>
		</header>
		<h1>Benutzerverwaltung - Profile</h1>
		
		<p>Account-Name: <b><?=$accountname?></b> | Account-Status:<b><?=$statelabel?></b> | Account-Role: <b><?=$rolelabel?></b></p>
		<h3 class="info">Hallo <?php echo $_SESSION['usr_firstname']. " ". $_SESSION['usr_lastname']?></h3>
		
		<form action="" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="formsentProfileEdit">

			<fieldset name="userdata">
				<legend>Benutzerdaten</legend>
				<span class="error"><?php echo $errorFirstname ?></span><br>
				<input type="text" name="firstname" placeholder="Vorname" value="<?php echo $firstname ?>"><span class="marker">*</span><br>
				<span class="error"><?php echo $errorLastname ?></span><br>
				<input type="text" name="lastname" placeholder="Nachname" value="<?php echo $lastname ?>"><span class="marker">*</span><br>
				<span class="error"><?php echo $errorEmail ?></span><br>
				<input type="text" name="email" placeholder="Email-Adresse" value="<?php echo $email ?>"><span class="marker">*</span><br>

				<fieldset name="birthdate">
					<legend>Geburtsdatum</legend>
					<select class="day" name="day">
						<option value="">Tag</option>
						<option value="" disabled>- - -</option>
						<?php
							for( $i=1; $i<=31; $i++ ) {
							// Datum mit führender 0 versehen
								$i = sprintf("%02d", $i);
								// Option vorselektieren
								if( $i == $day ) {
									echo "\t\t\t\t\t<option value='$i' selected>$i</option>\r\n";
								} else {
									echo "\t\t\t\t\t<option value='$i'>$i</option>\r\n";
								}
							}
						?>
					</select>
					<select class="month" name="month">
						<option value="">Monat</option>
						<option value="" disabled>- - -</option>
						<?php
							foreach( $monthsArray AS $key=>$value ) {
							// Option vorselektieren
								if( $key == $month ) {
									echo "\t\t\t\t\t<option value='$key' selected>$value</option>\r\n";
								} else {
									echo "\t\t\t\t\t<option value='$key'>$value</option>\r\n";
								}
							}
						?>
					</select>
					<select class="year" name="year">
						<option value="">Jahr</option>
						<option value="" disabled>- - -</option>
						<?php
							for( $i=date("Y"); $i>=date("Y")-120; $i-- ) {
							// Option vorselektieren
							if( $i == $year ) {
							echo "\t\t\t\t\t<option value='$i' selected>$i</option>\r\n";
							} else {
							echo "\t\t\t\t\t<option value='$i'>$i</option>\r\n";
							}
							}
						?>
					</select>
				</fieldset>

				<input type="text" name="street" placeholder="Straße" value="<?php echo $street ?>"><br>
				<input type="text" name="housenumber" placeholder="Nummer" value="<?php echo $housenumber ?>"><br>
				<input type="text" name="zip" placeholder="PLZ" value="<?php echo $zip ?>"><br>
				<input type="text" name="city" placeholder="Ort" value="<?php echo $city ?>"><br>
				<input type="text" name="country" placeholder="Land" value="<?php echo $country ?>"><br>
			</fieldset>

			<fieldset name="accountdata">
				<legend>Accountdaten</legend>
				<input type="text" name="signature" placeholder="Signatur" value="<?php echo $signature ?>"><br>
				<textarea name="info" placeholder="Accountinformationen..."><?php echo $info ?></textarea>

				<fieldset name="avatar">
					<legend>Avatar</legend>
					<img class="avatar" src="<?php echo $avatarpath ?>" alt="Avatar von <?php echo $accountname ?>" title="Avatar von <?php echo $accountname ?>"><br>
					<span class="error"><?php echo $errorImageUpload ?></span><br>
					<input type="file" name="avatar">
				</fieldset> 

				<fieldset name="password">
					<legend>Passwort ändern</legend>
					<span class="error"><?php echo $errorPassword ?></span><br>
					<input type="password" name="password" placeholder="Neues Passwort">
					<input type="password" name="passwordCheck" placeholder="Neues Passwort wiederholen">
				</fieldset>

			</fieldset>

			<input type="submit" value="Änderungen speichern">
		</form>


</body>

</html>