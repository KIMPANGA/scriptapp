<?php

// Include database configuration file
require_once 'db_config.php';

/* Validate and sanitize user input
if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
    $_SESSION['error'] = 'Please fill in all required fields.';
    header('Location: register.php');
    exit;
}*/

$devise = trim($_POST['devise']);
$descript = trim($_POST['descript']);
$montant = trim($_POST['montant']);
$Id_TYp_Trans = trim($_POST['Id_TYp_Trans']);
$code_membres = trim($_POST['code_membres']);
$code_agent = trim($_POST['code_agent']);

// Check if username and email already exist
try {
    // Connect to the database using PDO with prepared statements
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
try {
    $sql = "INSERT INTO `transaction`( `CODE_MEMBRE`, `ID_TYP_TRANS`, `CODE_AGENT`, `MONT_TRANS`, `DESCRIPT`, `DEVISE_TRANS`) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
    $code_membres,
    $Id_TYp_Trans,
    $code_agent,
    $montant,
    $descript,
    $devise]
);
echo "success";
}  catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
