<html>
    <head>
        <link rel="stylesheet" href="Style.css">
        <title> Contact Us </title>
    </head>
    <body>

<?php
//
session_start();
include "Menu.php";
$con = new mysqli("localhost", "root", "", "project");

if(!$con){ //maybe here we can throw an exception? instead of using die()
    echo "connection error<br>";
    die();
}


$sql= "SELECT * FROM `product`";
$result = mysqli_query($con,$sql);
if ($result->num_rows == 0) {
    echo "No products found<br>";
}

echo "<table border='2'><tr> <th>Product Name</th> <th>1star</th><th>2stars</th><th>3star</th><th>4star</th><th>5star</th></tr>";
while($row = $result->fetch_assoc()){
    
            echo "<td> " . $row['name'] . " </td>";
            echo " <td> " . $row['1star'] . "</td>";
            echo " <td> " . $row['2stars'] . "</td>";
            echo " <td> " . $row['3stars'] . "</td>";
            echo " <td> " . $row['4stars'] . "</td>";
            echo " <td> " . $row['5stars'] . "</td>";
            
           
            echo "</tr>";
}
echo"</table>";
echo"<br>";
$sql2="SELECT * FROM `review`";
$result2=mysqli_query($con,$sql2);
if ($result2->num_rows == 0) {
    echo "No products found<br>";
}
while($row2 = $result2->fetch_assoc()){
$sql3="SELECT username FROM `users` WHERE id='".$row2['customerID']."' ";
$result3=mysqli_query($con,$sql3);
$row3=$result3->fetch_assoc();
$sql4="SELECT `name` FROM `product` WHERE id='".$row2['productID']."'";
$result4=mysqli_query($con,$sql4);
$row4=$result4->fetch_assoc();
echo "User:$row3[username] <br>";
echo"Item: $row4[name]<br>";
    echo"Review:$row2[reviewText]<br>";
    echo"Number of Stars given: $row2[starRating] <br><br>";
}

?>
</form>
    </body>
</html>
