<?php



$servername = "localhost";
// REPLACE with your Database name
$dbname = "marlhwgt_gpstracker";
// REPLACE with Database user
$username = "marlhwgt_usergps";
// REPLACE with Database user password
$password = "mn+Ab?Z4{3=d";

// Keep this API Key value to be compatible with the ESP32 code provided in the project page. 
// If you change this value, the ESP32 sketch needs to match
$api_key_value = "tPmAT5Ab3j7F9";

$api_key = $location = $latitude = $longitude =  $alertdate = $alerttime = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if ($api_key == $api_key_value) {
  
        $location = test_input($_POST["value1"]);
        $latitude = test_input($_POST["value2"]);
        $longitude = test_input($_POST["value3"]); // Corrected variable name
        $alertdate = date("m-d-Y"); // Formats the date as Year-Month-Day
        $alerttime = date("H:i:s");
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        // Corrected SQL INSERT statement with proper variable names
        $sql = "INSERT INTO gpsinfo (location, lon, lat, alert_date, alert_time) VALUES (?, ?, ?, ?, ?)";
        
        // Prepare statement
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
            $conn->close();
            exit;
        }
        
        // Bind parameters and execute
        $stmt->bind_param("sssss", $location, $longitude, $latitude, $alertdate, $alerttime);
        if ($stmt->execute() === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Wrong API Key provided.";
    }
} else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
