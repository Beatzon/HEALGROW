<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate and sanitize inputs (you should add more validation as per your requirements)
    $date = $_POST["date"]; // No need to sanitize as it's a date field
    $type = $_POST["type"]; // No need to sanitize as it's selected from a predefined list
    $duration = filter_var($_POST["duration"], FILTER_VALIDATE_INT);
    $caloriesBurned = filter_var($_POST["caloriesBurned"], FILTER_VALIDATE_INT);

    // Database connection parameters (assuming the same as in process_client.php)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "fitness_app";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO workouts (date, type, duration, calories_burned) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $date, $type, $duration, $caloriesBurned);

    // Execute SQL statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
} else {
    echo "Form submission method not allowed";
}
?>
