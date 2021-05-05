<!doctype html>
<html lang="en" dir="ltr"><head>
<meta charset="UTF-8">
<title>Santa Cruz</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap stylesheet and JavaScript -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <!-- external stylesheet -->
   <link rel="stylesheet" href="styles.css">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    <!-- Font awesome -->
    <script defer src="https://pro.fontawesome.com/releases/v5.10.0/js/all.js" integrity="sha384-G/ZR3ntz68JZrH4pfPJyRbjW+c0+ojii5f+GYiYwldYU69A+Ejat6yIfLSxljXxD" crossorigin="anonymous"></script>
 <script language="javascript">
        saved_cities = [];          // set up array
    </script>
<style>
		#hero {
			
			background-image: url("images/sc.jpg");
			
		}
		
</style>
<script>
		function getInfo() {
			getAQI();
			getSun();
			getWeather();
		}

		function getWeather() {
			/* Step 1: Make instance of request object...
			...to make HTTP request after page is loaded*/
			request2 = new XMLHttpRequest();
			console.log("1 - request object created");

			// Step 2: Set the URL for the AJAX request to be the JSON file

		request2.open("GET", "https://api.openweathermap.org/data/2.5/onecall?lat=36.974117&lon=-122.030792&exclude=hourly,daily&appid=6e477249e2b1e0f4d6461a66a1947eaa", true)

			console.log("2 - opened request file");

			// Step 3: set up event handler/callback

			request2.onreadystatechange = function() {

				if (request2.readyState == 4 && request2.status == 200) {

					// Step 5: wait for done + success
					console.log("5 - response received");
					result = request2.responseText;
					//alert(result);
					//document.getElementById("temp").innerHTML = result;
					weather = JSON.parse(result);

					temp = weather["current"]["temp"];
					temp = (temp - 273.15) * 9/5 + 32;
					temp = temp.toFixed(2);
					document.getElementById("temp").innerHTML ="Temperature: " + temp + "&deg;F";

				}
				else if (request2.readyState == 4 && request2.status != 200) {

					document.getElementById("temp").innerHTML = "Something is wrong!  Check the logs to see where this went off the rails";

				}

				else if (request2.readyState == 3) {

					document.getElementById("temp").innerHTML = "Too soon!  Try again";

				}

			}
		// Step 4: fire off the HTTP request
			request2.send();
			console.log("4 - Request sent");
		}
	
				// convert UTC to PST
		function formatTime(raw) {
			raw_int = parseInt(raw); 
			var pst = 0;
			if (raw_int < 7) {
				pst = raw_int + 5; 

			} else {
				pst = raw_int - 7;
			}

			return pst;

		}

		// returns the minutes and seconds values for the times
		function getMinutes(raw){
			raw_int = parseInt(raw);
			var length = 0;
			var start = 0;

			// the hour is two digits
			if (raw_int > 9) {
				length = 8;
				start = 2;
			}

			// the hour is one digit
			if (raw_int < 10) {
				length = 7;
				start = 1;

			}
			var count = 0;
			var minutes = "";
			for (var i = start; i < length; i++) {
				minutes = minutes.concat(raw[i]);
			}

			return minutes;
		}



		// determine whether the AM or PM value changes or not
		function AMorPM(raw) {
			raw_int = parseInt(raw);
			var day_time = "";

			// am or pm is different 
			if (raw_int == 12 || (raw_int >= 1 && raw_int < 7)) {
				if (raw[raw.length-2] == "P") {
					day_time = day_time.concat("A");
				} else {
					day_time = day_time.concat("P");
				}
				day_time = day_time.concat(raw[raw.length-1]);
			} 
			// am or pm is the same 
			if (raw_int >= 7 && raw_int < 12) {
				day_time = day_time.concat(raw[raw.length-2]);
				day_time = day_time.concat(raw[raw.length-1]);
			}
			return day_time;
		}
	
		function getSun() {
			request1 = new XMLHttpRequest();

			console.log("1. request object created");

			//request json file from sunrise-sunset.org, fill in lat and lng for Somerville
			request1.open("GET", "https://api.sunrise-sunset.org/json?lat=36.974117&lng=-122.030792", true)

			console.log("2. opened request file");

			request1.onreadystatechange = function() {

				if (request1.readyState == 4 && request1.status == 200) {
					console.log("5. response received");
					result = request1.responseText;
					//document.getElementById("data").innerHTML = result;
					sun = JSON.parse(result);
					var raw_sunrise = sun["results"]["sunrise"];
					var raw_sunset = sun["results"]["sunset"];
					sunrise = formatTime(raw_sunrise);
					sunset = formatTime(raw_sunset);

					var sunrise_minutes = getMinutes(raw_sunrise);
					var sunset_minutes = getMinutes(raw_sunset);
					var sunrise_daytime = AMorPM(raw_sunrise);
					var sunset_daytime = AMorPM(raw_sunset);

					//displays sunrise time:
					document.getElementById("sr").innerHTML ="Sunrise: " + sunrise + sunrise_minutes + "  " + sunrise_daytime;

					//displays sunset time:
					document.getElementById("ss").innerHTML ="Sunset: " +  sunset + sunset_minutes + "  " + sunset_daytime;

					//displays current day length
					document.getElementById("dayl").innerHTML ="Day length: " + sun["results"]["day_length"];

				}
				else if (request1.readyState == 4 && request1.status != 200) {
					document.getElementById("sr").innerHTML = "Something went wrong!";
				}

				else if (request1.readyState == 3) {
					document.getElementById("sr").innerHTML = "Too soon! Try again";
				}

			}

			request1.send();
			console.log("4. request sent");
		}

	    function getAQI() {
            request = new XMLHttpRequest();
            console.log("1 - request object created");


            request.open("GET", "http://api.openweathermap.org/data/2.5/air_pollution?lat=36.974117&lon=-122.030792&appid=9eb8bd1cc3e0712eec15fc85f42632dd", true);
            console.log("2 - opened request file");

            request.onreadystatechange = function() {

                if (request.readyState == 4 && request.status == 200) {


                    console.log("5 - response received");
                    result = request.responseText;

                    var pollution = JSON.parse(result);
                    var aqi = pollution["list"][0]["main"]["aqi"];
                    var description = "";

                    if (aqi == 1) {
                        description = "Good";
                    } else if (aqi == 2) {
                        description = "Fair";
                    } else if (aqi == 3) {
                        description = "Moderate";
                    } else if (aqi == 4) {
                        description = "Poor";
                    } else {
                        description = "Very Poor";
                    }

                    document.getElementById("info").innerHTML = "Current AQI: " + aqi + " (" + description + ")";


                }
                else if (request.readyState == 4 && request.status != 200) {

                    document.getElementById("info").innerHTML = "Error";

                }

                else if (request.readyState == 3) {

                    document.getElementById("info").innerHTML = "Too soon!  Try again";

                }

            }

            request.send();
            console.log("4 - Request sent");
        }
	</script>
