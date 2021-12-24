<html>
<head>
    <link rel="stylesheet" href="Style.css">
    <title>Product page</title>
</head>
<body>
    <?php 
        session_start();
        include "Menu.php";

    //maybe carry the name pf the product that the user clicked on in cookies idk

        // Create connection
        $con = new mysqli("localhost", "root", "", "project");

        $productname="AMD RYZEN 5 3600X";
        $sql= "SELECT * FROM product WHERE name='" . $productname . "'";
        $result = mysqli_query($con,$sql);	

        if (!$result) {
            printf("Error: %s\n", mysqli_error($con));
            exit();
        }
        if($row = $result->fetch_assoc()){
            echo "<img src='" . $row['imagePath'] ."'><br><br>";
            echo  "<b>" . $row['name'] . "</b>";
            echo "<br><br>" . $row['price'] . " LE<br><br>";
            echo "<b>Description :</b> <br>". $row['description'] . "<br>";
        }
        else{
            echo "Product missing<br>";
        }
        $con->close();
    
    ?>

</body>
</html>