<html>
    <head>
        <title>Search for Order</title>
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
            if($_SESSION['userType']=='administrator'){
                ?>
                <div class='container justify-content-center'>
                <form class='' action="" method="post">
                    <input type="text" name="OrderQuery" placeholder="Search for an order">
                    <button class="btn btn-basic search-ordr" type="submit" name="submitOrder">
                        <i class="glyphicon glyphicon-search"></i></button> 
                    <select name='filter'>
                        <option value='number' selected>Order Number</option>
                        <option value='customer'>Customer Name</option>
                        <option value='amount'>Amount of Products</option>
                        <option value='product'>Product Name</option> 
                    </select>
                    <button type="submit" name="showAll">Show All Orders</button><br><br>
                </form>
                </div>
                <?php
            }
        }
        else{
            echo "Error: your account does not have this privilege<br>";
        }
        $con = new mysqli("localhost", "root", "", "project");
        if(!$con){
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
                    $sql="SELECT orders.orderID,orders.completed FROM product,cartitem,orders WHERE cartitem.productID=product.id AND orders.orderID=cartitem.orderID AND product.name LIKE '%" . $search . "%'";
                    break;
                }
            }
            $result = mysqli_query($con,$sql);
            try{
                dbException($result);
            }
            catch(Exception $e){
                printf("Database Error: %s\n", mysqli_error($con));
                die();
            }
            
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
        if(isset($_POST['showAll'])){
            echo "<div class='container'><div class='card justify-content-center'><div class='List'>";
            echo "<table class='table table-responsive' style='text-align:center'>";
            echo "<thead><tr><th>Order ID</th><th>Customer</th> <th>Amount of Products</th> <th>Completed</th></tr></thead><tbody>";
            $allsql= "SELECT * FROM orders";
            $allResult = mysqli_query($con,$allsql);
            try{
                dbException($allResult);
            }
            catch(Exception $e){
                printf("Database Error: %s\n", mysqli_error($con));
                die();
            }
            while($allRow=$allResult->fetch_assoc()){
                $namesql= "SELECT id,username FROM users WHERE id='" . $allRow['customerID'] ."'";
                $nameResult = mysqli_query($con,$namesql);
               
                $username='User not found';
                $userid=0;
                $completed="No";
                
                if($nameRow=$nameResult->fetch_assoc()){
                    $username=$nameRow['username'];
                    $userid=$nameRow['id'];
                }
                if($allRow['completed']==1){
                    $completed="Yes";
                }
                echo "<tr><td>" . $allRow['orderID'] . "</td> <td><a href=Profile.php?id=". $userid .">" 
                .  $username . "</a></td> <td>" . $allRow['numberOfProducts'] . "</td> <td>" . $completed . "</td></tr>";
                
            }
            echo "</tbody></table>";
            echo "</div></div></div>";
        }
        else if(isset($_GET['id'])){
            //display order details

            echo "<div class='container'><div class='card justify-content-center'><div class='carda'><h3>Order details</h3>";
            $ordersql="SELECT * FROM orders WHERE orderID='" . $_GET['id'] . "'";
            $orderresult = mysqli_query($con,$ordersql);
            try{
                dbException($orderresult);
            }
            catch(Exception $e){
                printf("Database Error: %s\n", mysqli_error($con));
                die();
            }
            if($orderrow = $orderresult->fetch_assoc()){
                $usersql = "SELECT * FROM users WHERE id='" . $orderrow['customerID'] . "'";
                $userResult = mysqli_query($con,$usersql);
                try{
                    dbException($userResult);
                }
                catch(Exception $e){
                    echo "User not found<br>";
                }
                if($userRow = $userResult->fetch_assoc()){
                    echo "<h4>Customer Name: " . $userRow['username'] . "</h4>";
                }
                $totalPrice=0;
                $cartsql= "SELECT * FROM cartitem WHERE customerID='". $orderrow['customerID'] . "' AND orderID='" . $_GET['id'] . "'";
                $cartResult = mysqli_query($con,$cartsql);	
                try{
                    dbException($cartResult);
                }
                catch(Exception $e){
                    printf("Error: %s\n", mysqli_error($con));
                    die();
                }
                
                
                echo "<table border=2 class='table'>";
                echo "<thead><tr><th>Image</th><th>Name</th> <th>Price</th> <th>Amount</th></tr></thead><tbody>";
                while($cartRow=$cartResult->fetch_assoc()){
                    $productsql= "SELECT * FROM product WHERE id='". $cartRow['productID'] . "'";
                    $productResult = mysqli_query($con,$productsql);	
                    try{
                        dbException($productResult);
                    }
                    catch(Exception $e){
                        printf("Error: %s\n", mysqli_error($con));
                        die();
                    }
                    if($productResult->num_rows == 0){
                        echo "Error: Product not found<br>";
                    }
                    else if($prodRow = $productResult->fetch_assoc()){ 
                        $totalPrice+=$prodRow['price'];
                        $image= "<img src='" . $prodRow['imagePath'] ."' height=100 width=100>";
                        $name="<a href='DisplayProduct.php?id=" . $prodRow['id'] . "'>" . $prodRow['name'] . "</a><br>";
                        echo "<tr><td>" . $image . "</td> <td>" .  $name . "</td> <td>" . $prodRow['price'] . "</td> <td>" . $cartRow['amount'] . "</td></tr>";
                    }
                    
                }
                echo "</tbody></table>";
                echo "<b>Total price:</b>" . $totalPrice." "; 
                
            }
          
            echo "</div></div></div>";
        }
        

        $con->close();
    ?>
    </body>
</html>