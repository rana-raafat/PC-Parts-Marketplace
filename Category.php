<html>
    <head>
        <title>Category</title>
    </head>
    <body>
    <?php
        session_start();
        include "Menu.php";
        
        if(isset($_GET['cat'])){
            $con = new mysqli("localhost", "root", "", "project");
            if(!$con){ //maybe here we can throw an exception? instead of using die()
                echo "connection error<br>";
                die();
            }
            
            $search=$_GET['cat'];
            if($search == "All")
                $sql= "SELECT * FROM product";
            else
                $sql= "SELECT * FROM product WHERE category LIKE '%" . $search . "%'";
            $result = mysqli_query($con,$sql);
            if ($result->num_rows == 0) {
                echo "No products found<br>";
            }
            
            echo "<div class='products-list'>";

            while($row = $result->fetch_assoc()){
                echo "<a href=DisplayProduct.php?id=" . $row['id'] . " class='product-list-item'>";
                echo "<img src='" . $row['imagePath'] . "' class='product-list-image' alt='product_image'>";
                echo $row['name'];
                echo "<br>";
                echo $row['price'] . " LE";
                echo "<br>";
                $averageRating = 0;
                if($row['numberOfReviews']>0){
                    $averageRating = (1.0*$row['1star'] + 2.0*$row['2stars'] + 3.0*$row['3stars'] + 4.0*$row['4stars'] + 5.0*$row['5stars']) / $row['numberOfReviews'];    
                }
                for($i=1; $i<= 5; $i++){
                    if($i<=$averageRating)
                        echo "<i class='fa fa-star'></i>";
                    else
                        echo "<i class='fa fa-star-o'></i>";
                }
                echo " Stars";
                echo "</a>";
            }
            $con->close();

            echo "</div>";
        }
    ?>
    
    </body>
</html>