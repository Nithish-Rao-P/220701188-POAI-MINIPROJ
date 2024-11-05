<?php
// Start the session
session_start();

$servername = "localhost";
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "typewriting_test_db"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the WPM and Accuracy are posted
if (isset($_POST['wpm']) && isset($_POST['accuracy'])) {
    // Store them in session variables
    $_SESSION['wpm'] = $_POST['wpm'];
    $_SESSION['accuracy'] = $_POST['accuracy'];
    $wpm = $_SESSION['wpm'];
    $accuracy = $_SESSION['accuracy'];

    // Check if a username is set in the session
    if (isset($_SESSION['username'])) {
        $user = $_SESSION['username'];
        
        $sql = "INSERT INTO leaderboard (username, wpm, accuracy) 
                VALUES ('$user', '$wpm', '$accuracy')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to index.php if registration is successful
            header('Location: index.php');
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "No username found in the session!";
    }
} else {
    // If the values are not set, handle the error accordingly
    echo "No WPM or Accuracy received!";
}
?>
