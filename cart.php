<?php
    //session_start(); 

    require_once("php/createDb.php");
    require_once("php/component.php");

    $db=new CreateDb("Productdb", "Producttb");

    if(isset($_POST['remove'])){
        if($_GET['action'] == 'remove'){
            foreach($_SESSION['cart'] as $key=>$value){
            if($value["product_id"]==$_GET['id']){
                unset($_SESSION['cart'][$key]);
                echo "<script>alert('Product has been remove.')</script>";
                echo "<script>window.location = 'cart.php</script>";
            }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css">
     <link rel="stylesheet" href="style.css">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body class="bg-light">
    <?php 
       require_once("php/header.php");

    ?>

    <div class="container-fluid">
        <div class="row px-5">
            <div class="col-md-7">
                <div class="shopping-cart">
                    <h6>My Cart</h6>
                    <hr>

                    <?php
                       $total = 0;
                       if(isset($_SESSION['cart'])){
                        $product_id = array_column($_SESSION['cart'], 'product_id');

                        $result = $db->getData();
                        while($row=mysqli_fetch_assoc($result)){
                            foreach($product_id as $id){
                                if($row['id'] == $id){
                                    cartElement($row['product_image'],$row['product_name'],$row['product_price'], $row['id']);
                                    $total = $total + (int)$row['product_price'];
                                }
                            }
                        }
                       } else{
                           echo "<h5>Cart is Empty</h5>";
                       }

                    ?>
                </div>
            </div>
            <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">
                <div class="pt-4">
                    <h6>PRICE DETAILS</h6>
                    <hr>

                    <div class="row price-details">
                        <div class="col-md-6">
                            <?php 
                            
                               if(isset($_SESSION['cart'])){
                                   $count = count($_SESSION['cart']);
                                   echo "<h6>Price ($count items)</h6>";
                               } else {
                                   echo "<h6>Price (0 items)</h6>";
                               }
                            ?>

                            <h6>Delivery Charges</h6>
                            <hr>
                            <h6>Amount Payable</h6>
                        </div>
                        <div class="col-md-6">
                            <h6>UGX. <?php echo $total; ?></h6>
                            <h6 class="text-success">FREE</h6>
                            <hr>
                            <h6>UGX. <?php echo $total; ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    
</body>
</html>