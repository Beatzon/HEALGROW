<?php
session_start();
include 'db.php';

$conn = OpenCon();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username and password are set
    if (!isset($username) || !isset($password)) {
        echo "Username or password not set.";
        exit();
    }

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            header("Location: home.html");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No user found with that username.";
    }

    $stmt->close();
    CloseCon($conn);
}
?>
