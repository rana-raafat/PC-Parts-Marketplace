<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Website Name - Home</title>
        
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
        ?>
<div class="container">
  <div id="productsCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#productsCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#productsCarousel" data-slide-to="1"></li>
      <li data-target="#productsCarousel" data-slide-to="2"></li>
      <li data-target="#productsCarousel" data-slide-to="3"></li>
      <li data-target="#productsCarousel" data-slide-to="4"></li>
      <li data-target="#productsCarousel" data-slide-to="5"></li>
      <li data-target="#productsCarousel" data-slide-to="6"></li>
      <li data-target="#productsCarousel" data-slide-to="7"></li>
      <li data-target="#productsCarousel" data-slide-to="8"></li>
      <li data-target="#productsCarousel" data-slide-to="9"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <?php

        while($output>0){
            $rand=rand(1, 45);
            for($j=0;$j<sizeof($displayed);$j++){
                if($displayed[$j]==$rand){
                    $skip=true;
                    break;
                }
            }
            if($skip){ $skip=false; continue; 
            }
            
            if($output == 10){
                echo"<div class='item active'>";
            }
            else{
                echo"<div class='item'>";
            }

            $output--;
            $displayed[]=$rand;
            $sql= "SELECT * FROM product WHERE id='" . $rand . "'";
            $result = mysqli_query($con,$sql);
            if ($result->num_rows == 0) {
                echo "No products found<br>";
            }
            if($row = $result->fetch_assoc()){
                echo "<a href=DisplayProduct.php?id=" . $row['id'] . ">";
                    echo "<div class='col-xs-5'>";
                        echo "<img src='" . $row['imagePath'] . "' class='img-responsive carousel-image' alt='product_image'>";
                    echo "</div>";
                
                    echo "<div class='col-xs-7'>";
                        echo "<div class='carousel-caption'>";
                            echo $row['name'];
                            echo "<br><br>";
                            echo "<div class='carousel-caption nowrap'>";
                                echo $row['price'] . " LE";
                                echo "<br><br>";
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
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</a>";
            }
            echo "</div>";
        }
        ?>
    </div>

    <div class="controllers">
        <!-- Left controls -->
        <a class="left carousel-control" href="#productsCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>

        <!-- Right controls -->
        <a class="right carousel-control" href="#productsCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

  </div>
</div>
    </body>
</html>
