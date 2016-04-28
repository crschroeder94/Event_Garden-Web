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
      h1{
        text-align: center;
        font-size: 100px;
        font-style: bold;
      }
      p{
        font-size: 50px;
      }
      .image { 
   position: relative; 
   width: 100%; /* for IE 6 */
}

h2 { 
   position: absolute; 
   top: 200px; 
   left: 0; 
   width: 100%; 
}
h2 span { 
   color: white; 
   font: bold 24px/45px Helvetica, Sans-Serif; 
   letter-spacing: -1px;  
   background: rgb(0, 0, 0); /* fallback color */
   background: rgba(0, 0, 0, 0.7);
   padding: 10px; 
}
#rectangle{
    width:200px;
    height:100px;
    background:blue;
    text-align: center;
}
    </style>
    </head>
    <body>
      <ul>
          <div id="bar"><li><a  href="map_php.php">Browse Events</a></li></div>
          <div id="bar"><li><a  href="submit.php">Add New Event</a></li></div>
          <div id="bar"><li><a class="active" href="profile.php?profile_name=EventPlanner1">My Profile</a></li></div>
          <div id="bar"><li><a href="about.php">About</a></li></div>
          <div id="title"><li><a href="">Welcome to Event Garden!</a></li></div>
        </ul>
        <?php
//// we're assuming the calls are coming in as <a href="profile.php?profile_name=Homeless Shelter&data2=Data120">Click here</a>
        $str = "";
        if ($_GET["profile_name"]== "EventPlanner1"){
            $str = <<<EOBODY
            <div id="rectangle"></div>
            <h1>{$_GET["profile_name"]}</h1>
            
            <h2> About:</h2>
            <p> "I'm currently a student at University of Maryland trying to meet new people and help the community!"</p>

<div class="image">

      <img src="profile.png" alt="Profile Picture" width="150" height="100"><img src="text-bubble.png" alt="Text Bubble" width="600" height="50" />
      
      <h2><span>A Movie in the Park:<br />Kung Fu Panda</span></h2>

</div>
EOBODY;
        }

        echo $str;

        ?>

    </body>
    </html>