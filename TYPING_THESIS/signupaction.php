<?php
session_start();
// Database connection
$servername = "localhost";
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "typewriting_test_db"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form values
$user = $_POST['signupname'];
$pass = $_POST['signuppassword'];
$email =$_POST['signupemail'];

// Check if username already exists
$sql = "SELECT * FROM user_registration WHERE username='$user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Username already exists.";
} else {
    // Hash password for security
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
    
    // Insert user into the database
    $sql = "INSERT INTO user_registration (username, password, email) 
        VALUES ('$user', '$hashed_password', '$email')";
    
    if ($conn->query($sql) === TRUE) {  
        $_SESSION['username'] = $user;
        // Redirect to home.html if registration is successful
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>