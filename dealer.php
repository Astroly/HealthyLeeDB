<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
require './vendor/autoload.php';
$app = new Slim\App;
//test
$app->get('/api/test', function ($request, $response) {
    return 'hello world';
});
//getAll
$app->get('/api/Dealer', function ($request, $response) {
    header("Content-Type: application/json");
    getProducts();
});
//getByID
$app->get('/api/Dealer/{ID_dealer}', function ($request, $response, $args) {
    header("Content-Type: application/json");

    $sql = "SELECT * FROM Dealer where ID_dealer =  ('".$args['ID_dealer']."')";
    
    try {
        $db = getConnection();
        $stmt =$db->query($sql);
        $product = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($product);
    }catch(PDOException $e){
        echo'{"error":{"text":}'.$e->getMessage().'}';
    }
});

//POST ...ADD
  $app->post('/api/Dealer/', function ($request, $response) {
    header("Content-Type: application/json");
    $ID_dealer = $request->getParam('ID_dealer') ;
    $name_dealer = $request->getParam('name_dealer') ;
    $lastname_Dealer = $request->getParam('lastname_Dealer') ;
    $email_dealer = $request->getParam('email_dealer') ;
    $password_dealer = $request->getParam('password_dealer') ;
    $confirmPassword_dealer = $request->getParam('confirmPassword_dealer') ;
     
try {
    $db = getConnection();
    
    $sql="INSERT INTO product (ID_dealer,
    name_dealer,
    lastname_Deale,
    email_dealer,
    password_dealer,
    confirmPassword_dealer)
    VALUES ('" .$ID_dealer."','" .$name_dealer."','" .$lastname_Deale."' ,'" .$email_dealer."','" .$password_dealer."','" .$confirmPassword_dealer."')";
    $stmt = $db->query($sql);
    $db = null;
    return '{"status" : "ADD Success" }';
} catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}';
}

});

//PUT...UPDATE
 $app->put('/api/Dealer/{ID_dealer}',function($request, $response, $args) {
    header("Content-Type: application/json");
   // header("Content-Type: application/json");
    
   $ID_dealer = $request->getParam('ID_dealer') ;
   $name_dealer = $request->getParam('name_dealer') ;
   $lastname_Dealer = $request->getParam('lastname_Dealer') ;
   $email_dealer = $request->getParam('email_dealer') ;
   $password_dealer = $request->getParam('password_dealer') ;
   $confirmPassword_dealer = $request->getParam('confirmPassword_dealer') ;
    

try{
 $db = getConnection();  
$sql="UPDATE product SET
    name_dealer=('".$name_dealer."'),
    lastname_Deale=('".$lastname_Deale."'),
    email_dealer=('".$email_dealer."'),
    password_dealer=('".$password_dealer."'),
    confirmPassword_dealer=('".$confirmPassword_dealer."')
    
     WHERE ID_dealer= ('".$args['ID_dealer']."') " ;  
$stmt = $db->query($sql);
 $db = null;

return '{"status" : "UPDATE Success" }';
  } catch(PDOException $e) {
      echo '{"error":{"text":'. $e->getMessage() .'}}';
  }
   
});

//Delete
$app->delete('/api/Dealer/delete/{ID_dealer}', function($request, $response, $args) {
    header("Content-Type: application/json");

    $sql = "DELETE FROM Dealer WHERE ID_dealer = ('".$args['ID_dealer']."')";
    
    try {
        $db = getConnection();
        $stmt =$db->query($sql);
        $product = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"notice": {"text": "Product Deleted"}';
    }catch(PDOException $e){
        echo json_encode($e->getMessage("Product Deleted"));
    }
});





$app->run();


function getProducts() {
    $sql = "SELECT * FROM Dealer";
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
?>