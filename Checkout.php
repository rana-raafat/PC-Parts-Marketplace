<html>
    <head>
        <title>Checkout</title>
    </head>
    <body>
    <?php 
        session_start();
        include "Menu.php";

        //after the purchase is complete make the completed value in the orders table for that order = 1
        //and create a new order with customer's id, completed value=0 and numofproducts=0
    ?>
    
    </body>
</html>