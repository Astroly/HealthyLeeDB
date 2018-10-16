<?php
require '../../vendor/autoload.php';
$app = new Slim\App;


//Get All Products
$app->get('/api/Dealer', function ($request, $response) {
    header("Content-Type: application/json");
    getProducts();
});

//GET Single Product
$app->get('/api/Dealer/{ID_dealer}', function ($request, $response, $args) {
    return '{"data":"' . $args['ID_dealer'] . '"}'; 
});



function getProducts() {
    $sql = "select ID_dealer,
    name_dealer,
    lastname_Dealer,
    email_dealer,
    password_dealer,
    confirmPassword_dealer FROM Dealer";
      try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($products);
      }
      catch(PDOException $e) {
        echo json_encode($e->getMessage());
      }
    }
function getConnection() {
    $dbhost="sql12.freemysqlhosting.net";
    $dbuser="sql12261060";
    $dbpass="psUqblCd6I";
    $dbname="sql12261060";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);  
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}
$app->run();

?>