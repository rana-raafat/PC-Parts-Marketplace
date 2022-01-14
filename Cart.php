<html>
    <head>
        <title>Cart</title>
    </head>
    <body>
    <?php 
        session_start();
        include "Menu.php";
        
        if(isset($_SESSION['id'])){
            if($_SESSION['userType']!='customer'){
                echo "Your account does not have this privilege<br>";
            }
            else{
                $con = new mysqli("localhost", "root", "", "project");
                if(!$con){ //exception?
                    echo "connection error<br>";
                    die();
                }

                $totalPrice=0;
                $orderIDsql = "SELECT orderID FROM orders WHERE customerID='" . $_SESSION['id'] . "' AND completed='0'";
                $orderIDresult = $con->query($orderIDsql);//not tested
                if($orderIDresult->num_rows == 0){
                    echo "Error: order not found<br>";
                }
                else if($orderRow = $orderIDresult->fetch_assoc()){
                    $sql= "SELECT * FROM cartitem WHERE customerID='". $_SESSION['id'] . "' AND orderID='" . $orderRow['orderID'] . "'";
                    $result = mysqli_query($con,$sql);	
                    
                    if (!$result) { //exception here
                        printf("Error: %s\n", mysqli_error($con));
                        exit();
                    }
                    echo "<div class='container'>";
                    echo "<table border=2 class='table table-striped'>";
                    echo "<thead><tr><th>Image</th><th>Name</th> <th>Price</th> <th>Amount</th></tr></thead><tbody>";
                    while($row=$result->fetch_assoc()){
                        $productsql= "SELECT * FROM product WHERE id='". $row['productID'] . "'";
                        $productResult = mysqli_query($con,$productsql);	
                        
                        if($productResult->num_rows == 0){
                            echo "Error: Product not found<br>";
                        }
                        else if($prodRow = $productResult->fetch_assoc()){ 
                            $totalPrice+=$prodRow['price'];
                            $image= "<img src='" . $prodRow['imagePath'] ."' height=50 width=50>";
                            $name="<a href='DisplayProduct.php?id=" . $prodRow['id'] . "'>" . $prodRow['name'] . "</a><br>";
                            echo "<tr><td>" . $image . "</td> <td>" .  $name . "</td> <td>" . $prodRow['price'] . "</td> <td>" . $row['amount'] . "</td></tr>";
                        }
                        
                    }
                    echo "</tbody></table> </div>";
                    echo "<b>Total price:</b>" . $totalPrice." "; 
                    echo "<a href='Checkout.php?total=" . $totalPrice . "'><button type='submit' name='checkout' value='checkout'>Checkout</button></a>";
                    $con->close();
                }
            }
        }
        else{
            echo "Error: please log in to view your cart<br>";
        }
    ?>
    
    </body>
</html>