<html>
<head>
    <title>Delete Product</title>
</head>
<body>
    <?php 
        session_start();
        include "Menu.php";
    ?>
    <form method="post" action="DeleteProdcut.php">
        Are you sure you want to delete this product?<br>
        <input type="submit" name="Yes" value="Yes">
        <input type="submit" name="No" value="No">
    </form>
    <?php 
        
        if(isset($_POST['Yes'])){
            $con = new mysqli("localhost", "root", "", "project");
            if(!$con){ //maybe here we can throw an exception? instead of using die()
                echo "connection error<br>";
                die();
            }

            $id=$_GET['id'];
            $sql = "DELETE FROM product WHERE id='" . $id . "'" ;
            $result = mysqli_query($con,$sql);	

            if (!$result) {
                printf("Error: %s\n", mysqli_error($con));
                exit();
            }
            echo "<script>window.location.href='Home.php'</script>";
            $con->close();
        }
        else if(isset($_POST['No'])){
            echo "<script> 
                    //$('#signOutModal .close').click(); 
                    window.history.go(-1);
                 </script>";        
        }
    ?>
    
    </form>
</body>
</html>