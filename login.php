<?php

// Include database configuration file
require_once 'db_config.php';


$email_agent = trim($_POST['email_agent']);
$mot_passe_agent = trim($_POST['mot_passe_agent']);

try {
    // Connect to the database using PDO with prepared statements
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare a SQL statement to prevent SQL injection
    $sql = "SELECT CODE_AGENT, NOM_AGENT, PRENOM_AGENT, TELEPHONE_AGENT, ADRESSE_AGENT, PHOTO_AGENT, EMAIL_AGENT, SEXE_AGENT, MOT_PASSE_AGENT, ROLES FROM agent WHERE email_agent = ? and mot_passe_agent= ? ";
    $stmt = $conn->prepare($sql);
    // Execute the statement
    $stmt->execute([$email_agent,$mot_passe_agent]);
    // Check if a user with the provided username exists
    $user = "";
    $username_count=$stmt->fetchAll(PDO::FETCH_ASSOC);
    if(count($username_count)!=0){
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
    }else{
        
        echo "L'utilisateur n'existe pas , veuillez cree un nouveau compte !!!";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null; // Close connection
  