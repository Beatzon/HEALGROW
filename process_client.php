<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate and sanitize inputs (you should add more validation as per your requirements)
    $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $age = filter_var($_POST["age"], FILTER_VALIDATE_INT);
    $gender = $_POST["gender"]; // No need to sanitize as it's selected from a predefined list
    $height = filter_var($_POST["height"], FILTER_VALIDATE_FLOAT);
    $weight = filter_var($_POST["weight"], FILTER_VALIDATE_FLOAT);
    $activityLevel = $_POST["activityLevel"]; // No need to sanitize as it's selected from a predefined list

    // Database connection parameters
    $servername = "localhost"; // Replace with your server name
    $username = "root"; // Replace with your database username
    $password = ""; // Replace with your database password
    $dbname = "fitness_app"; // Replace with your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO clients (name, email, age, gender, height, weight, activity_level) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisddd", $name, $email, $age, $gender, $height, $weight, $activityLevel);

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
