<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>California Road Trip - Your Trip</title>

    <!-- Bootstrap stylesheet and JavaScript -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <!-- external stylesheet -->
   <link rel="stylesheet" href="styles.css">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    <!-- Font awesome -->
    <script defer src="https://pro.fontawesome.com/releases/v5.10.0/js/all.js" integrity="sha384-G/ZR3ntz68JZrH4pfPJyRbjW+c0+ojii5f+GYiYwldYU69A+Ejat6yIfLSxljXxD" crossorigin="anonymous"></script>
    <!-- Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
	<script src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
    <style>
        .container-fluid {
            padding: 7% 10%;
        }

        * {
            box-sizing: border-box;
        }

        body{
            margin:0;
            width: 100vw;
            position: relative;
            font-family: "Poppins";
        }

        .banner{
            margin-left:20px;
            margin-right:20px;
            margin-top: 30px;
            position: relative;
            font-size: 30px;
        }
        .row-big {
            text-align: center;
			display: flex;
        }

		.block.showme {
			display: inline-block;
		}

        .column {
            flex: 50%;
            padding: 10px;
        }

        #mapDiv {
            height: 45rem;
            text-align: center;
            background-color: #FAF3EB;
            width: 60%;
            margin: 50px auto 70px auto;
            padding: 30px 0;
            border-radius: 20px;
        }

        #container {
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 30px;
            position: relative;
            padding: 10px;
        }

        .block {
            display: none;
            width: auto;
            height: 230px;
            margin: 5px 15px 10px 15px;
            position: relative;
            transition: all 1s;
        }

        .middle {
            transition: .5s ease;
            opacity: 0;
            width: 300px;
            position: absolute;
            text-align: center;
            display: flex;
            top: 30%;
            left: 7%;
        }


        .image {
            border-radius: 6px;
            width: auto;
            height: 230px;
            transition: all 1s;
        }


        .block:hover .middle {
            opacity: 1;
        }

        .block:hover .text {
            opacity: 1;
        }

        .text {
            width: 100%;
            margin-left: 10px;
            padding-right: 0px;
            color: white !important;
            font-size: 15px;
            padding: 0px 0px;
            letter-spacing: 0.5px;
            text-align: center;
            position: absolute;
            font-family: "Poppins";
        }

        .text a {
            text-align: center;
            color: #7B7B7B;
            font-family: "Poppins";

        }

        .text p {
            letter-spacing: 3px;
            color: #000;
            position: relative;
            bottom: 15px;
            font-size: 100%;
        }


        .block:hover .middle {
            opacity: 1;
        }

        .block:hover .text {
            opacity: 1;
        }

        .block:hover .text a {
            opacity: 1;
        }

        .block:hover .image {
            opacity: 0.2;
            transform: scale(1.05);
        }

        .row {
            display: flex;
            justify-content: center;
            text-align: center;
        }

        .city {
            font-size: 30px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: white;
            position: absolute;
            bottom: -17px;
            left: 20px;
            font-family: "Poppins";

        }

        @media screen and (max-width: 600px) {
            .row-big {
                flex-direction: column;
            }
        }
        @media screen and (max-width: 800px) {
            .row-big {
                flex-direction: column;
            }
        }
    </style>
    <script language="javascript">
        saved_cities = [];          // set up array
    </script>
</head>

