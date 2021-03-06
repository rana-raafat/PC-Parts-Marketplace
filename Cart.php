<html>
    <head>
        <title>Cart</title>
    </head>
    <body>
    <?php 
        session_start();
        include "Menu.php";
        
        function dbException($queryResult){
            if(!$queryResult){
                throw new Exception("SQL Error");
            }
            return true;
        }

        if(isset($_SESSION['id'])){
            if($_SESSION['userType']!='customer'){
                echo "Your account does not have this privilege<br>";
            }
            else{
                $con = new mysqli("localhost", "root", "", "project");
                if(!$con){
                    echo "connection error<br>";
                    die();
                }
                

                $totalPrice=0;
                $orderIDsql = "SELECT orderID FROM orders WHERE customerID='" . $_SESSION['id'] . "' AND completed='0'";
                $orderIDresult = $con->query($orderIDsql);
                if($orderIDresult->num_rows == 0){
                    echo "Error: order not found<br>";
                }
                else if($orderRow = $orderIDresult->fetch_assoc()){
                    $sql= "SELECT * FROM cartitem WHERE customerID='". $_SESSION['id'] . "' AND orderID='" . $orderRow['orderID'] . "'";
                    $result = mysqli_query($con,$sql);	
                    
                    try{
                        dbException($result);
                    }
                    catch(Exception $e){
                        printf("Database Error: %s\n", mysqli_error($con));
                        die();
                    }
                    ?>
                    <div class='container'>
                        <div class='card'>
                            <div class="shoppingCart">

                                <div class="cart-items">
                                    <table class="table">
                                        <thead><tr><th>Image</th><th>Name</th> <th>Price</th> <th>Amount</th><th></th></tr></thead>
                                        <tbody>
                                            <?php            
                                            while($row=$result->fetch_assoc()){
                                                echo "<form method='POST' action=''>";
                                                    echo "<input type='hidden' name='orderID' value=" . $row['orderID'] . ">";      
                                                    $productsql= "SELECT * FROM product WHERE id='". $row['productID'] . "'";
                                                    $productResult = mysqli_query($con,$productsql);	
                                                    try{
                                                        dbException($productResult);
                                                    }
                                                    catch(Exception $e){
                                                        printf("Database Error: %s\n", mysqli_error($con));
                                                        //die();
                                                    }
                                                    if($productResult->num_rows == 0){
                                                        echo "Product not found<br>";
                                                    }
                                                    else if($prodRow = $productResult->fetch_assoc()){ 
                                                        $crt="SELECT * FROM cartitem WHERE orderID='" . $row['orderID']  ."' AND productID='" . $row['productID'] ."'";
                                                        $crtResult = mysqli_query($con,$crt);
                                                        try{
                                                            dbException($crtResult);
                                                        }
                                                        catch(Exception $e){
                                                            printf("Database Error: %s\n", mysqli_error($con));
                                                            die();
                                                        }
                                                        $crtrow=$crtResult->fetch_assoc();
                                                        
                                                        $totalPrice += $prodRow['price']*$crtrow['amount'];
                                                        
                                                        echo "<input type='hidden' name='productID' value=" . $prodRow['id'] . ">";  
                                                        echo "<tr>";
                                                            echo "<td>";
                                                                echo "<img src='" . $prodRow['imagePath'] ."' height=75 width=75>";
                                                            echo "</td>";
                                                            echo "<td>";
                                                                echo "<a href='DisplayProduct.php?id=" . $prodRow['id'] . "'>" . $prodRow['name'] . "</a>";
                                                            echo "</td>";
                                                            echo "<td>";
                                                                echo $prodRow['price'];
                                                            echo "</td>";
                                                            echo "<td>";
                                                                echo "<input type='number' class='form-control text-center' name='amount' value=". $row['amount'] ." min=1>";
                                                            echo "</td>";
                                                            ?>
                                                            <td>
                                                                <div class='cart-actions'>
                                                                    <button type='submit' name='update'>
                                                                        <i class="glyphicon glyphicon-refresh"></i> 
                                                                        Update
                                                                    </button>
                                                                    <button type='submit' name='delete'>
                                                                        <i class="glyphicon glyphicon-trash"></i>
                                                                        Delete
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        <?php
                                                        echo "</tr>";
                                                    echo "</form>";
                                                }                
                                            }
                                        echo "</tbody>";
                                    echo "</table>";
                                echo "</div>";


                                echo "<text class='header'> Total price: </text>" . $totalPrice;
                                if($totalPrice>0){
                                echo "<br><form action='Checkout.php' method='post'>"; 
                                    echo "<button type='submit' name='total' value='" . $totalPrice ."'>Checkout</button>";  
                                echo "</form></div>";    
                                }     


                        echo "</div>";
                    echo "</div>";
                    $con->close();
                }
            }
        }      
        else{
            echo "Error: please log in to view your cart<br>";
        }

        
        if(isset($_POST['update'])){
            $conn = new mysqli("localhost", "root", "", "project");
            if(!$conn){
                echo "connection error<br>";
                die();
            }
            $update = "UPDATE cartitem SET amount='" . $_POST['amount'] . "' WHERE productID='" . $_POST['productID']. "' AND customerID='" . $_SESSION['id'] . "'";
            $result = mysqli_query($conn,$update);	
            
            if(!$result || !$updateOrderResult){
                echo "error updating";
            }
            $conn->close();
            echo "<meta http-equiv='refresh' content='0'>";
        }
                
        if(isset($_POST['delete'])) {
            $conn = new mysqli("localhost", "root", "", "project");
            if(!$conn){
                echo "connection error<br>";
                die();
            }

            $delete="DELETE FROM cartitem WHERE productID ='". $_POST['productID']. "' AND customerID='" . $_SESSION['id'] . "'";
            $result=mysqli_query($conn,$delete);

            if(!$result){
                echo "Error deleting from database<br>";
            }
            else{
                $updateOrdersql = "UPDATE orders SET numberOfProducts = numberOfProducts-1 WHERE orderID='" . $_POST['orderID'] . "' AND customerID='" . $_SESSION['id'] . "'"; 
                $updateOrderResult = $conn->query($updateOrdersql);

                if(!$updateOrderResult){
                    echo "Error updating orders table<br>";
                }
            }
            $conn->close();
            echo "<meta http-equiv='refresh' content='0'>";
        }

        ?>
    </body>
</html>