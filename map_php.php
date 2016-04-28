<!DOCTYPE html>
<html>
  <head>
    <title>Event Garden</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="topbar.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
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
        background-color:  #c6d8ec;
        
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
        #tfheader{
    background-color:#c3dfef;
  }
  #tfnewsearch{
    float:right;
    padding:20px;
  }
  .tftextinput{
    margin: 0;
    padding: 5px 15px;
    font-family: Arial, Helvetica, sans-serif;
    font-size:14px;
    border:1px solid #0076a3; border-right:0px;
    border-top-left-radius: 5px 5px;
    border-bottom-left-radius: 5px 5px;
  }
  .tfbutton {
    margin: 0;
    padding: 5px 15px;
    font-family: Arial, Helvetica, sans-serif;
    font-size:14px;
    outline: none;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    color: #ffffff;
    border: solid 1px #0076a3; border-right:0px;
    background: #0095cd;
    background: -webkit-gradient(linear, left top, left bottom, from(#00adee), to(#0078a5));
    background: -moz-linear-gradient(top,  #00adee,  #0078a5);
    border-top-right-radius: 5px 5px;
    border-bottom-right-radius: 5px 5px;
  }
  .tfbutton:hover {
    text-decoration: none;
    background: #007ead;
    background: -webkit-gradient(linear, left top, left bottom, from(#0095cc), to(#00678e));
    background: -moz-linear-gradient(top,  #0095cc,  #00678e);
  }
  /* Fixes submit button height problem in Firefox */
  .tfbutton::-moz-focus-inner {
    border: 0;
  }
  .tfclear{
    clear:both;
  }
  #toggle {
    width: 100px;
    height: 100px;
    background: #ccc;
  }
  
    </style>
      <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  </head>
  <body>
    <?php
        require_once("support.php");
        $result =getallEvents(); //array of filters and distance
        $events_arr = [];
        $num_rows = $result->num_rows;
        $enviro_checkbox = "checked";
        $rec_checkbox = "checked";
        $arts_checkbox = "checked";
        $animal_checkbox="checked";
        $social_checkbox="checked";
        $filter_dist = 10;
        $scriptName = $_SERVER["PHP_SELF"];
        if (isset($_POST["submitFilters"])) {
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
            if(!in_array("Animals", $filters)){
                $animal_checkbox = "";
            }
            if(!in_array("Social", $filters)){
                $social_checkbox = "";
            }
            $result = filterBy($filters);
            $num_rows = $result->num_rows;
            if(isset($_POST['filter_dist'])){
              $filter_dist = $_POST['filter_dist'];
            }
          }
        }

        $firsthalf= <<<EOBODY
          <ul>
          <div id="bar"><li><a class="active" href="default.asp">Browse Events</a></li></div>
          <div id="bar"><li><a href="submit.php">Add New Event</a></li></div>
          <div id="bar"><li><a href="profile.php?profile_name=EventPlanner1">My Profile</a></li></div>
          <div id="bar"><li><a href="about.asp">About</a></li></div>
          <div id="bar"><li id="search">
          <form action="" method="get">
            <input type="text" name="search_text" id="search_text" placeholder="Search Organizations"/>
            <input type="button" name="search_button" id="search_button"></a>
          </form>
          </li></div>
          <div id="title"><li><a href="">Welcome to Event Garden!</a></li></div>
        </ul>
        <div id="right-panel" > <br>Filter by 
        <form action="$scriptName" method="post">
        Radius: <input type="number" id="filter_dist" name="filter_dist" value=$filter_dist style="width: 40px"> miles<br>
        <input type="checkbox" name="categories[]" id="Environmental"
              value="Environmental" {$enviro_checkbox}/>Environmental <i class="fa fa-recycle" aria-hidden="true"></i>
        <input type="checkbox" name="categories[]" id="Recreation" 
              value="Recreation" $rec_checkbox/>Recreation <i class="fa fa-futbol-o" aria-hidden="true"></i>
        <input type="checkbox" name="categories[]" id="Arts" 
              value="Arts" $arts_checkbox/>Arts <i class="fa fa-paint-brush" aria-hidden="true"></i><br>
        <input type="checkbox" name="categories[]" id="Animals" 
              value="Animals" $animal_checkbox/>Animals <i class="fa fa-paw" aria-hidden="true"></i>
        <input type="checkbox" name="categories[]" id="Social" 
              value="Social" $social_checkbox/>Social <i class="fa fa-glass" aria-hidden="true"></i><br>
        <input type="Submit" id= "filters" value="Filter" name="submitFilters"/>
        </form>
        <br> 
        <div id="event_list"></div>
EOBODY;

//http://designmodo.com/create-drop-down-menu-search-box/        
            $str = "<div id=\"event_list\"></div>";

            for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                $result->data_seek($row_index);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                if(valiDate($row['event_date'],$row['event_time'])){
                  $time_arr = split(":",$row['event_time']);
                  $time = "";
                  if(intval($time_arr[0]) > 12){
                    $temp = intval($time_arr[0])-12;
                    $time= $time."$temp:{$time_arr[1]} PM";
                  }else{
                    $time = $time.$row['event_time']." AM";
                  }

                  $pretty_date = prettifyDate($row['event_date']);
                
                  $string = <<<EOBODY
                  <div id= "event"><div id="event_{$row['id']}"><table cellpadding="1" cellspacing="1">
                  <col width="150px" />
                  <col width="150px" />
                  <tr> <td>{$row['event_name']}</td><td><div id="attend_{$row['id']}">
EOBODY;
                  $attending = "";
                  $button_val = "";
                  if($row['attending']){
                    $attending = "Attending!";
                    $button_val = "Unattend";
                  }else{
                    $button_val = "Attend";
                  }
                  $attending = $attending."</div></td>";
                  $second = <<<EOBODY
                  </tr>
                  <tr> <td>{$pretty_date} <br> {$time}<br>{$row['location']} </td>
                  <td>{$row['description']}<br></td></tr>
                  <tr> <td><form action="$scriptName" method= "post">
                    <input type="hidden" name="id" id="id" value="{$row['id']}">
                    <input type="button" value="{$button_val}" name="Attending" id="attend_btn_{$row['id']}"/>
                  </form></td></tr>
                  </table></div></div>
EOBODY;
                $firsthalf = $firsthalf.$string.$attending.$second.$str;
              }
              array_push($events_arr, $row);   
            }
              
        $secondhalf= "
        </div>
        <div id=\"map\"></div>
        
        <script src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyBuC1WRk_3tYD5kg60VeSJ2Axmt4uNVEI4&libraries=geometry,places&callback=initMap\" async defer>
        //https://developers.google.com/maps/documentation/javascript/examples/place-search</script>
        
"
;
           print '
 <script type="text/javascript">        
      var events = '.json_encode($events_arr).'
 </script>';
//echo JSON.parse($events_arr);
 //print_r($events_arr);
    echo $firsthalf.$secondhalf;
    

    ?>

    <script>
    var map;

    var filter_dist = document.getElementById("filter_dist").value;
 
    //$( document ).click(function() {
    //  $( "#toggle" ).effect("highlight", {color: 'blue'}, 3000);
    //});
    
      function initMap() {
        //getLocation();
        var NYC = {lat: 40.712, lng: -74.005};

        map = new google.maps.Map(document.getElementById('map'), {
          center: NYC,
          zoom: 15
        });

        //infowindow = new google.maps.InfoWindow();
//sets marker for current location
      //https://developers.google.com/maps/documentation/javascript/examples/map-geolocation
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          //cur_lat=position.coords.latitude;
          //cur_long=position.coords.longitude;

          var pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };
          createMarkers(pos);
        }, function() {
          alert("Location Error");
          handleLocationError(true, infowindow, map.getCenter());
        });
      } else {
        // Browser doesn't support Geolocation
        alert("Browser does not support geolocation");
      }
      }

    function createMarkers(pos) {
        var marker1 = new google.maps.Marker({
            map: map,
            position: {lat: pos.lat, lng: pos.lng},
            icon : 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
          });
        map.setCenter(pos);
        
//sets event markers
      //http://stackoverflow.com/questions/5984179/javascript-geocoding-from-address-to-latitude-and-longitude-numbers-not-working
        
        //var xmlhttp = new XMLHttpRequest();
        //xmlhttp.onreadystatechange = function() {
            //if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                //var values = JSON.parse(xmlhttp.responseText);
                var i;
                var curr_latlng = new google.maps.LatLng(pos.lat, pos.lng);
                for(i =0; i<events.length; i++){
                     
                    findEventLocation(events[i],curr_latlng);
                    
                    var button = "attend_btn_"+events[i].id;
                    var attend = "attend_"+events[i].id;
                    addAttendButtonListener(events[i].id);
                }
      }

      function findEventLocation(event,curr){
        
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode( { 'address': event.location}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                      var latitude = results[0].geometry.location.lat();
                      var longitude = results[0].geometry.location.lng();

                      var latlng=new google.maps.LatLng(latitude,longitude);
                      var dist_meters = google.maps.geometry.spherical.computeDistanceBetween(curr,latlng);
                      var dist_miles = metersTomiles(dist_meters);
                      if(dist_miles <= filter_dist){
                        var marker = new google.maps.Marker({
                          map: map,
                          position: {lat: latitude, lng: longitude}
                        });
                        var infowindow1 = new google.maps.InfoWindow();

                        addMarkerListener(marker,event.event_name,event.id,infowindow1);
                        var button = "#attend_btn_"+event.id;
                        //alert(button);
                        var attend = "attend_"+event.id;
                        //addEventToList(event);
                        
                        
                      } 
                    } 
                    }); 
      }

      function addAttendButtonListener(id){
        //alert(id);
          var button = "attend_btn_"+id;
          var attend = "attend_"+id;
          //$(button).addEventListener("click",)
          document.getElementById(button).addEventListener("click",function(){
                    //var id = document.getElementById("id").value;
                    if(document.getElementById(button).value === "Attend"){
                      document.getElementById(button).value = "Unattend";
                      document.getElementById(attend).innerHTML = "Attending!";
                      var xmlhttp = new XMLHttpRequest();
                      xmlhttp.open("GET", "query.php?query=update events set attending=TRUE where id="+id, true);
                      xmlhttp.send();
                    }else{
                      document.getElementById(button).value = "Attend";
                      document.getElementById(attend).innerHTML = "";
                      var xmlhttp = new XMLHttpRequest();
                      xmlhttp.open("GET", "query.php?query=update events set attending=FALSE where id="+id, true);
                      xmlhttp.send();
                    }
                  });
        }

      function addMarkerListener(marker,title,id, infowindow){
        google.maps.event.addListener(marker, 'click', function() {
                infowindow.setContent(title);
                infowindow.open(map, this);
                var tag="#event_"+id;
                $(tag).effect("highlight", {color: 'green'}, 3000);
        });
      }

      function metersTomiles(meters){
        return meters*0.00062;
      }

    </script>
        
  </body>
</html>