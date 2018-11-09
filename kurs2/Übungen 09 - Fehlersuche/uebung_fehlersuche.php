<?php

/*****************************************************************************/
			/**************************************/
			/********** INCLUDES ******************/
			/**************************************/
			
			require_once("include/config.inc.php");require_once("include/db.inc.php");
			require_once("include/form.inc.php");require_once("include/dateTime.inc.php");
			
			/**************************************/
			/********** DB-Verbindung *************/
			/**************************************/
			
			$pdo = dbConnect("fehlersuche");
			
/*****************************************************************************/
			/**************************************/
			/****** FORMULARVERARBEITUNG **********/
			/**************************************/
			
			if(isset($_POST['formsend'])){
if(DEBUG)		echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Form wird gesendet... <i>(" . basename(__FILE__) . ")</i></p>";
				$name = cleanString($_POST['name']);
				$phone = cleanString($_POST['phone']);
				$day = $_POST['day'];
				$month = $_POST['month'];
				$year = $_POST['year'];
				$birthdate ="$year-$month-$day";		
				
			/**************************************/
			/********** DB-OPERATION **************/
			/**************************************/
				$statement=$pdo->prepare("INSERT INTO users (name,phone,birthdate) VALUES (?,?,?)");
				$statement->execute(array($name,$phone,$birthdate))OR DIE(print_r($statement->errorInfo(),true));
				if($pdo->lastInsertId()) {
					echo"<p class='success'>Datensatz wurde erfolgreich mit der ID ".$pdo->lastInsertId()." angelegt.</p>";
				}else{
					echo"<p class='error'>Fehler beim Anlegen des Datensatzes!</p>";
				}
					
				
				
					
					
					
					
			}
?>

<!doctype html>

<html>

	<head>
		<title>Fehlersuche</title>
		<meta charset="utf-8"><title>Fehlersuche</title>
		<style>
			body {padding:50px;font-family:monospace;}
			.info {color:gray;background-color:lightblue;padding:1px 10px;}
			.success {color:green;}
			.error {color:red;}
			table {width:550px;border:1px solid lightgray;} th,td {width:33%;text-align:center;border:1px solid lightgray;padding:5px;}
			input {width:200px;margin:10px 0;padding:5px;}
			select {margin:10px 0;}
			option {width:34px;} hr {border:1px solid white;}
		</style>
		<link rel="stylesheet" href="css/debug.css">
	</head>
	
	
	<body>
		<h1>Fehlersuche</h1>
		<?php 
			echo "<h3>Vorhandene Kontakte in der Datenbank:</h3>";
			$statement=$pdo -> prepare("SELECT * FROM users");
			$statement->execute() OR DIE( print_r($statement->errorInfo(), true) );
			echo "
			<table>
				<tr>
					<th>Name</th>
					<th>Telefon</th>
					<th>Geburtsdatum</th>
				</tr>";
				while($row=$statement->fetch()) {	
					$birthdate = isoToEuDateTime($row['birthdate']);
					echo "<tr>
							<td>".$row['name']."</td>
							<td>".$row['phone']."</td>
							<td>".$birthdate['date']."</td>
						</tr>"; 
				
				}
			echo "</table>"; 
		?>
		<br>
			
		<h3>Neuen Kontakt anlegen</h3>
		<form action="" method="post">
		
			<input 	type="hidden" name="formsend"><input type= "text" name= "name" placeholder= "Name" ><br>
			<input type="text"name="phone" placeholder="Telefon"><br>
			<label>Geburtsdatum:</label><br>
			<select name="day">
				
				<?php 
					for($i=1;$i<=31;$i++) echo "<option value='$i'>$i</option>";
				?>
				
			</select>
			<select name="month">
				
				<?php 
					for($i=1;$i<=12;$i++) echo "<option value='$i'>$i</option>"
				?>
				
			</select>
			<select name="year">
				<?php 
					for($i=date("Y");$i>1900;$i--) echo "<option value='$i'>$i</option>"
				?>
			</select><br>
			
			<input type="submit" value="Send">	
		</form>
	</body>
</html>