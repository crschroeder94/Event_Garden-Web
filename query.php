<?php
	$db_connection = new mysqli("localhost", "root", "0000", "event_garden");
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    } 
    $query = $_GET['query'];
    $result = $db_connection->query($query);
    if (!$result) {
        die("failed: " . $db_connection->error);
    }else{
    	$rows = array();
    	if($result !== FALSE){
            $num_rows = $result->num_rows;

            for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                $result->data_seek($row_index);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $rows[] = $row;
            }
            echo json_encode($rows);
        }else{
        	echo "Success";
        }
    }
    /* Closing connection */
    $db_connection->close();
    


?>