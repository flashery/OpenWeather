<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Weather Open</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
	
		<div class="form-content">

		 <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
			<h2>Current Weather In Your City</h2>
			<input id="text" type="text" name="city" placeholder="Type your city name...">
			<input id="submit" name="submit" type="submit" value="Search">
		</form>
		
		</div>
		

		
		<div class="outer">
		<div class="inner">
		
			<?php 
				if(isset($_POST['submit']) && !empty($_POST['city'])): 
						require('OpenWeather.php');
						$openweather = new OpenWeather();
						$openweather->cleanData($_POST['city']);
						
						$json = 'http://api.openweathermap.org/data/2.5/weather?q='.htmlspecialchars($_POST['city'])."&units=metric";
						
						$openweather->getJsonData($json);
						$openweather->populateJsonData();
						//echo $_POST['city'];
			?>
			<?php 
				if($openweather->has_data){
				echo "<img class='weather-image' src='images/". $openweather->getWeatherImage() ."'>";

				echo "<div class='weather-info'>";
			
					echo "<a href='http://openweathermap.org/city/". $openweather->id ."/'>". $openweather->city ."</a>";
					echo "<img src='http://openweathermap.org/images/flags/". $openweather->flag_image .".png'>";
				
					echo "<h4 class='temperature'>". round($openweather->temperature,1) ."°С</h4>";
					echo "<span>". $openweather->weather ."</span>";

					echo "<p>Geo coords <a href='http://openweathermap.org/Maps?zoom=12&lat=". $openweather->coords_lat ."&lon=". $openweather->coords_lon ."&layers=B0FTTFF'>[ ". $openweather->coords_lon .", ". $openweather->coords_lat ." ]</a></p>";
				}
				else {
					echo "<p class='error'>Not found city.</p>";
			
				}
				echo "</div>";
				
			?>
			
			<?php 
				else:
					echo "<p class='error'>No data to display.</p>";
				endif 
			?>
		</div>
		</div>
	</body>

</html>

