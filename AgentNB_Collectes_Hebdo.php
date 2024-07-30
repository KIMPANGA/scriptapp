

<?php

require_once 'db_config.php';
try {
    $code_agent=$_POST['code_agent'];
    $devise=$_POST['devise'];
    // Connect to the database using PDO with prepared statements
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // Connect to the database using PDO with prepared statements
    // Prepare SQL statements to check for existing user
    $sql_ag = "SELECT COUNT(tr.CODE_MEMBRE) as nbCol, SUM(MONT_TRANS) as mont_hebdo FROM `transaction` as tr inner join agent as ag inner join membre as mb WHERE ag.CODE_AGENT like tr.CODE_AGENT and mb.CODE_MEMBRE like tr.CODE_MEMBRE and tr.CODE_AGENT like ? and CREATED_TRANS BETWEEN CREATED_TRANS and DATE_ADD(CREATED_TRANS,INTERVAL 7 DAY) and DEVISE_TRANS=?";
    $stmt_ag = $conn->prepare($sql_ag);
    $stmt_ag->execute([$code_agent,$devise]);
    $username_ag = $stmt_ag->fetch(PDO::FETCH_ASSOC);
    $colJrn=array();
    foreach ($username_ag as $value) {
        $temp=array();

        $temp['nbCol']=$username_ag['nbCol'];
        $temp['mont_gen']=$username_ag['mont_hebdo'];
        # code...
        array_push($colJrn,$temp);
    }
    echo json_encode($colJrn);

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}