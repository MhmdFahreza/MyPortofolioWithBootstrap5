<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$servername = "127.0.0.1";
$username = "your_username";
$password = "your_password";
$dbname = "webporto";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO formporto (Nama, Email, No_Telepon, Subject, Pesan) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    
    $bind = $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);
    if ($bind === false) {
        die("Bind failed: " . $stmt->error);
    }

    // Execute the statement
    $exec = $stmt->execute();
    if ($exec === false) {
        die("Execute failed: " . $stmt->error);
    } else {
        echo "Message sent successfully!";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "No form data received.";
}

