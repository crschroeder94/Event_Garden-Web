<?php

//my sql -u root -p
//create database event_garden
//use event_garden
	$db_connection = new mysqli("localhost", "root", "0000", "event_garden");
            if ($db_connection->connect_error) {
                die($db_connection->connect_error);
            }
    // sql to create table
	$sql = "CREATE TABLE Events (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
			event_name VARCHAR(30) NOT NULL,
			event_date DATE,
			event_time VARCHAR(20),
			description VARCHAR(50),
			location VARCHAR(50),
			attending BOOLEAN DEFAULT false,
			equipment VARCHAR(250) DEFAULT '-/-/-', 
			Environmental BOOLEAN DEFAULT false,
			Recreation BOOLEAN DEFAULT false,
			Arts BOOLEAN DEFAULT false
		)";
//equipment in format elem1-quant/elem2-quant/elem3-quant
//time in military time
	if ($db_connection->query($sql)) {
    	echo "Event_Garden created successfully";
	} else {
    	echo "Error creating table: ". $db_connection->error;
	}

	$query = "insert into events (event_name, event_date, event_time, description,location,recreation) values(
		'Harvest Festival','2016-04-04', '16:00', 'parks and rec', 'pawnee IN',TRUE)";
			
	/* Executing query */
	$result = $db_connection->query($query);
	if (!$result) {
		die("Insertion failed: " . $db_connection->error);
	}
	
	$db_connection->close();



?>