<body>
	<script src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
    <!-- Bootstrap Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">California Road Trip</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://jasonxiang.great-site.net/final/yourTrip.php">Your Trip</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Cities
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="http://jasonxiang.great-site.net/final/LosAngeles.php">Los Angeles</a></li>
                            <li><a class="dropdown-item" href="http://jasonxiang.great-site.net/final/Napa.php">Napa</a></li>
                            <li><a class="dropdown-item" href="http://jasonxiang.great-site.net/final/SanDiego.php">San Diego</a></li>
                            <li><a class="dropdown-item" href="http://jasonxiang.great-site.net/final/SanFrancisco.php" data-toggle="dropdown">San Francisco</a></li>
                            <li><a class="dropdown-item" href="http://jasonxiang.great-site.net/final/SantaCruz.php">Santa Cruz</a></li>
                            <li><a class="dropdown-item" href="http://jasonxiang.great-site.net/final/SantaBarbara.php">Santa Barbara</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php
        //establish connection info
        $server = "sql309.epizy.com";
        $userid = "epiz_27886961";
        $pw = "eqoCc6gwr6t";
        $db= "epiz_27886961_yourTrip";

        // Create connection
        $conn = new mysqli($server, $userid, $pw);

        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        //select the database
        $conn->select_db($db);
            
        //run a query
        $sql = "SELECT city FROM yourTrip WHERE saved = 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()){
                $city = $row["city"];
                echo "<script language='javascript'>saved_cities.push('$city')</script>";
            }
        } 

        //close the connection  
        $conn->close();
    ?>
    <div class="row-big">
        <div class="column">
            <h2>Itinerary</h2>
            <section id="container">
                <div class="row">
                    <div class="block" id = "SF">
                        <img class="image" src="images/SF.jpg" alt="San Francisco">
                        <div class="middle">
                            <div class="text">
                                <p>See the heart of the Golden State.</p>
                                <a href="http://jasonxiang.great-site.net/final/SanFrancisco.php"> Learn More </a>
                            </div>
                        </div>
                        <h3 class="city">San Francisco</h3>
                    </div>

                    <div class="block" id="SC">
                        <img class="image" src="images/santacruz.jpg" alt="santa cruz">
                        <div class="middle">

                            <div class="text">
                                <p>Visit this energetic surf town.</p>
                                <a href="http://jasonxiang.great-site.net/final/SantaCruz.php"> Learn More </a>
                            </div>
                        </div>
                        <h3 class="city">Santa Cruz</h3>
                    </div>

                    <div class="block" id="SB">
                        <img class="image" src="images/SB.jpg" alt="santa barbara">
                        <div class="middle">
                            <div class="text">
                                <p>The perfect pair: beach views and historic sites.</p>
                                <a href="http://jasonxiang.great-site.net/final/SantaBarbara.php"> Learn More </a>
                            </div>
                        </div>
                        <h3 class="city">Santa Barbara</h3>
                    </div>
                </div>
            </section>

            <div class="row">
                <div class="block" id="LA">
                    <img class="image" src="images/LA.jpg" alt=“”>
                    <div class="middle">
                        <div class="text">
                            <p>Visit the entertainment hub of California.</p>
                            <a href="http://jasonxiang.great-site.net/final/LosAngeles.php"> Learn More </a>
                        </div>
                    </div>
                    <h3 class="city">Los Angeles</h3>

                </div>
                <div class="block" id="Napa">
                    <img class="image" src="images/Napa.jpg" alt="Napa">
                    <div class="middle">

                        <div class="text">
                            <p>Explore the vineyards and go wine tasting.</p>
                            <a href="http://jasonxiang.great-site.net/final/Napa.php"> Learn More </a>
                        </div>
                    </div>
                    <h3 class="city">Napa Valley</h3>

                </div>
                <div class="block" id="SD">
                    <img class="image" src="images/SD.jpg" alt="San Diego">
                    <div class="middle">

                        <div class="text">
                            <p>Craving a beach trip and authentic Mexican food?</p>
                            <a href="http://jasonxiang.great-site.net/final/SanDiego.php"> Learn More </a>
                        </div>
                    </div>
                    <h3 class="city">San Diego</h3>
                </div>
            </div>
        </div>
        <div class="column">
            <h2>Your trip</h2>
            <div id="mapDiv"></div>
        </div>
    </div>


    <script>
        function addMarker(city_obj, map) {
            name = city_obj.name;
            lat = city_obj.lat;
            lon = city_obj.lon;
            // add marker to the map
            marker = L.marker([lat, lon]).addTo(map);
            // add popup to the marker
            marker.bindPopup(name);
        }

        var LA = {
            name: 'Los Angeles',
            lat: 34.05,
            lon: -118.24
        };
        var SF = {
            name: 'San Francisco',
            lat: 37.77,
            lon: -122.42
        }
        var SB = {
            name: 'Santa Barbara',
            lat: 34.42,
            lon: -119.70
        }
        var NA = {
            name: 'Napa',
            lat: 38.29,
            lon: -122.28
        }
        var SD = {
            name: 'San Diego',
            lat: 32.72,
            lon: -117.16
        }
        var SC = {
            name: 'Santa Cruz',
            lat: 36.97,
            lon: -122.03
        }

        map = L.map('mapDiv').setView([35, -120], 6);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
            maxZoom: 18,
        }).addTo(map);

        for (i = 0; i < saved_cities.length; i++){
            if (saved_cities[i] == "SC"){
                $("#SC").addClass("showme");
                addMarker(SC, map);
            }
            if (saved_cities[i] == "SF"){
                $("#SF").addClass("showme");
                addMarker(SF, map);

            }
            if (saved_cities[i] == "NA"){
                $("#Napa").addClass("showme");
                addMarker(NA, map);
            }
            if (saved_cities[i] == "SD"){
                $("#SD").addClass("showme");
                addMarker(SD, map);
            }
            if (saved_cities[i] == "LA"){
                $("#LA").addClass("showme");
                addMarker(LA, map);
            }
            if (saved_cities[i] == "SB"){
                $("#SB").addClass("showme");
                addMarker(SB, map);
            }
        }
    </script>

    <footer id="footer">
        <div class="container-fluid">
            <a href="https://www.facebook.com"><i class="footer-icon fab fa-facebook"></i></a>
            <a href="https://www.instagram.com"><i class="footer-icon fab fa-instagram"></i></a>
            <a href="mailto:CaliforniaRoadTrip@gmail.com"><i class="footer-icon fas fa-envelope"></i></a>
            <p>© Copyright 2021 California Road Trip</p>
        </div>
    </footer>
</body>

</html>
