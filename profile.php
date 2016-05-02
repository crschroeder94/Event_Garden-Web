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
#right-panel {
        font-family: Helvetica;
        float:right;
        margin-top: 30px;
        margin-right: 100px;
        width:300px;
        height:775px;
        padding-right: 10;
        background-color:  #c6d8ec;

        
      }

      .profile_pic{
         display:block;
    margin:auto;
    background-color: white;
      margin-bottom: 20px;
      }

      #name{
        font-family: Helvetica;
        margin-top: 20px;
          font-size: 30px;
          margin-left: 55px;
          margin-bottom: 20px;
          margin-right: 30px;
      }

      #info{
        font-family: Helvetica;
        font-size: 20px;
        margin-left: 55px;
        margin-right: 30px;
        margin-bottom: 20px;
      }

      #data{
        font-size: 15px;
        margin-left: 10px;
        margin-top: 10px;
      }

      #feed{
        font-family: Helvetica;
        float:left;
        margin-top: 10px;
        margin-left: 100px;
        width:700px;
        height:775px;
        padding-left: 10;
        
      }

      #recent_activity_text{
        font-family: Helvetica;
        float:left;
        margin-top: 40px;
        margin-left: 100px;
      }

      #feed_item{
        background-color: white;
        
            border-radius: 25px;
    border: 2px solid #73AD21;
    padding: 20px; 
        width:600px;
        height:30px;
        margin-top: 30px;
        margin-left: 30px;
        margin-bottom: 20px;
      }

      #feed_text{
        font-family: Helvetica;
        margin-left: 20px;
        margin-top: 10px;

      }

      #date{
          float:right;
          font-size: 10px;
      }
    </style>
    </head>
    <body>
<ul>
          <div id="bar"><li><a href="map_php.php">Browse Events</a></li></div>
          <div id="bar"><li><a href="submit.php">Add New Event</a></li></div>
          <div id="bar"><li><a class="active" href="profile.php?profile_name=EventPlanner1">My Profile</a></li></div>
          <div id="bar"><li><a href="about.asp">About</a></li></div>
          <div id="bar"><li id="search">
          <form action="profile.php" method="get">
            <input type="text" name="profile_name" id="search_text" placeholder="Search Organizations"/>
            <input type="submit" name="search_button" id="search_button"></a>
          </form>
          </li></div>
          <div id="title"><li><a href="">Welcome to Event Garden!</a></li></div>
        </ul>
        <?php
//// we're assuming the calls are coming in as <a href="profile.php?profile_name=Homeless Shelter&data2=Data120">Click here</a>
        $str = "";
        if ($_GET["profile_name"]== "EventPlanner1"){
            $str = <<<EOBODY
            <div id="right-panel">
            <div id="name"><b>{$_GET["profile_name"]}</b></div>
            <img class="profile_pic" src="profile.png" alt="Profile Picture" width="150" height="100">
            <div id="info">Member since: <div id="data">3/1/2016 </div><br>
            Events Hosted:<br> <div id="data">4 </div><br>
            Events Attended:<br> <div id="data">6 </div><br>
<div id="data">"I'm currently a student at University of Maryland trying to meet new people and help the community!"<br><br> <b>INSERT REPUTATION PICTURE</b></div>
            
            </div>
          </div>
<div id="recent_activity_text"><b>Recent Activity:</b></div>
<div id="feed">
<ul>
        <li>
          
            <div id="feed_item">
            <div id = "feed_text">{$_GET["profile_name"]} attended "Spring Fling" </div><div id="date"><br>4/20/2016</div>
            </div>
          
        </li>

        <li>
            <div id="feed_item">
            <div id = "feed_text">{$_GET["profile_name"]} " attended "Israel Fest"</div><div id="date"><br>4/16/2016</div>
            </div>
        </li>

        <li>
            <div id="feed_item">
            <div id = "feed_text">{$_GET["profile_name"]} is hosting "Spring Fling" </div><div id="date"><br>4/10/2016</div>
            </div>
        </li>

        <li>
            <div id="feed_item">
            <div id = "feed_text">{$_GET["profile_name"]} attended "March Madness Party" </div><div id="date"><br>3/20/2016</div>
            </div>
        </li>

        <li>
            <div id="feed_item">
            <div id = "feed_text">{$_GET["profile_name"]} wrote a review for "Stream Clean Up" </div><div id="date"><br>3/5/2016</div>
            </div>
        </li>

        <li>
            <div id="feed_item">
            <div id = "feed_text">{$_GET["profile_name"]} attended "Habitat for Humanity" </div><div id="date"><br>3/1/2016</div>
            </div>
        </li>

        <li>
            <div id="feed_item">
            <div id = "feed_text">{$_GET["profile_name"]} became a member!" </div><div id="date"><br>3/1/2016</div>
            </div>
        </li>

</ul>
</div>
          
            
            
            
EOBODY;
        }else{
          $str = <<<EOBODY
            <div id="right-panel">
            <div id="name"><b>{$_GET["profile_name"]}</b></div>
            <img class="profile_pic" src="profile.png" alt="Profile Picture" width="150" height="100">
            <div id="info">Member since: <div id="data">3/1/2016 </div><br>
            Events Hosted:<br> <div id="data">12 </div><br>
            Events Attended:<br> <div id="data">2 </div><br>
            <div id="data">"We are a local charity aimed at feeding the homeless. Join our Fight!"<br><br> <b>INSERT REPUTATION PICTURE</b></div>
            
            </div>
          </div>
          <div id="recent_activity_text"><b>Recent Activity:</b></div>
          <div id="feed">
      <ul>
        <li>
          
            <div id="feed_item">
            <div id = "feed_text">{$_GET["profile_name"]} is hosting "5K for World Hunger" </div><div id="date"><br>4/20/2016</div>
            </div>
          
        </li>

        <li>
            <div id="feed_item">
            <div id = "feed_text">{$_GET["profile_name"]} " is hosting "Feed the Homeless"</div><div id="date"><br>4/16/2016</div>
            </div>
        </li>

        <li>
            <div id="feed_item">
            <div id = "feed_text">{$_GET["profile_name"]} is hosting "Spring Fling" </div><div id="date"><br>4/10/2016</div>
            </div>
        </li>

        <li>
            <div id="feed_item">
            <div id = "feed_text">{$_GET["profile_name"]} attended "Homeless NonProfit Convention" </div><div id="date"><br>3/20/2016</div>
            </div>
        </li>

        <li>
            <div id="feed_item">
            <div id = "feed_text">{$_GET["profile_name"]} became a member!" </div><div id="date"><br>3/1/2016</div>
            </div>
        </li>

</ul>
</div>
EOBODY;
        }

        echo $str;

        ?>

    </body>
    </html>