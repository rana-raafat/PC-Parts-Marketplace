<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Website Name - Home</title>
        <link rel="stylesheet" href="Style.css">
    </head>
    <body>
        <?php
        session_start();
        include "Menu.php";
        
        $con = new mysqli("localhost", "root", "", "project");
        if(!$con){ //exception
            echo "connection error<br>";
            die();
        }
        $rand=1;
        $displayed = [];
        $skip=false;
        $output=10;

        while($output>0){
            $rand=rand(1, 45);
            for($j=0;$j<sizeof($displayed);$j++){
                if($displayed[$j]==$rand){
                    $skip=true;
                    break;
                }
            }
            if($skip){ $skip=false; continue; }
            $output--;
            $displayed[]=$rand;
            $sql= "SELECT * FROM product WHERE id='" . $rand . "'";
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
        }
        ?>
        <br>
    </body>
</html>
