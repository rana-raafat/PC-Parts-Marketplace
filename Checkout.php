<html>
    <head>
        <link rel="stylesheet" href="Style.css">
        <title> Checkout </title>
    </head>
    <body>

<?php
//
session_start();
include "Menu.php";
if(isset($_POST['goback'])){
    echo "<script>window.location.href='cart.php'</script>";
}
$con = new mysqli("localhost", "root", "", "project");

if(!$con){
    echo "connection error<br>";
    die();    
}
?>
<div class='container'>
                        <div class='card justify-content-center'>
                            <div class="shoppingCart">
                                <div class="cart-items">
<?php
echo "Name: ". $_SESSION['username']."<br>";
echo "Address: " . $_SESSION['address']."<br>";
?>

<form method='post'class="form-horizontal">

<?php
$totalPrice=0;
$sql= "SELECT  * FROM `cartitem` WHERE `customerID`='". $_SESSION['id']."'";
$result = mysqli_query($con,$sql);

while($row = $result->fetch_assoc()){
$sql2="SELECT  `price` FROM `product` WHERE `id`='". $row['productID']."'";
$result2=mysqli_query($con,$sql2);
$row2=$result2->fetch_assoc();

}$totalPrice=$_GET['total'];
echo " <br>Total Price: $totalPrice <br><br>";
if(isset($_POST["purchasecomplete"])){
    $sql4= "UPDATE `orders` SET `completed`='1' WHERE `customerID`='". $_SESSION['id']."'";
    $result4 = mysqli_query($con,$sql4);
    
    echo"<br>Products Bought Successfully<br>";
    
    $sql5= "INSERT INTO `orders`( `customerID`, `numberOfProducts`, `completed`) VALUES ('". $_SESSION['id']."','0','0')";
    $result5 = mysqli_query($con,$sql5);
    if(!$result5){
        echo "error creating a new order<br>";
    }
    else{
        echo "<script>window.location.href='Home.php'</script>";
    }
    
}

?>
<button name="purchasecomplete">Confirm Purchase</button>

<button name='goback'>Negate Purchase</button></form>
</div>
</div>
</div>
</div>

    </body>
</html>