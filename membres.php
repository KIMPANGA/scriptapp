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
    $sql_user = "INSERT INTO users ( `ID_CODE`, `NOM`, `PRENOM`, `ADRESSE`, `TELEPHONE`, `EMAIL`,'PHOTO', `SEXE`,''MOT_PASSE'`) VALUES (?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql_user);
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
if($conn->query($sql_user)===TRUE){
    $last_user_id=$conn->insert_id ;
    echo "utilisateur ajouté avec succes.ID_CODE:".$last_user_id."<br>";

}else{
    echo"erreur de la création d'utilisateur"
}
// Insertion d'un nouvel agent

try {
    $sql_agent = "INSERT INTO agent (`ID_CODE`,DATE_NAIS `) VALUES (?,?)";
    $stmt_agent = $conn->prepare($sql_agent);
    $stmt_agent ->bind_param('i', $last_user_id);
    if($stmt_agent->execute()){
        $last_user_id=$stmt_agent->insert_id;

    }
echo "Nouvel agent inseré avec succes.CODE_AGENT:".$last_agent_id."<br> ";
}  catch(PDOException $e) {
    echo "Erreur lors de la création d'un agent: " . $e->getMessage();
}


// Insertion d'un nouvel membre

try {
    $sql_membre = "INSERT INTO membre (`CODE_MEMBRE`,ADRESSE_ACT,TYPEACT, `) VALUES (?,?,?)";
    $stmt_membre = $conn->prepare($sql_membre);
    $stmt_membre ->bind_param('i', $last_user_id);
    ifr( $stmt_membre->execute)

    if($stmt_membre->execute()){
        $last_user_id=$stmt_membre->insert_id;

    }
echo "Nouvel membre inseré avec succes.CODE_MEMBRE:".$last_membre_id."<br> ";
}  catch(PDOException $e) {
    echo "Erreur lors de la création d'un membre: " . $e->getMessage();
}







$sql_trans= "SELECT * FROM type_transaction WHERE 1";
$stmt_typ_trans = $conn->prepare($sql_trans);
$stmt_typ_trans->execute();
$username_count = $stmt_typ_trans->fetchAll(PDO::FETCH_ASSOC);
$trans=array();

if($stmt!=0){
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
}else{
    echo "echec";
}
}  catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
  

    