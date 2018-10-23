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
					/************* Variablen initializieren ****************/
					/*******************************************************/
					
					$urlMessage = NULL;
					$loginMessage = NULL;




/**********************************************************************************************/
					/*******************************************************/
					/************* URL-PARAMETER-VERARBEITUNG **************/
					/*******************************************************/
					
					// 1 URL: Prüfen, ob URL-Parameter übergeben wurde
					if(isset($_GET['action'])){
if(DEBUG)				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: URL-Paranmeter 'action wurde übergeben'<i>(" . basename(__FILE__) . ")</i></p>";		
						
						//2URL: Werte auslesen, entschärfen
						$action = cleanString($_GET['action']);
if(DEBUG)				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: action: $action'<i>(" . basename(__FILE__) . ")</i></p>";		

						//3URL: Verzweigen
						if($action == "regConfirmed"){
if(DEBUG)					echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Registrierung bestätigt<i>(" . basename(__FILE__) . ")</i></p>";		
							
							//4URL: Daten weiterverarbeiten
							$urlMessage = "<h3 class='success'>Ihre Registrierung ist nun abgeschlossen.<br>
											Sie können sich ab sofort mit Ihren Zugangsdaten einloggen.</h3>";
						}
						
					}
	
/**********************************************************************************************/	
					
					/*******************************************************/
					/************* FORMULARVERARBEITUNG LOGIN **************/
					/*******************************************************/
					
					//1 FORM: Prüfen, ob Formular abgeschickt wurde
					if(isset($_POST['formsentLogin'])){
if(DEBUG)				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Formular wurde abgeschickt<i>(" . basename(__FILE__) . ")</i></p>";
						
					//2 FORM: Auslesen, entschärfen, Debug ausgabe
						$accountname = cleanString($_POST['accountname']);
						$password = cleanString($_POST['password']);
if(DEBUG)				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: accountname: $accountname'<i>(" . basename(__FILE__) . ")</i></p>";								
if(DEBUG)				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: password: $password'<i>(" . basename(__FILE__) . ")</i></p>";								
						
						// 3 FORM: Werte Validierung
						$errorAccountname = checkInputString($accountname, 4, 20);
						$errorPasswort = checkInputString($password, 4);
						
						// Abschließende Formularprüfung
						if($errorAccountname || $errorPasswort){
							//Fehler
if(DEBUG)					echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: Logindaten sind ungültig<i>(" . basename(__FILE__) . ")</i></p>";		
							$loginMessage = "<p class='error'>Logindaten sind ungültig</p>";
						} else {
							//Erfolg
if(DEBUG) 					echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Formular ist korrekt ausgefüllt. Daten werden nun verarbeitet... <i>(" . basename(__FILE__) . ")</i></p>";		
							
							// 4FORM : Daten weiterverarbeiten
							
							/******************* DB *********************/
							//1. Verbindung herstellen
							
							$pdo = dbConnect();
							
							/******************DATENSATZ ZUM LOGINNAMEN AUSLESEN *******************/
							
							//2. SQL-Statement vorbereiten
							$statement = $pdo->prepare("SELECT acc_name, acc_password, usr_id, usr_firstname, usr_lastname, sta_id
														FROM accounts INNER JOIN users USING(usr_id)
														WHERE acc_name = :ph_accountname
														");
														
							//3. SQL-Statement ausführen
							$statement->execute( array(
												"ph_accountname" => $accountname
												)) OR DIE( "<p class='debug'>Line <b>" . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>"); 
							
							//4. Datenweiterverarbeiten
							$row = $statement->fetch();
							
							/********** ACCOUNTNAME PRÜFEN **********/

							// Prüfen, ob ein Datensatz geliefert wurde
							// Wenn Datensatz geliefert wurde, muss der Accountname stimmen
							if( !$row ) {
							// Fehlerfall
if(DEBUG) 						echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: FEHLER: Accountname $accountname existiert nicht in der DB! <i>(" . basename(__FILE__) . ")</i></p>";
								$loginMessage = "<p class='error'>Logindaten sind ungültig!</p>";

							} else {
							// Erfolgsfall
if(DEBUG) 						echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Accountname $accountname wurde in der DB gefunden. <i>(" . basename(__FILE__) . ")</i></p>";
														
							/*************** passwort prüfen **************/
							
								if(!password_verify($password, $row['acc_password'])){
									//Fehler
if(DEBUG) 							echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: FEHLER: Passwort stimmn nicht! <i>(" . basename(__FILE__) . ")</i></p>";
									$loginMessage = "<p class='error'>Logindaten sind ungültig!</p>";
								}else{
									//Erfolg
if(DEBUG) 							echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Passwort stimmt mit Passwort aus DB überein <i>(" . basename(__FILE__) . ")</i></p>";	
									
									/************** Accountstatus Prüfen *************/
									
									$acc_state = $row['sta_id'];
if(DEBUG)							echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: acc_state: $acc_state<i>(" . basename(__FILE__) . ")</i></p>";												
									
									// Status 3 ist ein unregistrierten Account
									if($acc_state == 3){
if(DEBUG) 								echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: FEHLER: Der Account wurde nich nicht freigeschaltet <i>(" . basename(__FILE__) . ")</i></p>";										
										$loginMessage = "<p class='error'>Sie müssen zuerst den Registrierungvorgang abschließen.</p>";
										
									// Status 2 ist gesperrter Account	
									} elseif($acc_state == 2){
if(DEBUG) 								echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: FEHLER: Der Account ist gesperrt <i>(" . basename(__FILE__) . ")</i></p>";										
										$loginMessage = "<p class='error'>Dieser Account ist zur Zeit gesperrt. <br>
														Bitte überprüfen Sie Ihre Emails.</p>";
									//Nur Status 1 ist ein offener Account
									} elseif($acc_state == 1){
if(DEBUG) 								echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Der Account ist gültig <i>(" . basename(__FILE__) . ")</i></p>";
										
										
										/***************LOGIN VERARBEITEN**************/
										
					/***************Session starten und Daten in Session schreiben********/
					
										session_name("benutzerverwaltung");
										session_start();
										
										$_SESSION['usr_id'] = $row['usr_id'];
										$_SESSION['usr_firstname'] = $row['usr_firstname'];
										$_SESSION['usr_lastname'] = $row['usr_lastname'];
										
if(DEBUG)								echo "<pre class='debug'>";
if(DEBUG)								print_r($_SESSION);
if(DEBUG)								echo "</pre>";
										
										
										/*********** Login Timestamp in DB schreiben ***********/
										/****************DB Operation ***************/
										
										//2. SQL-Statement Vorbereiten
										$statement = $pdo->prepare("UPDATE accounts
																	SET 
																	acc_lastlogin = NOW()
																	WHERE usr_id = :ph_user_id
																	");
										
										//3- SQLStatement ausführen
										$statement->execute(array(
																"ph_user_id" => $row['usr_id']
															)) OR DIE( "<p class='debug'>Line <b>" . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>"); 
	
										//4.Daten Weiterverarbeiten
										//Bei UPDATE: Schreiberfolg prüfen
										$updateSuccess = $statement->rowCount();
if(DEBUG) 								echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: updateSuccess: $updateSuccess <i>(" . basename(__FILE__) . ")</i></p>";										
										
										if(!$updateSuccess){
											//Fehler
if(DEBUG) 									echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Fehler beim Scheriben des Login Timestamps <i>(" . basename(__FILE__) . ")</i></p>";											
										}else{
											//Erfolg
if(DEBUG) 									echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Timestamp wurde erfolgreich in DB geschrieben <i>(" . basename(__FILE__) . ")</i></p>";											
										}
										
										// Unabhängig davon, ob das Schreiben des Login-Timestamps erfolgreich war,
										// geht es hier weiter
										
										/************ Weiterleitung auf interne Seite **************/
										header("Location: profile.php");
										exit;
	
									} // Accountstatusprüfen Ende
								
								} //Password prüfen Ende
							
							} //Accountname Prüfen Ende
						
						} //Formularprüfung Ende

					} //Formularverarbeitung Ende

/**********************************************************************************************/	
?>
<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>Benutzerverwaltung - Login</title>
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<link rel="stylesheet" type="text/css" href="css/debug.css">
	</head>

	<body>
		
		<header class="fright">
			<form action="<?=$_SERVER['SCRIPT_NAME']?>" method="POST">
				<input type="hidden" name="formsentLogin">
					<fieldset>
						<legend>Login</legend>
						<?=$loginMessage ?>
						<input class="short" type="text" name="accountname" placeholder="Accountname">
						<input class="short" type="password" name="password" placeholder="Passwort">
						<input class="short" type="submit" value="Anmelden">
						
					</fieldset>
			</form>
			
			<p class="fright"><a href="">Passwort vergessen?</a></p><br>
			<p class="fright"><a href="registration.php">Sie haben keinen Account? Registrieren Sie sich!</a></p>
		</header>
		<div class="clearer">
		</div>
	
		<h1>Benutzerverwaltung - Login</h1>
		<?=$urlMessage ?>
		
		<p>
			Hallo Besucher, bitte loggen Sie sich über obiges Formular ein, um die Inhalte für registrierte 
			Benutzer sehen zu können.<br>
			<br>
			Auf der Folgeseite können Sie dann Ihre persönlichen Daten sowie Ihre 
			Accountdaten verwalten, ein Avatarbild hochladen oder Ihr Passwort ändern.
		</p>

		<p>
			Sollten Sie sich noch nicht auf unserer Seite registriert haben, können Sie das über den 
			Link unter dem Anmeldeformular nachholen. Oder klicken Sie einfach <a href="registration.php">hier</a>.
		</p>


</body>

</html>