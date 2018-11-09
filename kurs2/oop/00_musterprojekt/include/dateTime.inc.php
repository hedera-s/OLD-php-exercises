<?php
/**************************************************************************************/


				/**
				*
				* 	Wandelt ein ISO Datums-/Uhrzeitformat in ein europäisches Datums-/Uhrzeitformat um
				*	und separiert Datum von Uhrzeit
				*
				* 	@param String Das ISO Datum/Uhrzeit
				*
				* 	@return Array Das deutsche Datum plus die Uhrzeit
				*
				*/
				function isoToEuDateTime($dateTime) {
if(DEBUG_F)		echo "<p class='debug'><b>Line " . __LINE__ . ":</b> Aufruf " . __FUNCTION__ . "($dateTime) <i>(" . basename(__FILE__) . ")</i></p>";					
					
					// mögliche Übernahmewerte
					// 2018-05-17 14:17:48
					// 2018-05-17
					
					// gewünschte Ausgabewerte
					// 17.05.2018	// 14:17
					// 17.05.2018
					
					// Datum ausschneiden und umformatieren
					$year = substr($dateTime, 0, 4);
					$month = substr($dateTime, 5, 2);
					$day = substr($dateTime, 8, 2);
					
					$euDate = "$day.$month.$year";
					
					// Prüfen, ob $dateTime eine Uhrzeit enthält
					if( strlen($dateTime) > 10 ) {
						// Uhrzeit ausschneiden (ohne Sekunden)
						$time = substr($dateTime, 11, 5);
					} else {
						$time = NULL;
					}
					
					return array("date"=>$euDate, "time"=>$time);
					
				}


/**************************************************************************************/


				/**
				*
				* 	Wandelt ein EU-Datumsformat in ein ISO-Datumsformat um
				*
				* 	@param String 	Das EU-Datum
				*
				* 	@return String Das ISO-Datum
				*
				*/
				function euToIsoDate($date) {
if(DEBUG_F)		echo "<p class='debug'>Line " . __LINE__ . ": Aufruf " . __FUNCTION__ . "($date) <i>(" . basename(__FILE__) . ")</i></p>";					
					
					// mögliche Übernahmewerte
					// 17.05.2018
					
					// gewünschte Ausgabewerte
					// 2018-05-17
					
					$isoDate = date("Y-m-d", strtotime($date));
					
					return $isoDate;
					
				}









/**************************************************************************************/
?>