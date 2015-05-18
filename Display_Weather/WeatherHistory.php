<?php include("../master/menu.php");?> 
<title>Weather History</title>

<body>
<div id=content>
<h1> All weather history in the database </h1>
	<?php
	
		echo "Time on page load: <b>" . date("h:i:s") ." the date is " . date("n,d,Y") ."</b><br>";
		echo "<br>";
		$con = new mysqli("localhost", "USERNAME", "PASSWORD", "Weather");
		
		//check db connection
		if (mysqli_connect_errno()) {
			echo "Failure to load data";
		}
		echo "<table>
		<tr>
		<th>Time Taken</th>
		<th>Location</th>
		<th>Temperature</th>
		<th>Wind Speed</th>
		<th>Wind Gust</th>
		<th>Wind Direction</th>
		<th>Humididty</th>
		<th>Conditions</th>
		<th>Barometer Reading</th>
		<th>MoonPhase</th>
		<th>Visibility</th>
		<th>UV Index</th>
		<th>UV Alert</th>
		</tr>";
		
		$query = mysqli_query($con, "SELECT * FROM Conditions ORDER BY time DESC");
		while($row = mysqli_fetch_array($query)) {
			echo "<tr>";
			echo "<td>" . $row['time']. "</td>";
			echo "<td>" . $row['location']. "</td>";
			echo "<td>" . $row['temp']. "</td>";
			echo "<td>" . $row['windSpeed']. "</td>";
			echo "<td>" . $row['windGusts']. "</td>";
			echo "<td>" . $row['windDirection']. "</td>";
			echo "<td>" . $row['humidity']. "</td>";
			echo "<td>" . $row['currentCondition']. "</td>";
			echo "<td>" . $row['barometer']. "</td>";
			echo "<td>" . $row['moonPhase']. "</td>";
			echo "<td>" . $row['visibility']. "</td>";
			echo "<td>" . $row['uvIndex']. "</td>";
			echo "<td>" . $row['uvAlert']. "</td>";
			echo "<tr>";
		}
		
	?>
</div>

</body>