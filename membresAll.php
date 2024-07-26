<?php

// Include database configuration file
require_once 'db_config.php';
$code_agent="0EDHOSTW";
try {
    // Connect to the database using PDO with prepared statements
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statements to check for existing user
    $sql_username = "SELECT CODE_AGENT, NOM_AGENT, PRENOM_AGENT, TELEPHONE_AGENT, ADRESSE_AGENT, PHOTO_AGENT, EMAIL_AGENT, SEXE_AGENT, MOT_PASSE_AGENT, ROLES FROM agent WHERE CODE_AGENT=:code_agent ";
    $stmt_username = $conn->prepare($sql_username);
    $stmt_username->bindParam(":code_agent",$code_agent);
    $stmt_username->execute();
    $username_count = $stmt_username->fetchAll(PDO::FETCH_ASSOC);
    $membres=array();

    foreach ($username_count as $val) {
        # code...
        $temp=array();
        $temp['code_agent']=$val['CODE_AGENT'];
        $temp['nom_agent']=$val['NOM_AGENT'];
        $temp['prenom_agent']=$val['PRENOM_AGENT'];
        $temp['telephone_agent']=$val['TELEPHONE_AGENT'];
        $temp['adresse_agent']=$val['ADRESSE_AGENT'];
        $temp['photo_agent']=$val['PHOTO_AGENT'];
        $temp['email_agent']=$val['EMAIL_AGENT'];
        array_push($membres,$temp);
    }
    echo json_encode($membres);


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

// Insert new user