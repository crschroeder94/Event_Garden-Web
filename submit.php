<!DOCTYPE html>
<html>
  <head>
    <title>Event Garden</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="topbar.css">
    <style type="text/css">
      html, body {
        height: 100%;
        margin: auto;
      }
      
      .form-style-5{
        max-width: 500px;
        padding: 10px 20px;
        background: #f4f7f8;
        margin: 10px auto;
        padding: 20px;
        background: #f4f7f8;
        border-radius: 8px;
        font-family: Georgia, "Times New Roman", Times, serif;
      }
      .form-style-5 fieldset{
        border: none;
      }
      .form-style-5 legend {
        font-size: 1.4em;
        margin-bottom: 10px;
      }

      .form-style-5 input[type="text"],
.form-style-5 input[type="date"],
.form-style-5 input[type="datetime"],
.form-style-5 input[type="email"],
.form-style-5 input[type="number"],
.form-style-5 input[type="search"],
.form-style-5 input[type="time"],
.form-style-5 input[type="url"],
.form-style-5 textarea,
.form-style-5 select {
    font-family: Georgia, "Times New Roman", Times, serif;
    background: rgba(255,255,255,.1);
    border: none;
    border-radius: 4px;
    font-size: 16px;
    margin: 0;
    outline: 0;
    padding: 7px;
    width: 100%;
    box-sizing: border-box; 
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box; 
    background-color: #e8eeef;
    color:#8a97a0;
    -webkit-box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
    box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
    margin-bottom: 30px;
    
}
.form-style-5 input[type="text"]:focus,
.form-style-5 input[type="date"]:focus,
.form-style-5 input[type="number"]:focus,
.form-style-5 textarea:focus,
.form-style-5 select:focus{
    background: #d2d9dd;
}
.form-style-5 select{
    -webkit-appearance: menulist-button;
    height:35px;
}
.form-style-5 .number {
    background: #1abc9c;
    color: #fff;
    height: 30px;
    width: 30px;
    display: inline-block;
    font-size: 0.8em;
    margin-right: 4px;
    line-height: 30px;
    text-align: center;
    text-shadow: 0 1px 0 rgba(255,255,255,0.2);
    border-radius: 15px 15px 15px 0px;
}
.form-style-5 input[type="submit"],
.form-style-5 input[type="button"]
{
    position: relative;
    display: block;
    padding: 19px 39px 18px 39px;
    color: #FFF;
    margin: 0 auto;
    background: #1abc9c;
    font-size: 18px;
    text-align: center;
    font-style: normal;
    width: 100%;
    border: 1px solid #16a085;
    border-width: 1px 1px 3px;
    margin-bottom: 10px;
}
.form-style-5 input[type="submit"]:hover,
.form-style-5 input[type="button"]:hover
{
    background: #109177;
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
        $time= trim($_POST["time"]);
        $description= trim($_POST["description"]);
        $address = trim($_POST["address"]);
        $category = $_POST["category"];

        $equip_1 = $_POST["equip_1"];
        $quant_1 = $_POST["quant_1"];
        $equip_2 = $_POST["equip_2"];
        $quant_2 = $_POST["quant_2"];
        $equip_3 = $_POST["equip_3"];
        $quant_3 = $_POST["quant_3"];

        $equip_string = $equip_1."-".$quant_1."/".$equip_2."-".$quant_2."/".$equip_3."-".$quant_3;

        addEvent($name,$date,$time,$description,$address,$category, $equip_string);
        header("Location: map_php.php"); /* Redirect browser */
        exit();
		    
	}
    
	$scriptName = $_SERVER["PHP_SELF"];
    $page = <<<EOBODY
    <div class="form-style-5">
    <form action="$scriptName" method="post">
        <fieldset>
        <legend><span class="number">1</span> <strong>Event Info</strong></legend>
        <strong>Event Name:</strong><input type="text" name="event_name"><br>
        <strong>Date (xxxx-xx-xx):</strong><input type="date" name="date"><br>
        <strong>Time:</strong>
        <input type="time" name="time">
        <br>
       <strong>Description:</strong>
       <textarea name="description"></textarea><br>
       <strong>Address:</strong><input type="text" name="address"><br>
       </fieldset>
       <fieldset>
        <legend><span class="number">2</span> <strong>Filters</strong></legend>
       <input type="checkbox" name="category[]" value="Environmental" />Environmental
       <input type="checkbox" name="category[]" value="Recreation" />Recreation
       <input type="checkbox" name="category[]" id="Arts" value="Arts" />Arts<br><br>
       </fieldset>
       <fieldset>
        <legend><span class="number">3</span> <strong>Equipment</strong></legend>
        <table cellpadding="1" cellspacing="1">
                <col width="150px" />
                <col width="30px" />
       <tr><td>Item</td><td>Quantity</td></tr>
       <tr><td><input type="text" name="equip_1"></td><td><input type="number" name="quant_1"></td></tr>
       <tr><td><input type="text" name="equip_2"></td><td><input type="number" name="quant_2"></td></tr>
       <tr><td><input type="text" name="equip_3"></td><td><input type="number" name="quant_3"></td></tr>
       </table>
       </fieldset>
       <input type="submit" value="Create Event" name="submitInfo"/>
    </form>
    </div>
    
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