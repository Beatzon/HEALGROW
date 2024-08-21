<?php
session_start();
include 'db.php';

$conn = OpenCon();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form data
    $username = $_POST['username'];
    $lastname = $_POST['lastname'];
    $middlename = $_POST['middlename'];
    $firstname = $_POST['firstname'];
    $country = $_POST['country'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $entry_time = $_POST['entry-time'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO registration_data (username, lastname, middlename, firstname, country, mobile, email, role, entry_time, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $username, $lastname, $middlename, $firstname, $country, $mobile, $email, $role, $entry_time, $hashed_password);

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: home.html"); // Redirect to home page after successful registration
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    CloseCon($conn);
}
?>
