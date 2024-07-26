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
$mot_passe_agent = trim($_POST['mot_passe_agent']);
$nom_agent = trim($_POST['nom_users']);
$prenom_agent = trim($_POST['Prenom_users']);
$sexe_agent = trim($_POST['sexe_agent']);
$telephone_agent = trim($_POST['telephone_agent']);
$adresse_agent = trim($_POST['adresse_agent']);
$code_agent = trim($_POST['Code_agent']);

// Check if username and email already exist
try {
    // Connect to the database using PDO with prepared statements
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statements to check for existing user
    $sql_username = "SELECT COUNT(*) FROM agent WHERE EMAIL_AGENT = ? and MOT_PASSE_AGENT=?";
    $stmt_username = $conn->prepare($sql_username);
    $stmt_username->execute([$email_agent,$mot_passe_agent]);
    $username_count = $stmt_username->fetch(PDO::FETCH_ASSOC);


} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

/* Check if passwords match
if ($password != $confirm_password) {
    $_SESSION['error'] = "Passwords do not match.";
    header('Location: register.php');
    exit;
}*/

/*Password Hashing (Use a strong hashing algorithm like bcrypt)
$password_hash = password_hash($password, PASSWORD_DEFAULT); Use PASSWORD_DEFAULT or a higher algorithm */ 

// Insert new user into the database
try {
    $sql = "INSERT INTO agent (`CODE_AGENT`, `NOM_AGENT`, `PRENOM_AGENT`, `TELEPHONE_AGENT`, `ADRESSE_AGENT`, `PHOTO_AGENT`, `EMAIL_AGENT`, `SEXE_AGENT`, `MOT_PASSE_AGENT`) VALUES (?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
    $code_agent,
    $nom_agent,
    $prenom_agent,
    $telephone_agent,
    $adresse_agent,
    "photo1",
    $email_agent,
    $sexe_agent,
    $mot_passe_agent]
);
echo "success";
}  catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
  

    
