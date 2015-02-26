<?php
class OpenWeather {
	
	public $city;
	public $weather;
	public $temperature;
	public $flag_image;
	public $coords_lon;
	public $coords_lat;
	public $weather_image;
	public $id;
	public $has_data = false;
	public $data_array;

// Filter data into an array
	public function getJsonData($json) {

		$data = file_get_contents($json);
		$data_array = json_decode($data, true);
		$this->data_array 	= $data_array;
	}
	
// Assign each data to instance variable
	public function populateJsonData() {
		
		$data_array = $this->data_array;
		
		if($this->validateData($data_array)) {
			$this->city 		= $data_array["name"];
			$this->weather 		= ucwords($data_array["weather"][0]["description"]);
			$this->temperature 	= $data_array["main"]["temp"];
			$this->flag_image 	= strtolower($data_array["sys"]["country"]);
			$this->coords_lon 	= $data_array["coord"]["lon"];
			$this->coords_lat 	= $data_array["coord"]["lat"];
			$this->id 			= $data_array["id"];
		}
		//var_dump($data_array);
	}

// Validate JSon data if no error
	public function validateData($data_array) {
		if($data_array["cod"] != "404") {
			$this->has_data = true;
			return true;
		}
		else {
			$this->has_data = false;
			return false;
		}
	}

// Display different weather image base on the weather
	public function getWeatherImage() {
		$weather_main = $this->data_array["weather"][0]["main"];
		
		if($weather_main == "Clear"){
			return "clear-sky.jpg";
		}
		else if ($weather_main == "Rain"){
			return "raining-sky.jpg";
		}
		else {
			return "cloudy-sky.jpg";
		}
	}
	
// Clean input text on search field
	public function cleanData($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
}