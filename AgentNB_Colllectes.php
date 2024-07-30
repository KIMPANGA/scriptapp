<?php

require_once 'db_config.php';
try {
    $code_agent=$_POST['code_agent'];
    // Connect to the database using PDO with prepared statements
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // Connect to the database using PDO with prepared statements
    // Prepare SQL statements to check for existing user
    $sql_ag = "SELECT COUNT(tr.CODE_MEMBRE) as nbCol FROM `transaction` as tr inner join agent as ag inner join membre as mb WHERE ag.CODE_AGENT like tr.CODE_AGENT and mb.CODE_MEMBRE like tr.CODE_MEMBRE and tr.CODE_AGENT like ?";
    $stmt_ag = $conn->prepare($sql_ag);
    $stmt_ag->execute([$code_agent]);
    $username_ag = $stmt_ag->fetch(PDO::FETCH_ASSOC);
    $col="";
    foreach ($username_ag as $value) {
        $col=$username_ag['nbCol'];
        # code...
    }
    echo $col;

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
     

