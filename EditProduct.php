<html>
<head>
    <title>Edit Product</title>
</head>
<body>
    <?php 
        session_start();
        include "Menu.php";
    ?>
    <script>
    function validate(form){ 
        var fail="";
        if(form.name.value==""){
            fail+="Name required\n";
        }
        if(form.description.value==""){
            fail+="Description required\n";
        }
        if(form.category.value==""){
            fail+="Category required\n";
        }
        if(fail == ""){
            return true;
        }
        else{
            alert(fail);
            return false;
        }     
    }
    </script>
    <form method="post" action="" enctype="multipart/form-data" onsubmit="return validate(this);">
    <?php 

        $con = new mysqli("localhost", "root", "", "project");
        if(!$con){ //maybe here we can throw an exception? instead of using die()
            echo "connection error<br>";
            die();
        }
        $id = $_GET['id'];
        if(isset($_POST['submit'])){
            $update = "UPDATE product SET name='" . $_POST['name'] . "',price='" . $_POST['price'] . "',description='" . $_POST['description'] .
            "',category='" . $_POST['category'] . "' WHERE id='" . $id . "'" ;
            $result = mysqli_query($con,$update);	

            if (!$result) { //exception
                printf("Error: %s\n", mysqli_error($con));
                exit();
            }
            header("Location:home.php");
            $con->close();
        }
        else{
            
            $sql= "SELECT * FROM product WHERE id='" . $id . "'";
            $result = mysqli_query($con,$sql);	

            if (!$result) {
                printf("Error: %s\n", mysqli_error($con));
                exit();
            }
            if($row = $result->fetch_assoc()){
                echo "<img src='" . $row['imagePath'] ."'><input type='file' name='productpic'><br><br>";
                echo  "<input type='text' name='name' value='" . $row['name'] . "'>" ;
                echo "<br><br><input type='number' name='price' min='0' step='0.01' value='". $row['price'] ."'> LE<br><br>";
                echo "<textarea name='description' rows='4' cols='50'>". $row['description'] ."</textarea><br>";
                echo "Category: <select name='category'> <option value='' selected>Choose category</option>";
                echo "<option value='Motherboard'>Motherboard</option>";
                echo "<option value='RAM'>RAM</option> <option value='Graphics Card'>Graphics Card</option>";
                echo "<option value='Fan'>Fan</option> <option value='HDD/SSD'>HDD/SSD</option>";
                echo "<option value='Processor'>Processor</option> </select><br>";
                echo "<input type='submit' name='submit'><br>";
            }
            else{
                echo "Product missing<br>";
            }
            
            $con->close();
        }
        /*<select name='category'>
        <option value='Motherboard'>Motherboard</option>
        <option value='RAM'>RAM</option>
        <option value='Graphics Card'>Graphics Card</option>
        <option value='Fan'>Fan</option>
        <option value='HDD/SSD'>HDD/SSD</option>
        <option value='Processor'>Processor</option>
        </select>*/
    ?>
    
    </form>
</body>
</html>