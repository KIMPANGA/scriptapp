<?php

// Include database configuration file
require_once 'db_config.php';
try {
    // Connect to the database using PDO with prepared statements
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statements to check for existing user
    $sql_username = "SELECT `CODE_MEMBRE`, `NOM_MB`, `PRENOM_MB`, `ADRESSE_ACT`, `TYPEACT`, `ADRESSE_DOM`, `TELEPHONE_MB`, `EMAIL_MB`, `PHOTO_MB`, `SEXE`, `MOT_PASSE_MB`, CREATED_AT FROM membre ";
    $stmt_username = $conn->prepare($sql_username);
    $stmt_username->execute();
    $username_count = $stmt_username->fetchAll(PDO::FETCH_ASSOC);
    $membres=array();

    foreach ($username_count as $val) {
        # code...
        $temp=array();
        $temp['code_membre']=$val['CODE_MEMBRE'];
        $temp['nom_mb']=$val['NOM_MB'];
        $temp['prenom_mb']=$val['PRENOM_MB'];
        $temp['type_act']=$val['ADRESSE_ACT'];
        $temp['adresse_dom']=$val['ADRESSE_DOM'];
        $temp['tel_mb']=$val['TYPEACT'];
        $temp['email_mb']=$val['ADRESSE_DOM'];
        $temp['sexe_mb']=$val['EMAIL_MB'];
        $temp['date_mb']=$val['CREATED_AT'];
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