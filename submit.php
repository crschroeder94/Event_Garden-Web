<!DOCTYPE html>
<html>
  <head>
    <title>Event Garden</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="topbar.css">
    <style>
      html, body {
        height: 100%;
        margin: auto;
      }
    </style>
    </head>
    <body>


<?php
    require_once("support.php");
	$errors = "";


    
	if (isset($_POST["submitInfo"])) {
        $name = trim($_POST["event_name"]);
        $date = trim($_POST["date"]);
        $hours = trim($_POST["hours"]);
        $minutes = trim($_POST["minutes"]);
        $ampm = $_POST["amorpm"];
        $description= trim($_POST["description"]);
        $address = trim($_POST["address"]);
        $category = $_POST["category"];


        $am_or_pm = "";
        switch($ampm){
        case 'AM':
          $am_or_pm = "AM";
        break;
        case'PM':
          $am_or_pm = "PM";
        break;
        }



        addEvent($name,$date,$hours.':'.$minutes.'/'.$am_or_pm,$description,$address,$category);
        header("Location: map_php.php"); /* Redirect browser */
        exit();
		    
	}
    
	$scriptName = $_SERVER["PHP_SELF"];
    $page = <<<EOBODY
    <form action="$scriptName" method="post">
       <strong>Event Name:</strong><input type="text" name="event_name"><br>
       <strong>Date (xx/xx/xxxx):</strong><input type="text" name="date"><br>
       <strong>Time:</strong>
       <input type="text" name="hours"> : <input type="text" name="minutes">
       <input type="radio" name="amorpm" id="AM" value="AM" />AM
       <input type="radio" name="amorpm" id="PM" value="PM" />PM
       <br>
       <strong>Description:</strong>
       <input type="text" name="description"><br>
       <strong>Location:</strong><br>
       Address:<input type="text" name="address"><br>
       <strong>Filters:</strong><br>
       <input type="checkbox" name="category[]" value="Environmental" />Environmental
       <input type="checkbox" name="category[]" value="Recreation" />Recreation
       <input type="checkbox" name="category[]" id="Arts" value="Arts" />Arts<br>
       <input type="submit" value="Submit Data" name="submitInfo"/>
    </form>
    
EOBODY;
	//$body = $topPart.$errors;

    $firsthalf= <<<EOBODY
          <ul>
          <div id="bar"><li><a  href="map_php.php">Browse Events</a></li></div>
          <div id="bar"><li><a class="active" href="submit.php">Add New Event</a></li></div>
          <div id="bar"><li><a href="profile.php">My Profile</a></li></div>
          <div id="bar"><li><a href="about.asp">About</a></li></div>
          <div id="title"><li><a href="">Welcome to Event Garden!</a></li></div>
        </ul>
EOBODY;
    echo $firsthalf.$page;
    

    

?>
</body>
</html>