
<?php include("../master/menu.php");
//THIS IS JUST AN EXAMPLE ?> 
<title> Current Weather</title>

<body>
	<div id=content>
	
	<h1> Current Weather </h1>
		
	
	<?php
		//This is the bulk of what is needed to extract the data from the SQL database (db)
		echo "Time on page load: <b>" . date("h:i:s") ."</b><br>";
		//create db connection
		$con = new mysqli("localhost", "USERNAME", "WEATHER", "Weather");
		
		//The time of page load is just for fun, and reference to when time in DB was last updated
		$curTime = date("h:i:s");
		$curDate = "'105 OR 1=1'"; //date("Y:m:d");
		
		//check db connection
		if (mysqli_connect_errno()) {
			echo "Failure to load data";
		}
		
		//query the database and use the select statemtn to get the data
		$query = mysqli_query($con, "SELECT * FROM Conditions ORDER BY time DESC LIMIT 0,1");
		
		/*$row holds database information, used to reference it to get each column of data
			for a specific data range (usually the most recent date/time taken) 
		*/
		$row = mysqli_fetch_array($query);
		echo "Current temparture: ".$row['temp']. "<br>";
		echo "Weather Last up dates at: ".$row['time']. "<br>";
		echo "Weather data for: " .$row['location'] ."<br>";
		echo "The current Conditions are: <b>". $row["currentCondition"]. "</b><br>";
		echo "Current humidity: ". $row[humidity]. "<br>";
		echo "The UV index and alert: ".$row[uvIndex] ." ". $row[uvAlert]."<br>";
		echo "Wind speed and direction: ".$row[windSpeed]." " .$row[windDirection];
		echo "<br>";
		
		//end connection
		mysqli_close($con);
	?>
	<br>
	<p> See all of the weather in the database (WARNING , this could be a very long table):
	<br>
	<a href="../weather/WeatherHistory.php">Weather History</a> </p>
	</div>
	
</body>

</html>