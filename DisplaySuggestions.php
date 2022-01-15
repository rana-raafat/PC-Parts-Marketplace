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

if(!$con){
    echo "connection error<br>";
    die();
}
$sql= "SELECT * FROM productsuggestion";
$result = mysqli_query($con,$sql);
if ($result->num_rows == 0) {
    echo "No results found<br>";
}

echo "<table border='2'><tr> <th>Name of Product</th> <th>Customer ID</th><th>Product ID</th><th>Image Path</th><th>Product Link</th><th>Product Description</th></tr>";
while($row = $result->fetch_assoc()){
    
            echo "<tr><td> " . $row['productname'] . " </td>";
            echo " <td> " . $row['customerID'] . "</td>";
            echo " <td> " . $row['id'] . "</td>";
            echo " <td> " . $row['imagePath'] . "</td>";
            echo " <td> " . $row['productLink'] . "</td>";
            echo " <td> " . $row['productDescription'] . "</td>";
            
            
            
           
            echo "</tr>";
}
?>
    </body>
</html>