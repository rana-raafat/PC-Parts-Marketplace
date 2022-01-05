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
            $sql= "SELECT * FROM product WHERE category LIKE '%" . $search . "%'";
            $result = mysqli_query($con,$sql);
            if ($result->num_rows == 0) {
                echo "No products found<br>";
            }
            while($row = $result->fetch_assoc()){
                echo "<img src='" . $row['imagePath'] . "' wdith='150' height='150'><br>";
                echo "<a href=DisplayProduct.php?id=" . $row['id'] . ">" . $row['name'] . "</a><br>";
                echo $row['price'] . " LE<br>";
                $averageRating = 0;
                if($row['numberOfReviews']>0){
                    $averageRating = (1.0*$row['1star'] + 2.0*$row['2stars'] + 3.0*$row['3stars'] + 4.0*$row['4stars'] + 5.0*$row['5stars']) / $row['numberOfReviews'];
                }
                echo $averageRating . " Stars<br><br>";
            }
            $con->close();
        }
    ?>
    
    </body>
</html>