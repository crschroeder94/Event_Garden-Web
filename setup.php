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
			event_date VARCHAR(30),
			event_time VARCHAR(20),
			description VARCHAR(50),
			location VARCHAR(50)
			
		)";

	if ($db_connection->query($sql)) {
    	echo "Event_Garden created successfully";
	} else {
    	echo "Error creating table: ". $db_connection->error;
	}

	$query = "insert into events (event_name, event_date, event_time, description,location) values(
		'Harvest Festival','02/31/2016', '16:00', 'parks and rec', 'pawnee IN')";
			
	/* Executing query */
	$result = $db_connection->query($query);
	if (!$result) {
		die("Insertion failed: " . $db_connection->error);
	}
	
	$db_connection->close();



?>