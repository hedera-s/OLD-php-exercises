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
					
					/************DB-Verbindung*************/
					//1DB: Verbindung
					$pdo = dbConnect();
					
					
/**********************************************************************************************/	
					/*******************************************/
					/******** Variablen Initializieren *********/
					/*******************************************/
					$monthsArray 	= array("01"=>"Januar","02"=>"Februar","03"=>"März","04"=>"April","05"=>"Mai","06"=>"Juni","07"=>"Juli","08"=>"August","09"=>"September","10"=>"Oktober","11"=>"November","12"=>"Dezember");
					$day 			= NULL;
					$month 			= NULL;
					$year 			= NULL;
					
				
					
					$errorFirstname = NULL;
					$errorLastname 	= NULL;
					$errorEmail 	= NULL;
					$errorImageUpload = NULL;
					$errorPassword 	= NULL;
					
					$passwordChange = false;
					
					$dbMessage 		= NULL;


/**********************************************************************************************/
					/**************************************************************/
					/************ User und Accountdaten aus DB auslesen ***********/
					/**************************************************************/
					
					
					
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
					
					
					//Aus Tabelle "users"
					$firstname = $row['usr_firstname'];
					$lastname  = $row['usr_lastname'];
					$email 		 = $row['usr_email'];
					$birthdate = $row['usr_birthdate'];
					// $birthdate nur dann verarbeiten, wenn es einen gültigen Wert hat
					// (ansonsten wird strtotime() ein ungültiger Timestamp übergeben)
					if( $birthdate ) {
					// $birthdate für Formularvorbelegung aufsplitten
						$day = date( "d", strtotime($birthdate) );
						$month = date( "m", strtotime($birthdate) );
						$year = date( "Y", strtotime($birthdate) );
					}
					
					$street  = $row['usr_street'];
					$housenumber  = $row['usr_housenumber'];
					$zip  = $row['usr_zip'];
					$city  = $row['usr_city'];
					$country  = $row['usr_country'];
					
					
					//Aus Tabelle "accounts"
					$signature   = $row['acc_signature'];
					$info   = $row['acc_info'];
					$avatarPath  = $row['acc_avatarpath'];
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
					/**************************************************/
					/************** FORMULAR-Verarbeitung *************/
					/**************************************************/
					
					if(isset($_POST['formsentProfileEdit'])){
if(DEBUG) 				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Formular abgeschickt <i>(" . basename(__FILE__) . ")</i></p>";	

						
						
						$firstname 		= cleanString($_POST['firstname']);
						$lastname 		= cleanString($_POST['lastname']);
						$email 			= cleanString($_POST['email']);
						
						// Da die Datumsselektoren ein Leerfeld besitzen ("Tag", "Monat", "Jahr"),
						// muss darauf geachtet werden, dass hier keine Leerstrings in die DB
						// geschrieben werden. Standardwert von usr_birthdate ist NULL, daher an dieser 
						// Stelle im Fall eines Leerstrings NULL schreiben
						
						$day 			= cleanString($_POST['day']);
						$month 			= cleanString($_POST['month']);
						$year 			= cleanString($_POST['year']);
						if(!$day || !$month || !$year){
							$birthdate = NULL;
						} else {
							$birthdate = "$year-$month-$day";
						}
						
						$street 		= cleanString($_POST['street']);
						$housenumber 	= cleanString($_POST['housenumber']);
						$zip 			= cleanString($_POST['zip']);
						$city 			= cleanString($_POST['city']);
						$country 		= cleanString($_POST['country']);
						$signature 		= cleanString($_POST['signature']);
						$info 			= cleanString($_POST['info']);
						$password		= cleanString($_POST['password']);
						$passwordCheck	= cleanString($_POST['passwordCheck']);
						
if(DEBUG) 				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: firstname: $firstname <i>(" . basename(__FILE__) . ")</i></p>";								
if(DEBUG) 				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: lastname: $lastname <i>(" . basename(__FILE__) . ")</i></p>";								
if(DEBUG) 				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: email: $email <i>(" . basename(__FILE__) . ")</i></p>";								
if(DEBUG) 				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: day: $day <i>(" . basename(__FILE__) . ")</i></p>";								
if(DEBUG) 				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: month: $month <i>(" . basename(__FILE__) . ")</i></p>";								
if(DEBUG) 				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: year: $year <i>(" . basename(__FILE__) . ")</i></p>";
if(DEBUG) 				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: birthdate: $birthdate <i>(" . basename(__FILE__) . ")</i></p>";
								
if(DEBUG) 				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: street: $street <i>(" . basename(__FILE__) . ")</i></p>";								
if(DEBUG) 				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: housenumber: $housenumber <i>(" . basename(__FILE__) . ")</i></p>";								
if(DEBUG) 				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: zip: $zip<i>(" . basename(__FILE__) . ")</i></p>";								
if(DEBUG) 				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: city: $city <i>(" . basename(__FILE__) . ")</i></p>";								
if(DEBUG) 				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: country: $country <i>(" . basename(__FILE__) . ")</i></p>";								
if(DEBUG) 				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: signature: $signature <i>(" . basename(__FILE__) . ")</i></p>";								
if(DEBUG) 				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: info: $info <i>(" . basename(__FILE__) . ")</i></p>";	
if(DEBUG) 				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: password: $password <i>(" . basename(__FILE__) . ")</i></p>";	
if(DEBUG) 				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: passwordCheck: $passwordCheck <i>(" . basename(__FILE__) . ")</i></p>";	

						/******************************************************************/
						/************************ Password change *************************/
						
						if($password){
if(DEBUG) 					echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Passwortänderung aktiv<i>(" . basename(__FILE__) . ")</i></p>";								
							
							//password auf MIndestlänge prüfen
							$errorPassword = checkInputString($password, 4);
							
							if(!$errorPassword){
if(DEBUG) 						echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Das neue Passwort erfüllt die Voarussetzungen<i>(" . basename(__FILE__) . ")</i></p>";												
								// Password-Vergleich
								
								if($password != $passwordCheck){
									//Fehler
if(DEBUG) 							echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: Passworte stimmen nicht überein<i>(" . basename(__FILE__) . ")</i></p>";		
									$errorPassword = "Passworde stimmen nicht";
								} else {
									//Erfolg
if(DEBUG) 							echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Die Passworde stimmen überein<i>(" . basename(__FILE__) . ")</i></p>";	
									//Neues Passwort verschlüsseln
									$passwordHash = password_hash($password, PASSWORD_DEFAULT);
if(DEBUG) 							echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: passwordHash: $passwordHash <i>(" . basename(__FILE__) . ")</i></p>";	
									
									// Flag setzen, damit beim DB-UPDATE das neue Password mitgespeichert wird
									$passwordChange = true;
									
								}
								
							}
						}
							
						/************************ Password change End**********************/
						/******************************************************************/

						$errorFirstname = checkInputString($firstname);
						$errorLastname = checkInputString($lastname);
						$errorEmail = checkEmail($email);
						
						//Abschließende Formularprüfung TEIL 1:
						if($errorFirstname || $errorLastname || $errorEmail || $errorPassword){
							//Fehlerfall
if(DEBUG) 					echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: Das Formular enthält noch Fehler <i>(" . basename(__FILE__) . ")</i></p>";								
						} else {
							//Erfolgsfall

							
							
							
							
							
							
							// Nur wenn Formularfelder fehlerfrei sind, soll der Bildupload durchgeführt werden,
							// da ansonsten trotz Feld-Fehler im Formular das neue Bild auf dem Server gespeichert 
							// und das alte Bild gelöscht wäre
							/**********************************************/

							
							
							/**********************************/
							/********** FILE UPLOAD ***********/
							/**********************************/

							// Prüfen, ob eine Bilddatei hochgeladen wurde
							if($_FILES['avatar']['tmp_name']){
if(DEBUG) 						echo "<p class='debug hint'>Line <b>" . __LINE__ . "</b>: Bildupload aktiv...<i>(" . basename(__FILE__) . ")</i></p>";		
								
								$avatar = $_FILES['avatar'];
								$imageUploadReturnArray = imageUpload($avatar);
								
								//Prüfen, ob es einen Bildupload Fehler gab
								if($imageUploadReturnArray['imageError']){
									//Fehler
if(DEBUG) 							echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: Fehler: $imageUploadReturnArray[imageError] <i>(" . basename(__FILE__) . ")</i></p>";	
									$errorImageUpload = $imageUploadReturnArray['imageError'];
									
								}else{
									//Erfolg
if(DEBUG) 							echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Das Bild wurde erfolgreich auf dem Server geladen <i>(" . basename(__FILE__) . ")</i></p>";										
									
									/*********** GGF. Altes Bild vom Server Löschen *************/
									
									// Sicherstellen, dass das alter Avatarbild NICHT der Dummy ist
									if($avatarPath != "css/images/avatar_dummy.png"){
										//Altes Bild vom Server löschen
										if(@unlink($avatarPath)){
											//Erfolgsfall
if(DEBUG) 									echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Das alte Bild wurde vom Server gelöscht unter $avatarPath <i>(" . basename(__FILE__) . ")</i></p>";													
										}else{
											//Fehlerfall
if(DEBUG) 									echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: Fehler beim der löschen des alten Avatarbildes unter $avatarPath  <i>(" . basename(__FILE__) . ")</i></p>";													
										}
									}
									
									
									// Neuen Bildpfad speichern
									$avatarPath = $imageUploadReturnArray['imagePath'];
									
									
									
									
									
								}
								
							}


							//Ende Fileupload
							/**********************************************/
							
							// Abschließende Formularprüfung TEIL 2:
							
							if(!$errorImageUpload){
if(DEBUG) 						echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Das Formular ist fehlerfrei, die Daten können in DB geschrieben werden<i>(" . basename(__FILE__) . ")</i></p>";									
								
									/*********************** DB ************************/
								$sql = "UPDATE users
										INNER JOIN accounts USING(usr_id)
										SET 
										usr_firstname 	= :ph_usr_firstname,
										usr_lastname 	= :ph_usr_lastname,
										usr_email		= :ph_usr_email,
										usr_birthdate 	= :ph_usr_birthdate,
										usr_street 		= :ph_usr_street,
										usr_housenumber = :ph_usr_housenumber,
										usr_zip 		= :ph_usr_zip,
										usr_city		= :ph_usr_city,
										usr_country 	= :ph_usr_country,
										acc_signature 	= :ph_acc_signature,
										acc_info 		= :ph_acc_info, 
										acc_avatarpath 		= :ph_acc_avatarpath
										";
										
								if($passwordChange){
if(DEBUG) 							echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Neues Password wird in DB geschrieben<i>(" . basename(__FILE__) . ")</i></p>";									
									$sql .= ", 
										acc_password = :ph_acc_password";
									
								}
								
								
										
								$sql .= " WHERE usr_id 	= :ph_usr_id";
								
								$params = array(
												"ph_usr_firstname" 	=> $firstname,
												"ph_usr_lastname" 	=> $lastname,
												"ph_usr_email" 		=> $email,
												"ph_usr_birthdate" 	=> $birthdate,
												"ph_usr_street" 	=> $street,
												"ph_usr_housenumber" => $housenumber,
												"ph_usr_zip" 		=> $zip,
												"ph_usr_city" 		=> $city,
												"ph_usr_country" 	=> $country,
												"ph_acc_signature" 	=> $signature,
												"ph_acc_info" 		=> $info,
												"ph_acc_avatarpath" => $avatarPath,
												"ph_usr_id" 		=> $_SESSION['usr_id']
												);
												
								if($passwordChange){

									$params['ph_acc_password'] = $passwordHash;
								}
								
								//2DB: SQL-Statement vorbereiten
								$statement = $pdo->prepare($sql);
								
								//3DB: SQL-Statement ausführen
								$statement->execute($params) OR DIE( "<p class='debug'>Line <b>" . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>"); 
								
								//4DB: Daten weiterverarbeiten
								//Bei Update Schreiberfolg prüfen
								$affectedRows = $statement->rowCount();
if(DEBUG) 						echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: affectedRows: $affectedRows <i>(" . basename(__FILE__) . ")</i></p>";											
								
								if(!$affectedRows){
									//Nichts geschrieben
if(DEBUG) 							echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Nichts geändert <i>(" . basename(__FILE__) . ")</i></p>";									
								} else {
									//Erfolgsfall
if(DEBUG) 							echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Es wurden $affectedRows Sätze geändert <i>(" . basename(__FILE__) . ")</i></p>";
									$dbMessage = "<p class='info'>Daden wurden gespeichert</p>";
																
								}
							
							}
						
							
						}
					}


/**********************************************************************************************/	
					/**************************************************************/
					/************ User und Accountdaten aus DB auslesen ***********/
					/**************************************************************/
					
					
					
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
					
					
					//Aus Tabelle "users"
					$firstname = $row['usr_firstname'];
					$lastname  = $row['usr_lastname'];
					$email 		 = $row['usr_email'];
					$birthdate = $row['usr_birthdate'];
					// $birthdate nur dann verarbeiten, wenn es einen gültigen Wert hat
					// (ansonsten wird strtotime() ein ungültiger Timestamp übergeben)
					if( $birthdate ) {
					// $birthdate für Formularvorbelegung aufsplitten
						$day = date( "d", strtotime($birthdate) );
						$month = date( "m", strtotime($birthdate) );
						$year = date( "Y", strtotime($birthdate) );
					}
					
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
					
/*******************************************************************************/
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
		<br>
		<hr>
		</header>
		<h1>Benutzerverwaltung - Profile</h1>
		
		<p>Account-Name: <b><?=$accountname?></b> | Account-Status:<b><?=$statelabel?></b> | Account-Role: <b><?=$rolelabel?></b></p>
		<h3 class="info">Hallo <?php echo $_SESSION['usr_firstname']. " ". $_SESSION['usr_lastname']?></h3>
		<?=$dbMessage?>
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
					<img class="avatar" src="<?php echo $avatarPath ?>" alt="Avatar von <?php echo $accountname ?>" title="Avatar von <?php echo $accountname ?>"><br>
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