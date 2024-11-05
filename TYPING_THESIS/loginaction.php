<?php
session_start();
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "typewriting_test_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form values
$user = $_POST['loginemail'];
$pass = $_POST['loginpassword'];

// Check if username exists
$sql = "SELECT * FROM user_registration WHERE  username='$user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Verify the password
    
    if (password_verify($pass, $row['password'])) {
        $_SESSION['username'] = $user;
        // Redirect to home.html if login is successful
        header('Location: index.php');
        exit();
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No user found with that username.";
}

$conn->close();
?>