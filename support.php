<?php

function getallEvents(){
    $db_connection = new mysqli("localhost", "root", "0000", "event_garden");
            if ($db_connection->connect_error) {
                die($db_connection->connect_error);
            }

    $query = "select * from events order by event_date ASC";
            
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

function filterBy($filters_arr){
    $query = "select * from events where";
    $db_connection = new mysqli("localhost", "root", "0000", "event_garden");
            if ($db_connection->connect_error) {
                die($db_connection->connect_error);
            }

    if(in_array("Environmental", $filters_arr) && in_array("Recreation", $filters_arr) && in_array("Arts", $filters_arr)){
        $query=$query." Environmental=1 || Recreation=1 || Arts=1";

    }elseif(in_array("Environmental", $filters_arr) && in_array("Recreation", $filters_arr)){
        $query=$query." Environmental = 1 || Recreation = 1";

    }elseif(in_array("Environmental", $filters_arr) && in_array("Arts", $filters_arr)){
        $query=$query." Environmental = 1 || Arts = 1";

    }elseif(in_array("Arts", $filters_arr) && in_array("Recreation", $filters_arr)){
        $query=$query." Arts=1 || Recreation=1";

    }elseif(in_array("Arts", $filters_arr)){
        $query=$query." Arts= 1";

    }elseif(in_array("Environmental", $filters_arr)){
        $query=$query." Environmental= 1";

    }elseif(in_array("Recreation", $filters_arr)){
        $query=$query." Recreation= 1";
    }
      
    /* Executing query */
    $result = $db_connection->query($query);
    if (!$result) {
        die("failed: " . $db_connection->error);
    }else{
        return $result;
    }

}

function attendEvent($id){
   $db_connection = new mysqli("localhost", "root", "0000", "event_garden");
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    } 
    $query = "update events set attending=TRUE where id='$id'";
    $result = $db_connection->query($query);
    if (!$result) {
        die("Insertion failed: " . $db_connection->error);
    }
}

function addEvent($name,$date,$time,$description,$address,$category, $equip){
    $db_connection = new mysqli("localhost", "root", "0000", "event_garden");
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    }
    
    $temp = ",".implode(',',$category);
    $filt = [];
    $it = 0;
    while($it < count($category)){
        //$filt.push(1);
        array_push($filt,TRUE);
        $it+=1;
    }
    $temp1 = ",".implode(",",$filt);
    $query = "insert into events (event_name, event_date, event_time, description,equipment,location$temp)
         values('$name', '$date', '$time', '$description','$equip', '$address'$temp1)";
            
    /* Executing query */
    $result = $db_connection->query($query);
    if (!$result) {
        die("Insertion failed: " . $db_connection->error);
    }
    
    /* Closing connection */
    $db_connection->close();
}

function prettifyDate($date){ //in format year-month-day
    $arr = split("-",$date);
    $months = ["Jan","Feb","Mar","Apr","May","June","July","Aug","Sept","Oct","Nov","Dec"];
    $month = $months[intval($arr[1])];
    return $month." ".intval($arr[2]).", ".$arr[0];
}




?>