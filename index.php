<?php

require './vendor/autoload.php';


$app = new \Slim\App;

// $app->get('/', function ($request, $response) {
//     return 'hello world';
// });

// $app->get('/api/', function ($request, $response) {
//     return 'hello world';
// });


//Get All Products
$app->get('/api/Dealer/', function($request, $response){

    
    // $sql = "SELECT productID,title,description,price,pic FROM product";
    $sql = "SELECT * FROM Dealer";

    try{
        //Get DB Object
        $mysql = new db();
        //Connect
        $db = $mysql->connect();

        $stmt = $db->prepare($sql);
        $stmt.execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return json_encode($products);

        $db = null;
        // var_dump($products);
        

    }catch(PDOException $e){
        return '{"error": {"text": '.$e->getMessage().'}';
    }
});

//GET Single Product
$app->get('/api/Dealer/{ID_dealer}',function(Request $request, Response $response){
    $id = $request ->getAttribute('ID_dealer');
    $sql = "SELECT * FROM Dealer WHERE ID_dealer = $id";
    
    try {
        $db = new db();
        $db = $db->connect();

         $stmt =$db->query($sql);

        $product = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($product);
    }catch(PDOException $e){
        echo'{"error":{"text":}'.$e->getMessage().'}';
    }
});

//Add Products

$app->post('/api/Dealer/add',function(Request $request, Response $response) {

    $ID_dealer = $request->getParam('ID_dealer') ;
    $name_dealer = $request->getParam('name_dealer') ;
    $lastname_Dealer = $request->getParam('lastname_Dealer') ;
    $email_dealer = $request->getParam('email_dealer') ;
    $password_dealer = $request->getParam('password_dealer') ;
    $confirmPassword_dealer = $request->getParam('confirmPassword_dealer') ;



    $sql ="INSERT INTO product (ID_dealer,
    name_dealer,
    lastname_Deale,
    email_dealer,
    password_dealer,
    confirmPassword_dealer) VALUES (:ID_dealer,
:name_dealer,
:email_dealer,
:password_dealer,
:confirmPassword_dealer)" ;

    try {

        //get DB object

        // $db = new db() ;

        //connect

        // $db = $db->connect() ;

        $db = getConnection();

        $stmt = $db->prepare($sql) ;


        $stmt->bindParam(':ID_dealer,',    $ID_dealer) ;
        $stmt->bindParam(':name_dealer,',     $name_dealer) ;
        $stmt->bindParam(':lastname_dealer,',     $lastname_deale) ;
        $stmt->bindParam(':email_dealer,',    $email_dealer) ;
        $stmt->bindParam(':password_dealer,',    $password_dealer) ;
        $stmt->bindParam(':confirmPassword_dealer',    $confirmPassword_dealer) ;



        $stmt->execute() ;

        echo '{"notice: {"text": "Product Add"}' ;



    } catch(PDOExcaption $e) {

            echo '{"error":{"text": '.$e->getMessage().'}' ;

    }

});



//Update Products

$app->put('/api/Dealer/update/{ID_dealer}',function(Request $request, Response $response) {

    $ID_dealer = $request->getParam('ID_dealer') ;
    $name_dealer = $request->getParam('name_dealer') ;
    $lastname_Dealer = $request->getParam('lastname_Dealer') ;
    $email_dealer = $request->getParam('email_dealer') ;
    $password_dealer = $request->getParam('password_dealer') ;
    $confirmPassword_dealer = $request->getParam('confirmPassword_dealer') ;


    $sql = "UPDATE product SET
            name_dealer,
    lastname_Deale,
    email_dealer,
    password_dealer,
    confirmPassword_dealer
             WHERE ID_dealer=$id" ;
    try{

        //Get DB Object
       // $db = new db() ;
        // Connect

       // $db = $db->connect() ;

       $db = getConnection();

        $stmt = $db->prepare($sql) ;


        $stmt->bindParam(':ID_dealer',    $ID_dealer) ;

        $ID_dealer = $request->getParam('ID_dealer') ;
    $name_dealer = $request->getParam('name_dealer') ;
    $lastname_Dealer = $request->getParam('lastname_Dealer') ;
    $email_dealer = $request->getParam('email_dealer') ;
    $password_dealer = $request->getParam('password_dealer') ;
    $confirmPassword_dealer = $request->getParam('confirmPassword_dealer') ;


        $stmt->execute() ;

        echo '{"notice": {"text": "Product Update"}' ;



    } catch(PODExution $e) {

        echo '{"error": {"text": '.$e->getMessage().'}' ;

    }

});



//Delete Product

$app->delete('/api/product/delete/{ID_dealer}', function(Request $request, Response $response){

    $id = $request->getAttribute('ID_dealer');

    $sql = "DELETE FROM Dealer WHERE ID_dealer=$id";

    try{

        //Get DB Object

        $db = new db();

        //connect

        $db = $db->connect();



        $stmt = $db->prepare($sql);

        $stmt->execute();

        $db = null;

        echo '{"notice": {"text": "Product Deleted"}';



    }  catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';

    }



});
require './db.php';
$app->run();

?>