</head>


<body onload="getInfo()">
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

	<div id = "hero">
		Santa Cruz
		<form method='post' action=''>
			<input name="save_status" type="submit" class = "btn"/>
			<!--<input name="save_status" type="submit" class = "btn" value="Unsave" />-->
		</form>


		<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
		<script>
			$(document).ready(function(){
				var saved = false;
				for (i = 0; i < saved_cities.length; i++){
					if (saved_cities[i] == "SC"){
						$("input[name='save_status']")[0].value = "Unsave";
							saved = true;
					}
				}
				if (saved == false){
					$("input[name='save_status']")[0].value = "Save";
				}
			  	$("form").submit(function(){
				save_status = $("input[name='save_status']")[0].value;
				if (save_status == 'Save'){
					$("input[name='save_status']")[0].value = "Unsave";
				}
				else if (save_status == 'Unsave'){
					$("input[name='save_status']")[0].value = "Save";
				}
			  });  
			});
		</script>

		<?php

			$save_status = $_POST["save_status"];

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
			if ($save_status == 'Unsave'){
				$sql = "UPDATE yourTrip SET saved = 1 WHERE city = 'SC'";
			}else if ($save_status == 'Save'){
				$sql = "UPDATE yourTrip SET saved = 0 WHERE city = 'SC'";
			}
			$result = $conn->query($sql);

			//close the connection	
			$conn->close();

		?>

	</div>

	<div class="banner">
		Places to visit
	</div>
	<div class="container">
		<div class="block">
				<img class="image" src="images/bea.jpg" alt="Santa Cruz Beach Boardwalk">
				<div class="middle">

					<div class="text">
						<p>Amusement park offers a variety of games & rides right on a mile-long stretch of sandy beach.</p>

					</div>
				</div>
				<h3 class="city">Santa Cruz Beach Boardwalk</h3>
			</div>
			<div class="block">
				<img class="image" src="images/r4.jpg" alt="Mystery Spot">
				<div class="middle">

					<div class="text">
						<p>The Mystery Spot is a tourist attraction where visitors experience demonstrations that appear to defy gravity.</p>
					</div>
				</div>
				<h3 class="city">Mystery Spot</h3>

			</div>
			<div class="block">
				<img class="image" src="images/sbb.jpg" alt="Natural Bridges State Beach">
				<div class="middle">

					<div class="text">
						<p>Natural Bridges State Beach is a 65-acre California State Park. It features unique rock formations and is a hotspot to see monarch butterfly migrations.</p>

					</div>
				</div>
				<h3 class="city">Natural Bridges State Beach</h3>
			</div>


	</div>

	<div class="banner">
		Places to eat
	</div>
	<div class="container">
			<div class="block">
				<img class="image" src="images/r1.jpg" alt="Linda’s Seabreeze Cafe">
				<div class="middle">

					<div class="text">
						<p>Linda’s Seabreeze Cafe<br/>
							542 Seabright Ave

						</p>

					</div>
				</div>
				<h3 class="city">Linda’s Seabreeze Cafe</h3>
			</div>
			<div class="block">
				<img class="image" src="images/r2.jpg" alt="Marianne’s Ice Cream">
				<div class="middle">

					<div class="text">
						<p>Marianne’s Ice Cream<br/>
							1020 Ocean St
						</p>
					</div>
				</div>
				<h3 class="city">Marianne’s Ice Cream</h3>

			</div>
			<div class="block">
				<img class="image" src="images/r3.jpg" alt="West End Tap & Kitchen">
				<div class="middle">

					<div class="text">
						<p>West End Tap &amp; Kitchen<br/>
							334 Ingalls St d</p>

					</div>
				</div>
				<h3 class="city">West End Tap &amp; Kitchen</h3>
			</div>
	</div>

	<div id="wrapper">
		<div class = "info" id = "temp">Loading...</div>
		<div class = "info" id="sr">Loading...</div>
		<div class = "info" id="ss">Loading...</div>
		<div class = "info" id="dayl">Loading...</div>
		<div class = "info" id = "info">Loading...</div>
	</div>

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
