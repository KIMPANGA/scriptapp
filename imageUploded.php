<?php

// Include database configuration file
require_once 'db_config.php';

if(isset($_POST['images'])){
    $code_agent=$_POST['code_agent'];
    $nom_agent=$_POST['nom_agent'];
    $target_path="images/";
    $image=$_POST['images'];
    $ImageStore=$nom_agent.rand()."-".time().".jpeg";
    $target_path=$target_path."/".$ImageStore;
    file_put_contents($target_path,base64_decode($image));

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare a SQL statement to prevent SQL injection
    $sql = "UPDATE agent SET PHOTO_AGENT=:photo WHERE CODE_AGENT=:code";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":photo",$ImageStore);
    $stmt->bindParam(":code",$code_agent);
    // Execute the statement
    $stmt->execute();
    
    if($stmt){
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
       
    }else{
        echo "error";
    }
    
}