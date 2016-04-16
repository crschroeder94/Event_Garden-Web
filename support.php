<?php

		
		 function changedInfo(){
            $post = $this->post;
            $email =  $_SESSION['email'];
            $name = trim($post['name']);
            $year = trim($post['period']);
            $gender = trim($post['gender']);
            $gpa = trim($post['gpa']);
            $new_email = trim($post['email']);
            $password = trim($post['password']);
            $verify = trim($post['verify']);
            $row = dbuserInfo($email);
            $encrypted_newPass = crypt($password,"helloWorld");
            $query = "";
            $b = "";
    
            $db_connection = new mysqli("localhost", "dbuser", "goodbyeWorld", "event_garden");
            if ($db_connection->connect_error) {
                die($db_connection->connect_error);
            }

            if($row['name']!==$name){
                $query = "update applicants set name='$name' where email = '$email'";
            }
            if($row['year']!==$year){
                $query = "update applicants set year=$year where email = '$email'";
            }
            if($row['gender']!==$gender){
                $query = "update applicants set gender='$gender' where email = '$email'";
            }
            if($row['gpa']!==$gpa){
                $query = "update applicants set gpa=$gpa where email = '$email'";
            }
            if($row['email']!==$new_email){
                $query = "update applicants set email='$new_email' where email = '$email'";
            }
            if($row['password']!==$password){
                if($password == "" || $verify == "" || $password!=$verify){
                    return "No entry exists in the database for the specified email and password<br />";
                }else{
                    $query = "update applicants set password='$encrypted_newPass' where email = '$email'";
                }
            }
            if($query !== ""){
                $result = $db_connection->query($query);
                if (!$result) {
                    die("Update failed: " . $db_connection->error);
                }
            }
    
	
            /* Closing connection */
            $db_connection->close();
            $head = "<h1>The entry has been updated in the database and the new values are</h1>";
            $row = dbuserInfo($post['email']);
            $b = verify($row);
            return $head.$b; 
        }

function getallEvents(){
    $db_connection = new mysqli("localhost", "root", "0000", "event_garden");
            if ($db_connection->connect_error) {
                die($db_connection->connect_error);
            }

    $query = "select * from events";
            
    /* Executing query */
    $result = $db_connection->query($query);
    if (!$result) {
        die("failed: " . $db_connection->error);
    } else {
            $num_rows = $result->num_rows;

            for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                $result->data_seek($row_index);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
            }
    }
    //$result->close();
    /* Closing connection */
    $db_connection->close();
    return $result;
}

function addEvent($name,$date,$time,$description,$address,$category){
    $db_connection = new mysqli("localhost", "root", "0000", "event_garden");
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    }
    $query = "insert into events (event_name, event_date, event_time, description,location)
         values('$name', '$date', '$time', '$description', '$address')";
            
    /* Executing query */
    $result = $db_connection->query($query);
    if (!$result) {
        die("Insertion failed: " . $db_connection->error);
    }
    
    /* Closing connection */
    $db_connection->close();
}



function addtoDB($name, $email, $gpa, $year, $gender, $password){
    /* Connecting to the database */		
	$db_connection = new mysqli("localhost", "dbuser", "goodbyeWorld", "applicationdb");
	if ($db_connection->connect_error) {
		die($db_connection->connect_error);
	}
	//encrypt password
    $encrypted_pass = crypt($password, "helloWorld");

	/* Query */
	$query = "insert into applicants values('$name', '$email', $gpa, $year, '$gender', '$encrypted_pass')";
			
	/* Executing query */
	$result = $db_connection->query($query);
	if (!$result) {
		die("Insertion failed: " . $db_connection->error);
	}
	
	/* Closing connection */
	$db_connection->close();
}

function dbuserInfo($email){
    $db_connection = new mysqli("localhost", "dbuser", "goodbyeWorld", "applicationdb");
	if ($db_connection->connect_error) {
		die($db_connection->connect_error);
	}
	
	/* Query */
	$query = "select * from applicants where email='$email'";
			
	/* Executing query */
	$result = $db_connection->query($query);
	if (!$result) {
		die("failed: " . $db_connection->error);
	} else {
		$num_rows = $result->num_rows;

			for ($row_index = 0; $row_index < $num_rows; $row_index++) {
				$result->data_seek($row_index);
				$row = $result->fetch_array(MYSQLI_ASSOC);
				
			}
	}
	$result->close();
	/* Closing connection */
	$db_connection->close();
    return $row;
}
function generatePage($body, $title="Example") {
    

    $page = <<<EOPAGE
<!doctype html>
<html>
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>$title</title>   
    </head>
            
    <body>
            $body
    </body>
</html>
EOPAGE;

$returntomain=<<<EOBODY
        <form action="main.html" method="post">
        <input type="submit" value="Return to Main Menu"/>
        </form>
EOBODY;
    
    return $page.$returntomain;
}
function verify($row){
    $body = <<<EOBODY
                    <strong>Name:</strong>{$row['name']}<br>
                    <strong>Email:</strong>{$row['email']}<br>
                    <strong>Gpa:</strong>{$row['gpa']}<br>
                    <strong>Year:</strong>{$row['year']}<br>
                    <strong>Gender:</strong>{$row['gender']}<br>
EOBODY;
return $body;
}

function generateUpdateForm($action,$row){
    $sex = $row['gender'];
    $year = $row['year'];
    $year_12_checked = '';
    $year_11_checked = '';
    $year_10_checked = '';
    $male_checked = '';
    $female_checked = '';
    $name = $row['name'];
    $email = $row['email'];
    $gpa = $row['gpa'];
    $password = $row['password'];
    
    switch($year)
    {
        case '10':
            $year_10_checked = "checked";
            break;
        case '11':
            $year_11_checked = "checked";
            break;
        case '12':
            $year_12_checked = "checked";
            break;
        default:
            break;
    }
    
    switch($sex)
    {
        case 'M':
            $male_checked = "checked";
            break;
        case 'F':
            $female_checked = "checked";
            break;
        default:
            break;
    }
    
    
    $topPart = <<<EOBODY
    <form action="$action" method="post">
       <strong>Name:</strong><input type="text" name="name" value="$name"><br>
       <strong>Email:</strong><input type="text" name="email" value="$email"><br>
       <strong>GPA:</strong><input type="number" name="gpa" value="$gpa"><br>
       <strong>Year:</strong>
       <input type="radio" name="period" id="10" value="10" $year_10_checked> 10
       <input type="radio" name="period" id="11" value="11" $year_11_checked>  11
       <input type="radio" name="period" id="12" value="12" $year_12_checked> 12<br>
       <strong>Gender:</strong>
       <input type="radio" name="gender" value="M" $male_checked >M
       <input type="radio" name="gender" value="F" $female_checked >F <br>
       <strong>Password:</strong><input type="password" name="password" value="$password"><br>
       <strong>Verify Password:</strong><input type="password" name="verify" value="$password"><br>
       <input type="submit" value="Submit Data" name="submitUpdate"/>
    </form>
    
EOBODY;

    return $topPart;
}



?>