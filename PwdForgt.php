<?php

// Include database configuration file
require_once 'db_config.php';

/* Validate and sanitize user input
if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
    $_SESSION['error'] = 'Please fill in all required fields.';
    header('Location: register.php');
    exit;
}*/

$email_agent = trim($_POST['email_agent']);

// Check if username and email already exist
try {
    // Connect to the database using PDO with prepared statements
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statements to check for existing user
    $sql_username = "SELECT * FROM agent WHERE EMAIL_AGENT = ?";
    $stmt_username = $conn->prepare($sql_username);
    $stmt_username->execute([$email_agent]);
    $username_count = $stmt_username->fetchAll(PDO::FETCH_ASSOC);
    if(count($username_count)!=0)
    {
        echo "success";
    }else{
        echo "echec";
    }


} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}