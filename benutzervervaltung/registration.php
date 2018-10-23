<?php
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
					/*******************************************************/
					/************** VARIABLEN INITIALIZIEREN ***************/
					/*******************************************************/
					$firstname 			= NULL;
					$lastname 			= NULL;
					$email 				= NULL;
					$accountname 		= NULL;

					$errorFirstname	 	= NULL;
					$errorLastname 		= NULL;
					$errorEmail 		= NULL;
					$errorAccountname	= NULL;
					$errorPassword 		= NULL;
					$errorPasswordCheck = NULL;
					$dbMessage			= NULL; 
					$mailMessage		= NULL;
					
					$showForm 			= true;
					
					
					

/**********************************************************************************************/	
					/***********************************/
					/******** FORMVERAVBEITUNG *********/
					/***********************************/
					
					//1. Prüfen, ob Formular abgeschickt wurde
					
					if(isset($_POST['formsentRegistration'])){
if(DEBUG)				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Formular wurde abgeschickt<i>(" . basename(__FILE__) . ")</i></p>";	
					//2. Werte auslesen, entscärfen
						$firstname = cleanString($_POST['firstname']);
						$lastname = cleanString($_POST['lastname']);
						$email = cleanString($_POST['email']);
						$accountname = cleanString($_POST['accountname']);
						$password = cleanString($_POST['password']);
						$passwordCheck = cleanString($_POST['passwordCheck']);
if(DEBUG)				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: firstname: $firstname<i>(" . basename(__FILE__) . ")</i></p>";							
if(DEBUG)				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: lastname: $lastname<i>(" . basename(__FILE__) . ")</i></p>";							
if(DEBUG)				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: email: $email<i>(" . basename(__FILE__) . ")</i></p>";							
if(DEBUG)				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: accountname: $accountname<i>(" . basename(__FILE__) . ")</i></p>";							
if(DEBUG)				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: password: $password<i>(" . basename(__FILE__) . ")</i></p>";							
if(DEBUG)				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: passwordCheck: $passwordCheck<i>(" . basename(__FILE__) . ")</i></p>";	

					//3. Werte validieren
					
					$errorFirstname = checkInputString($firstname);
					$errorLastname = checkInputString($lastname);
					$errorEmail = checkEmail($email);
					$errorAccountname = checkInputString($accountname, 6, 20);
					$errorPassword = checkInputString($password, 4);
					
					/********** PASSWORT PRÜFEN *********/
					if(!$errorPassword){
if(DEBUG)			echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Der Passwort entspricht der Anforderungen <i>(" . basename(__FILE__) . ")</i></p>";		

						if($password != $passwordCheck){
if(DEBUG)					echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: Die Passworte stimmen nicht <i>(" . basename(__FILE__) . ")</i></p>";		
							$errorPasswordCheck = "Die Passworde stimmen nicht";
						} else {
if(DEBUG)					echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Die Pasworde stimmen übereinander <i>(" . basename(__FILE__) . ")</i></p>";		
							
							//Passwort verschlüsseln
							
							$passwordHash = password_hash($password, PASSWORD_DEFAULT);
if(DEBUG)					echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: \$passwordHash: $passwordHash <i>(" . basename(__FILE__) . ")</i></p>";
						}
					}
					
					/**************************************/

					
					/*******ABSCHLIESENDE FORMULARPRÜFUNG******/
					if($errorFirstname||$errorLastname||$errorEmail||$errorAccountname||$errorPassword||$errorPasswordCheck){
						//Fehlerfall
if(DEBUG)				echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: Das Formular enthält noch Fehler <i>(" . basename(__FILE__) . ")</i></p>";		
						
					} else {
						//Erfolgsfall
if(DEBUG)				echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Das Formular ist Fehlerfrei und wird weiterverarbeitet <i>(" . basename(__FILE__) . ")</i></p>";
						
						//4. FORM Daten weiterverarbeitrn
						
						
						/************************** DB OPERATIONEN ************************/
						// 1DB. DB-Verbindung herstellen
						$pdo = dbConnect();
						
						
						/************* Prüfen, ob Email bereits registriert wurde ***********/
if(DEBUG) 				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Prüfen, ob Email-Adresse bereits in der DB registriert ist... <i>(" . basename(__FILE__) . ")</i></p>";
						// 2DB. SQL-Statement vorbereiten
						$statement = $pdo->prepare("SELECT COUNT(usr_email) FROM users
													WHERE usr_email = :ph_email");
													
						// 3DB. SQL-Statement ausführen und Platzhalter füllen
						$statement->execute( array(
													"ph_email" => $email
													)) OR DIE( "<p class='debug'>Line <b>" . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>" );
													
						// 4DB. Daten weiterverarbeiten
						
						$emailExists = $statement->fetchColumn();
if(DEBUG)				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: \$emailExists: $emailExists <i>(" . basename(__FILE__) . ")</i></p>";

						if($emailExists){
							// Fehlerfall
if(DEBUG)					echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: Email isr bereits registriert <i>(" . basename(__FILE__) . ")</i></p>";
							$errorEmail = "Diese Email-Adresse ist bereits registriert";
														
						}else{
							// Erfolgsfall 
if(DEBUG)					echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Email-Adresse ist noch nicht registriert <i>(" . basename(__FILE__) . ")</i></p>";
						
						/************* Prüfen, ob Accountname  bereits registriert wurde ***********/
if(DEBUG)					echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Accountname in DB... <i>(" . basename(__FILE__) . ")</i></p>";
							
							// 2DB. SQL-Statement vorbereiten
							$statement = $pdo->prepare("SELECT COUNT(acc_name) FROM accounts
														WHERE acc_name = :ph_accountname");
							// 3DB. SQL-Statement ausführen und Platzhalter füllen
							$statement->execute( array(
													"ph_accountname" => $accountname
													)) OR DIE( "<p class='debug'>Line <b>" . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>" );
						
						// 4DB. Daten weiterverarbeiten
						
							$accountnameExists = $statement->fetchColumn();


							if($accountnameExists){
							// Fehlerfall
if(DEBUG)						echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: Accountname isr bereits registriert <i>(" . basename(__FILE__) . ")</i></p>";
								$errorAccountname = "Diese Accountname ist bereits registriert";
														
							}else{
							// Erfolgsfall 
if(DEBUG)						echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Accountname ist noch nicht registriert <i>(" . basename(__FILE__) . ")</i></p>";
								
								/************* REGISTIERUNGDATEN IN DIE DB SCHREIBEN ***********/
if(DEBUG)						echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Registrierungsdaten werden in DB geschrieben <i>(" . basename(__FILE__) . ")</i></p>";									
																
						
								/************* 1. USER IN DB SPEICHERN************/
								
								// 2DB. SQL-Statement vorbereiten
								$statement = $pdo->prepare("INSERT INTO users
															(usr_firstname, usr_lastname, usr_email)
															VALUES
															(:ph_firstname, :ph_lastname, :ph_email)
															");
								
								// 3DB. SQL-Statement ausführen und Platzhalter füllen
								$statement->execute( array(
													"ph_firstname" => $firstname,
													"ph_lastname" => $lastname,
													"ph_email" => $email
													)) OR DIE( "<p class='debug'>Line <b>" . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>" );
						
								// 4DB. Daten weiterverarbeiten
								$newUserId = $pdo->lastInsertId();
								
if(DEBUG)						echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: \$newUserId: $newUserId <i>(" . basename(__FILE__) . ")</i></p>";
								
								if(!$newUserId){
									//Fehlerfall
if(DEBUG)							echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: Fehler beim Speichern des neuen Users <i>(" . basename(__FILE__) . ")</i></p>";
									$dbMessage = "<h3 class='error'>Es ist ein Fehler aufgetreten, versuchen Sie es nochmal</h3>";
									
									
								}else{
									//Erfolgsfall
if(DEBUG)							echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: User wurde erfolgreich mit der ID $newUserId erfolgreich geschpeichert. <i>(" . basename(__FILE__) . ")</i></p>";									
									
									/******** 2. ACCOUNT IN DB SPEICHERN *************/
if(DEBUG)							echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Accountdaten werden in DB geschrieben <i>(" . basename(__FILE__) . ")</i></p>";									
																									
									
									// Hashwert für abschließende registrierung
									$regHash = sha1($accountname);
if(DEBUG)							echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: regHash: $regHash <i>(" . basename(__FILE__) . ")</i></p>";									
																									
									
									// 2DB. SQL-Statement vorbereiten
									$statement = $pdo->prepare("INSERT INTO accounts
															(acc_name, acc_password, acc_reghash, usr_id)
															VALUES
															(:ph_accountname, :ph_password, :ph_regHash, :ph_newUserId)
															");
									// 3DB. SQL-Statement ausführen und Platzhalter füllen
									$statement->execute( array(
													"ph_accountname" => $accountname,
													"ph_password" => $passwordHash,
													"ph_regHash" => $regHash,
													"ph_newUserId" => $newUserId
													)) OR DIE( "<p class='debug'>Line <b>" . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>" );
									
									
									// 4DB. Daten weiterverarbeiten
									$newAccountId = $pdo->lastInsertId();
								
if(DEBUG)							echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: \$newAccountId: $newAccountId <i>(" . basename(__FILE__) . ")</i></p>";
								
									if(!$newAccountId){
										//Fehlerfall
if(DEBUG)								echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: Fehler beim Speichern des neuen Accounts <i>(" . basename(__FILE__) . ")</i></p>";
										$dbMessage = "<h3 class='error'>Es ist ein Fehler aufgetreten, versuchen Sie es nochmal</h3>";
										
										/********** DB BEREINIGEN **********/
										// verwaisten User löschen

										// Schritt 2 DB: SQL-Statement vorbereiten
										$statement = $pdo->prepare("DELETE FROM users
										WHERE usr_id = :ph_usr_id");

										// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
										$statement->execute( array(
										"ph_usr_id" => $newUserId
										) ) OR DIE( $statement->errorInfo()[2] );

										// Schritt 4 DB: Daten weiterverarbeiten / Schreiberfolg prüfen
										if( $statement->rowCount() ) {
										// Erfolgsfall
if(DEBUG) 									echo "<p class='debug'>Userdatensatz mit der ID $newUserId wurde wieder gelöscht.</p>"; 
										} else {
												// Fehlerfall
if(DEBUG) 									echo "<p class='debug'>FEHLER beim Löschen des Userdatensatzes mit der ID $newUserId!</p>"; 
											
											// TODO: Email an DB-versenden, damit der Satz per Hand gelöscht soll 
												
											}
										
									
										}else{
											//Erfolgsfall
if(DEBUG)								echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Account wurde erfolgreich mit der ID $newAccountId erfolgreich geschpeichert. <i>(" . basename(__FILE__) . ")</i></p>";


								
								
								
								
								
								/******** BESTÄTIGUNGS EMAIL GENERIEREN *********/
								
								// PHP-Funktion zum Erzeugen und Versenden einer Email:
								// mail(String Empfängeradresse, String Betreff, String Inhalt, String Header)
								
								$link = "http://localhost/benutzervervaltung/confirmRegistration.php?action=conReg&hash=$regHash";
								
								$to = $email;
								
								$subject = "Ihre Registrierung auf www.meineseite.de";
								
								$header = "FROM: www.meineseite.de<donotreply@meineseite.de>\r\n";
								//optional: Adresse für Antworten-Button
								$header .= "Reply-To: cutomerservice@meineseite.de\r\n";
								//optional: Email in HTML-Format
								$header .= "MIME-Version: 1.0\r\n";
								$header .= "Content-Type: text/html; charset=utf-8\r\n";
								$header .= "X-Mailer: PHP " . phpversion();
								
								$content = "<h4>Hallo $firstname $lastname,</h4>
											<p>Sie haben sich am " . date("d.m.Y") . " um " . date("H:i") . " Uhr 
											auf unserer Webseite registriert.</p>
											<p>Um Ihren neuen Account freizuschalten, rufen Sie bitte innerhalb der nächsten 7 Tage folgende URL auf:</p>
											<p><a href='$link'>$link</a></p>
											<br>
											<p>Zur Erinnerung: Ihr Login-Name lautet <b>$accountname</b>.</p>
											<p>Sie können sich erst nach Abschluss dieses Registrierungsvorganges auf unserer Seite einloggen.</p>
											<p>Wenn Sie die obenstehende URL nicht innerhalb von 7 Tagen aufrufen, 
											werden Ihre Registrierungsdaten automatisch gelöscht. Sie müssen sich dann ggf. neu registrieren.</p>
											<br>
											<p>Viele Grüße<br>
											Ihr www.meineseite.de-Team</p>";
											
if(DEBUG) 									echo "<br>";
if(DEBUG) 									echo "<hr>";
if(DEBUG) 									echo "<p>Header: $header</p>";
if(DEBUG) 									echo "<p>To: $to</p>";
if(DEBUG)									echo "<p>Subject: $subject</p>";
if(DEBUG) 									echo "$content";
if(DEBUG) 									echo "<hr>";
if(DEBUG) 									echo "<br>";
								
								
								/******** BESTÄTIGUNGS EMAIL VERSENDEN *********/
								
								/* 
								Damit die folgende Fehlerabfrage funktioniert, muss in XAMPP
								vorher der Mercury Email-Server konfiguriert und gestartet werden.
								*/
								// Ein @ vor einem Funktionsaufruf unterdrückt die von dieser 
								// Funktion geworfene Fehlermeldung im Frontend
								
								if(!@mail($to, $subject, $content, $header)){
									//Fehlerfall
if(DEBUG) 							echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: Fehler beim Versenden Email <i>(" . basename(__FILE__) . ")</i></p>";; 									
									$mailMessage = "<h3 class='error'>Es ist ein Fehler aufgetreten! Bitte versuchen Sie es später noch einmal.</h3>";
									
									// TODO:
									/*
									Entweder User- und Accountdatensatz wieder löschen, 
									oder Email automatisiert später noch einmal versenden, 
									oder User bitten, sich an den Kundensupport zu wenden
									*/
									
									
								} else {
									//Erfolgsfall
if(DEBUG) 							echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Email wurde versendet an $email <i>(" . basename(__FILE__) . ")</i></p>";
									$mailMessage = "<h3 class='success'>Vielen Dank,<br>
													Sie erhalten in Kürze eine Email mit einem Link,
													über den Sie den Registrierungsvorgang innerhalb der nächsten 7 Tage abschließen können.<br>
													<br>
													Erst nach Abschluss des Registrierungsvorgangs können Sie sich mit Ihrem Account einloggen.</h3>";
									
									//Formularfelder leeren
									$firstname 			= NULL;
									$lastname 			= NULL;
									$email 				= NULL;
									$accountname 		= NULL;
									
									//Flag zum Ausblenden des Formulars setzen
									$showForm 			= false;
								
													
													
								} //bestätigungs email
											
								
							} // account in db
									
							
						} // user in db speichern
						
					} // accountname prüfen
					
					
				}	// email prüfen
				
				
									} 
									
									
									
								}


/**********************************************************************************************/	
?>
<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>Benutzerverwaltung - Registration</title>
		
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<link rel="stylesheet" type="text/css" href="css/debug.css">
	</head>

	<body>
	<br>
		<header class="loginHeader">
			<p><a href="index.php"><< Zum Login</a></p>
		</header>
		
		<br>
		<hr>
		
		<h1>Benutzerverwaltung - Registration</h1>
		
		<?=$dbMessage ?>
		<?=$mailMessage ?>
		
		<?php if($showForm): ?>
		
		<form action="" method="POST">
			<input type="hidden" name="formsentRegistration">
			<fieldset>
				<legend>Userdaten</legend>
				<span class="error"><?= $errorFirstname ?></span><br>
				<input type="text" name="firstname" placeholder="Vorname" value="<?=$firstname?>"><span class="marker">*</span><br>
				<span class="error"><?= $errorLastname ?></span><br>
				<input type="text" name="lastname" placeholder="Nachname"  value="<?=$lastname?>"><span class="marker">*</span><br>
				<span class="error"><?= $errorEmail ?></span><br>
				<input type="text" name="email" placeholder="Mail-Adresse"  value="<?=$email?>"><span class="marker">*</span>
			</fieldset>
			<fieldset>
				<legend>Accountdaten</legend>
				<span class="error"><?= $errorAccountname ?></span><br>
				<input type="text" name="accountname" placeholder="Bitte Accountnamen wählen"  value="<?=$accountname?>"><span class="marker">*</span><br>
				<span class="error"><?= $errorPassword ?></span><br>
				<input type="password" name="password" placeholder="Bitte Passwort wählen"><span class="marker">*</span><br>
				<span class="error"><?= $errorPasswordCheck ?></span><br>
				<input type="password" name="passwordCheck" placeholder="Bitte Passwort wiederholen"><span class="marker">*</span>
			</fieldset>
			
			<input type="submit" value="Jetzt Registrieren">
		</form>
		<?php endif ?>


</body>

</html>