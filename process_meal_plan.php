<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate and sanitize inputs (you should add more validation as per your requirements)
    $date = $_POST["date"]; // No need to sanitize as it's a date field
    $breakfast = filter_var($_POST["breakfast"], FILTER_SANITIZE_STRING);
    $lunch = filter_var($_POST["lunch"], FILTER_SANITIZE_STRING);
    $dinner = filter_var($_POST["dinner"], FILTER_SANITIZE_STRING);
    $snacks = filter_var($_POST["snacks"], FILTER_SANITIZE_STRING);

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
    $stmt = $conn->prepare("INSERT INTO meal_plans (date, breakfast, lunch, dinner, snacks) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $date, $breakfast, $lunch, $dinner, $snacks);

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
