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

        $firsthalf= <<<EOBODY
          <ul>
          <div id="bar"><li><a class="active" href="default.asp">Browse Events</a></li></div>
          <div id="bar"><li><a href="submit.php">Add New Event</a></li></div>
          <div id="bar"><li><a href="profile.php">My Profile</a></li></div>
          <div id="bar"><li><a href="about.asp">About</a></li></div>
          <div id="title"><li><a href="">Welcome to Event Garden!</a></li></div>
        </ul>
        <div id="right-panel" > <ul>    
EOBODY;
          $num_rows = $result->num_rows;

            for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                $result->data_seek($row_index);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                //echo "{$row['event_name']}";
                $string = <<<EOBODY
                <div id= "event"><li>{$row['event_name']}<br>{$row['event_date']}<br>{$row['event_time']}</li></div>
EOBODY;
                $firsthalf = $firsthalf.$string;
                
            }
              
        $secondhalf= " </ul>
        </div>
        <div id=\"map\"></div>
        <script src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyBuC1WRk_3tYD5kg60VeSJ2Axmt4uNVEI4&libraries=places&callback=initMap\" async defer>
        //https://developers.google.com/maps/documentation/javascript/examples/place-search</script>
"
;

    
    //echo $page;
    
    echo $firsthalf.$secondhalf;
    

    ?>
        
  </body>
</html>