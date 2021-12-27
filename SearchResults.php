<html>
    <head>
        <link rel="stylesheet" href="Style.css">
        <title>Search Result</title>
    </head>
    <body>
    <?php
        session_start();
        include "Menu.php";

        if(isset($_POST['submitSearch'])){
            $con = new mysqli("localhost", "root", "", "project");
            
            $search=$_POST['searchQuery'];
            $sql= "SELECT * FROM product WHERE name LIKE '%" . $search . "%'";
            $result = mysqli_query($con,$sql);
            if ($result->num_rows == 0) {
                echo "No products found<br>";
            }
            while($row = $result->fetch_assoc()){
                echo "<img src='" . $row['imagePath'] . "' wdith='150' height='150'><br>";
                echo "<a href=DisplayProduct.php?id=" . $row['id'] . ">" . $row['name'] . "<br>";
                echo $row['price'] . " LE<br>";
                $averageRating = 0;
                if($row['numberOfReviews']>0){
                    $averageRating = (1.0*$row['1star'] + 2.0*$row['2stars'] + 3.0*$row['3stars'] + 4.0*$row['4stars'] + 5.0*$row['5stars']) / $row['numberOfReviews'];
                }
                echo $averageRating . " Stars<br><br>";
            }
        }
    ?>
    </body>
</html>