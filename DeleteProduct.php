<html>
<head>
    <title>Delete Product</title>
</head>
<body>
    <?php 
        session_start();
        include "Menu.php";
        
        if( isset($_SESSION['id']) ){
            if(isset($_POST['Yes'])){
                $con = new mysqli("localhost", "root", "", "project");
                if(!$con){ 
                    echo "connection error<br>";
                    die();
                }

                $id=$_GET['id'];
                $sql = "DELETE FROM product WHERE id='" . $id . "'" ;
                $result = mysqli_query($con,$sql);	

                if (!$result) {
                    printf("Error: %s\n", mysqli_error($con));
                    die();
                }
                else{
                    echo "<script>window.location.href='Home.php'</script>";
                }
                $con->close();
            }
            else if(isset($_POST['No'])){
                echo "<script> 
                        $('#deleteProductModal .close').click(); 
                        window.history.go(-1);
                    </script>";
            }
        }
        
    ?>
    
</body>
</html>