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
      #map {
        height: 775px;
        
      }
      #right-panel {
        font-family: 'Roboto','sans-serif';
        float:left;
        width:400px;
        height:775px;
        padding-left: 10;
        overflow-y: scroll;
        background-color: #E1CCCC;
        
      }

      #event{
        background-color: white;
        outline-color: #4CAF50;
        outline-width: thin;
        outline-style: solid;

      }

      #attending{
       color: green;
      }

      table{ table-layout:fixed; word-break: break-all; }
    </style>
    
      
      <script >
// This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:

      var map;
      var infowindow;


      function initMap() {
        var pyrmont = {lat: -33.867, lng: 151.195};

        map = new google.maps.Map(document.getElementById('map'), {
          center: pyrmont,
          zoom: 15
        });

        infowindow = new google.maps.InfoWindow();
        createMarker();
        /*var service = new google.maps.places.PlacesService(map);
        service.nearbySearch({
          location: pyrmont,
          radius: 500,
          type: ['store']
        }, callback);*/
      }

      /*function callback(results, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
          for (var i = 0; i < results.length; i++) {
            createMarker(results[i]);
          }
        }
      }*/

      function createMarker() {
        //var placeLoc = place.geometry.location;
        var marker = new google.maps.Marker({
          map: map,
          position: {lat: -33.867, lng: 151.195}
        });

        google.maps.event.addListener(marker, 'click', function() {
          infowindow.setContent("Event A");
          infowindow.open(map, this);
        });
      }
    </script>
  </head>
  <body>
    <?php
        require_once("support.php");
        $result =getallEvents(); //array of filters and distance
        $num_rows = $result->num_rows;
        $enviro_checkbox = "checked";
        $rec_checkbox = "checked";
        $arts_checkbox = "checked";
        $scriptName = $_SERVER["PHP_SELF"];
        if (isset($_POST["submitInfo"])) {
          if (isset($_POST['categories'])) {
            $filters = $_POST['categories'];
            if(!in_array("Environmental", $filters)){
                $enviro_checkbox = "";
            }
            if(!in_array("Recreation", $filters)){
                $rec_checkbox = "";
            }
            if(!in_array("Arts", $filters)){
                $arts_checkbox = "";
            }
            $result = filterBy($filters);
            $num_rows = $result->num_rows;
          }
        }
        if (isset($_POST["Attending"])) {
            attendEvent($_POST["id"]);
            header("Refresh:0"); //refreshes page to add text Attending!
        }
        $firsthalf= <<<EOBODY
          <ul>
          <div id="bar"><li><a class="active" href="default.asp">Browse Events</a></li></div>
          <div id="bar"><li><a href="submit.php">Add New Event</a></li></div>
          <div id="bar"><li><a href="profile.php">My Profile</a></li></div>
          <div id="bar"><li><a href="about.asp">About</a></li></div>
          <div id="title"><li><a href="">Welcome to Event Garden!</a></li></div>
        </ul>
        <div id="right-panel" > <br>Filter by 
        <form action="$scriptName" method="post">
        <input type="checkbox" name="categories[]" id="Environmental"
              value="Environmental" {$enviro_checkbox}/>Environmental
        <input type="checkbox" name="categories[]" id="Recreation" 
              value="Recreation" $rec_checkbox/>Recreation
        <input type="checkbox" name="categories[]" id="Arts" 
              value="Arts" $arts_checkbox/>Arts<br>
        <input type="submit" value="Submit Data" name="submitInfo"/>
        </form>
        <br> 
EOBODY;
          

            for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                $result->data_seek($row_index);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $time_arr = split(":",$row['event_time']);
                $time = "";
                if(intval($time_arr[0]) > 12){
                  $temp = intval($time_arr[0])-12;
                  $time= $time."$temp:{$time_arr[1]} PM";
                }else{
                  $time = $time.$row['event_time']." AM";
                }
                $pretty_date = prettifyDate($row['event_date']);
                //$descript = chunk_split($row['description'], 5)."<br>";
                
                $string = <<<EOBODY
                <div id= "event"><table cellpadding="1" cellspacing="1">
                <col width="150px" />
                <col width="150px" />
                <tr> <td>{$row['event_name']}</td>
EOBODY;
                $attending = "";
                if($row['attending']){$attending = "<td><div id=\"attending\">Attending!</div></td>";}

                $second = <<<EOBODY
                </tr>
                <tr> <td>{$pretty_date} <br> {$time}<br>{$row['location']} </td>
                 <td>{$row['description']}<br></td></tr>
                <tr> <td><form action="$scriptName" method= "post">
                  <input type="hidden" name="id" id="id" value="{$row['id']}">
                  <input type="submit" value="Attend" name="Attending"/>
                </form></td></tr>
                </table></div>
EOBODY;

                $firsthalf = $firsthalf.$string.$attending.$second;
                 
            }
              
        $secondhalf= "
        </div>
        <div id=\"map\"></div>
        <script src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyBuC1WRk_3tYD5kg60VeSJ2Axmt4uNVEI4&libraries=places&callback=initMap\" async defer>
        //https://developers.google.com/maps/documentation/javascript/examples/place-search</script>
"
;
    
    echo $firsthalf.$secondhalf;
    

    ?>
        
  </body>
</html>