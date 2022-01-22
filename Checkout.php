<html>
    <head>
        <title> Checkout </title>
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

        $con = new mysqli("localhost", "root", "", "project");

        if(!$con){
            echo "connection error<br>";
            die();    
        }

        
        if(isset($_POST['goback'])){
            echo "<script>window.location.href='cart.php'</script>";
        }

        if(isset($_POST["purchasecomplete"])){
            $sql4= "UPDATE `orders` SET `completed`='1' WHERE `customerID`='". $_SESSION['id']."'";
            $result4 = mysqli_query($con,$sql4);
            
            if(!$result4){
                echo "error updating order<br>";
            }
            else{
                //echo"<br>Products Bought Successfully<br>";
                
                $sql5= "INSERT INTO `orders`( `customerID`, `numberOfProducts`, `completed`) VALUES ('". $_SESSION['id']."','0','0')";
                $result5 = mysqli_query($con,$sql5);
                
                if(!$result5){
                    echo "error creating a new order<br>";
                }
                else{
                echo "<script>window.location.href='Home.php'</script>";
                }
            }
        }
        

        ?>

        <div class='container'>
            <div class='card'>
                <div class="shoppingCart">
                    
                    <h3 class='center'> Checkout </h3>

                    <br><br>

                    <?php
                    echo "<text class='header'>Name  </text><br>". $_SESSION['username']."<br><br>";
                    echo "<text class='header'>Address </text><br>" . $_SESSION['address']."<br><br><hr>";
                    ?>

                    <form method='post'>

                        <?php
                        if(isset($_POST['total'])){ //from previous cart page
                            /*
                            $totalPrice=0;
                            $sql= "SELECT  * FROM `cartitem` WHERE `customerID`='". $_SESSION['id']."'";
                            $result = mysqli_query($con,$sql);
                            try{
                                dbException($result);
                            }
                            catch(Exception $e){
                                printf("Database Error: %s\n", mysqli_error($con));
                                die();
                            }
                            while($row = $result->fetch_assoc()){
                                $sql2="SELECT  `price` FROM `product` WHERE `id`='". $row['productID']."'";
                                $result2=mysqli_query($con,$sql2);
                                try{
                                    dbException($result2);
                                }
                                catch(Exception $e){
                                    printf("Database Error: %s\n", mysqli_error($con));
                                    die();
                                }
                                $row2=$result2->fetch_assoc();
                            }
                            */
                            
                            $totalPrice=$_POST['total'];
                            echo "<text class='header'>Total Price </text><br> $totalPrice <br><br>";
                        }

                        ?>
                        <button name="purchasecomplete">Place Order</button>

                        <button name='goback'>Go Back To Cart</button>

                    </form>
                </div>
            </div>
        </div>

    </body>
</html>