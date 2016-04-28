<?php

//my sql -u root -p
//create database event_garden
//use event_garden
	$db_connection = new mysqli("localhost", "root", "0000", "event_garden");
            if ($db_connection->connect_error) {
                die($db_connection->connect_error);
            }
    // sql to create table
	$events_table = "CREATE TABLE IF NOT EXISTS Events (
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
			Arts BOOLEAN DEFAULT false,
			Animals BOOLEAN DEFAULT false,
			Social BOOLEAN DEFAULT false
		)";

	$equipment_table = "CREATE TABLE IF NOT EXISTS Equipment (
                id INTEGER AUTO_INCREMENT PRIMARY KEY,
                equipment_name VARCHAR(30) NOT NULL,
                equipment_quantity INTEGER,
                equipment_remaining INTEGER DEFAULT 0
                )";

	$event_equipment = "CREATE TABLE IF NOT EXISTS Event_Equipment (
                event_id INTEGER NOT NULL,
                equipment_id INTEGER NOT NULL,
                PRIMARY KEY (event_id, equipment_id)
               )";
	$profiles = "CREATE TABLE IF NOT EXISTS Profiles (
                id INTEGER PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(20),
                description VARCHAR(50),
                reputation INTEGER DEFAULT 0
                )";
	$profile_event = "CREATE TABLE IF NOT EXISTS Profile_Event ( 
                profile_id INTEGER NOT NULL,
                event_id INTEGER NOT NULL,
                PRIMARY KEY (event_id, profile_id)
                )";


//equipment in format elem1-quant/elem2-quant/elem3-quant
//time in military time
	if ($db_connection->query($events_table) && $db_connection->query($equipment_table) &&
	 $db_connection->query($event_equipment) && $db_connection->query($profiles) &&
		 $db_connection->query($profile_event)) {
    	echo "Event_Garden created successfully";
	} else {
    	echo "Error creating table: ". $db_connection->error;
	}

	$query = "insert into events (event_name, event_date, event_time, description,location,recreation) values(
		'Harvest Festival','2016-04-30', '16:00', 'parks and rec', '100 Hersheypark Dr, Hershey, PA 17033',TRUE)";
			
	/* Executing query */
	$result = $db_connection->query($query);
	if (!$result) {
		die("Insertion failed: " . $db_connection->error);
	}
	
	$db_connection->close();



?>