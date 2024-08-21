<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adviceID = $_POST['adviceID'];
    $userID = $_POST['userID'];
    $date = $_POST['date'];
    $content = $_POST['content'];

    $sql = "INSERT INTO nutrition_advice (adviceID, userID, date, content) 
            VALUES ($adviceID, $userID, '$date', '$content')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
