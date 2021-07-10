<?php 
   require_once('php/createDb.php');
   require_once("./php/component.php");

   //create instance of createdb class
   $database=new CreateDb("Productdb", "producttb");

   if(isset($_POST['add'])){
       //print_r($_POST['product_id']);
       if(isset($_SESSION['cart'])){
           $item_array_id = array_column($_SESSION['cart'], "product_id");
           

           if(in_array($_POST['product_id'], $item_array_id)){
               echo "<script>alert('Product is already added in the Cart')</script>";
               echo "<script>window.allocation='index.php'<\script>";
           } else {
               $count = count($_SESSION['cart']);
               $item_array =array(
                'product_id'=>$_POST['product_id']
            );
            $_SESSION['cart'][$count] = $item_array;
           }

       }else {
           $item_array =array(
               'product_id'=>$_POST['product_id']
           );

           //create new session Variable
           $_SESSION['cart'][0]=$item_array;
           print_r($_SESSION['cart']);
       }

   }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Shopping</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css">
     <link rel="stylesheet" href="style.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<h1 style="text-align:center"> Welcome to Muzahura's Online Shopping Center</h1>
        <h6 style="text-align:center; color:blue"><i>ALL THE CLASSIC ITEMS YOU NEED</i></h6>
    <?php require_once("php/header.php"); ?>
    <div class="container">
        <div class="row text-center py-5">
            <?php 
               $result = $database->getData();
               while($row=mysqli_fetch_assoc($result)){
                   component($row['product_name'], $row['product_price'], $row['product_image'], $row['id']);
               }
            ?>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
</body>
</html>