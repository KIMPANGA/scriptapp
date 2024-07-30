<?php

// Include database configuration file
require_once 'db_config.php';



// Check if username and email already exist
try {
    // Connect to the database using PDO with prepared statements
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$sql_trans= "SELECT * FROM type_transaction WHERE 1";
$stmt_typ_trans = $conn->prepare($sql_trans);
$stmt_typ_trans->execute();
$username_count = $stmt_typ_trans->fetchAll(PDO::FETCH_ASSOC);
$trans=array();

    if($username_count!=null)
    {
    
        foreach($username_count as $type)
        {
            $temp=array();
            $temp['type_trans']=$type['ID_TYP_TRANS'];
            $temp['libelle']=$type['LIBELLE_'];
            array_push($trans,$temp);
        }
    echo json_encode($trans);
    }else{
    echo "echec";
    }
