<?php

// Include database configuration file
require_once 'db_config.php';

/* Validate and sanitize user input
if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
    $_SESSION['error'] = 'Please fill in all required fields.';
    header('Location: register.php');
    exit;
}*/

$tel_mb = trim($_POST['tel_mb']);
$Mail_mb = trim($_POST['Mail_mb']);
$nom_mb = trim($_POST['nom_mb']);
$prenom_mb = trim($_POST['Prenom_mb']);
$sexe_mb = trim($_POST['sexe_mb']);
$adresseAct_mb = trim($_POST['adresseAct_mb']);
$acty_mb = trim($_POST['acty_mb']);
$adress_DOM_mb = trim($_POST['adress_DOM_mb']);
$Code_membre = trim($_POST['Code_membre']);

// Check if username and email already exist
try {
    // Connect to the database using PDO with prepared statements
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statements to check for existing user
    $sql_username = "SELECT COUNT(*) FROM membre WHERE 1";
    $stmt_username = $conn->prepare($sql_username);
    $stmt_username->execute();
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
    $sql = "INSERT INTO membre ( `CODE_MEMBRE`, `NOM_MB`, `PRENOM_MB`, `ADRESSE_ACT`, `TYPEACT`, `ADRESSE_DOM`, `TELEPHONE_MB`, `EMAIL_MB`, `SEXE`) VALUES (?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
    $Code_membre,
    $nom_mb,
    $prenom_mb,
    $adresseAct_mb,
    $acty_mb,
    $tel_mb,
    $adress_DOM_mb,
    $Mail_mb,
 $sexe_mb]
);
if($stmt!=0){

    echo "success";
}else{
    echo "echec";
}
}  catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
  

    