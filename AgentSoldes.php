<?php
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

function Solde_dollars($code_agent){

}
function Solde_Francs($code_agent){
    
}