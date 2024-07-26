<?php

// Include database configuration file
require_once 'db_config.php';

if(isset($_POST['email_agent']) && isset($_POST['mot_passe_agent'])){
    $email_agent=$_POST['email_agent'];
    $mot_passe_agent=$_POST['mot_passe_agent'];
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare a SQL statement to prevent SQL injection
    $sql = "UPDATE agent SET MOT_PASSE_AGENT=:motPasse WHERE EMAIL_AGENT=:email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":motPasse",$mot_passe_agent);
    $stmt->bindParam(":email",$email_agent);
    // Execute the statement
   $user= $stmt->execute();
   if($user!=0){
    echo "success";
   }else{
    echo "echec";
   }
}else{
    echo "Response 404";
}