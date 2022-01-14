<html>
    <head>
        <title>Search for Order</title>
    </head>
    <body>
    <?php
        session_start();
        include "Menu.php";

        if(isset($_SESSION['id'])){
            if($_SESSION['userType']=='administrator'){
                ?>
                <form class='searchbar' action="" method="post">
                    <input type="text" name="OrderQuery" placeholder="Search for an order">
                    <button class="btn btn-basic search-ordr" type="submit" name="submitOrder">
                        <i class="glyphicon glyphicon-search"></i></button> 
                    <select name='filter'>
                        <option value='number' selected>Order Number</option>
                        <option value='customer'>Customer Name</option>
                        <option value='amount'>Amount of Products</option>
                        <option value='product'>Product Name</option> 
                    </select><br><br>
                </form>
                <?php
            }
        }
        else{
            echo "Error: your account does not have this privilege<br>";
        }
        $con = new mysqli("localhost", "root", "", "project");
        if(!$con){ //exception?
            echo "connection error<br>";
            die();
        }
        if(isset($_POST['submitOrder'])){
            $search=$_POST['OrderQuery'];
            $sql='';
            switch($_POST['filter']){
                case 'amount':{
                    $sql="SELECT * FROM orders WHERE numberOfProducts='" . $search . "'";
                    
                    break;
                }
                case 'customer':{
                    $sql="SELECT * FROM orders,users WHERE customerID=id AND username LIKE '%" . $search . "%'";
                    
                    break;
                }
                case 'number':{
                    $sql="SELECT orderID,completed FROM orders WHERE orderID='" . $search . "'";
                    
                    break;
                }
                case 'product':{
                    $sql="SELECT orderID,completed FROM product,cartitem,orders WHERE cartitem.productID=product.id AND orders.orderID=cartitem.orderID AND product.name LIKE '%" . $search . "%'";
                    
                    break;
                }
            }
            $result = mysqli_query($con,$sql);
            if ($result->num_rows == 0) {
                echo "No orders found<br>";
            }

            echo "<br><div class='orders-list'>";
            
            while($row = $result->fetch_assoc()){
                echo "<a href='SearchOrder.php?id=" . $row['orderID'] . "' class='product-list-item'>Order: " . $row['orderID'] . "<br>";
                if($row['completed']==0){
                    echo "Status: Not completed";
                }
                else{
                    echo "Status: Completed";
                }
                echo "</a>";
            }
            echo "</div>";

            
        }
        if(isset($_GET['id'])){
            //display order details
            echo "<br><br><h3>Order details</h3>";
            $sql="SELECT * FROM orders WHERE orderID='" . $_GET['id'] . "'";
            $result = mysqli_query($con,$sql);
            if ($result->num_rows == 0) {
                echo "No orders found<br>";
            }
            else{
                if($row2 = $result->fetch_assoc()){
                    $sql2 = "SELECT * FROM users WHERE id='" . $row2['customerID'] . "'";
                    $result2 = mysqli_query($con,$sql2);
                    if ($result2->num_rows == 0) {
                        echo "No users found<br>";
                    }
                    if($row3 = $result2->fetch_assoc()){
                        echo "Customer Name: " . $row3['username'] . "<br>";
                    }
                    $totalPrice=0;
                    $sql3= "SELECT * FROM cartitem WHERE customerID='". $row2['customerID'] . "' AND orderID='" . $_GET['id'] . "'";
                    $result3 = mysqli_query($con,$sql3);	
                    
                    if (!$result3) { //exception here
                        printf("Error: %s\n", mysqli_error($con));
                        exit();
                    }
                    echo "<div class='container'>";
                    echo "<table border=2 class='table table-striped'>";
                    echo "<thead><tr><th>Image</th><th>Name</th> <th>Price</th> <th>Amount</th></tr></thead><tbody>";
                    while($row4=$result3->fetch_assoc()){
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
                    
                }
            }
        }

        $con->close();
    ?>
    </body>
</html>