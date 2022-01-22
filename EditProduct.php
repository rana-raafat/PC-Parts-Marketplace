<html>
<head>
    <title>Edit Product</title>
</head>
<body>
    <?php 
        session_start();
        include "Menu.php";

        function dbException($queryResult){
            if(!$queryResult){
                throw new Exception("SQL Error");
            }
            return true;
        }
    ?>
    <script>
        function validate(form){ 
    
            if(form.name.value==""){
             
                document.getElementById("NameError").innerHTML = "Name required";
                document.getElementById("NameAlert").style.visibility = "visible";
                return false;
            }
            if(form.category.value==""){
               
                document.getElementById("CategoryError").innerHTML = "Category required";
                document.getElementById("CategoryAlert").style.visibility = "visible";
                return false;
            }
            if(form.description.value==""){
             
                document.getElementById("DescriptionError").innerHTML = "Description required";
                document.getElementById("DescriptionAlert").style.visibility = "visible";
                return false;
            } 
            return true; 
        }
    </script>

    
    <?php 

        $con = new mysqli("localhost", "root", "", "project");
        if(!$con){ 
            echo "connection error<br>";
            die();
        }
        $id = $_GET['id'];

        $sql= "SELECT * FROM product WHERE id='" . $id . "'";
        $result = mysqli_query($con,$sql);	
        try{
            dbException($result);
        }
        catch(Exception $e){
            printf("Database Error: %s\n", mysqli_error($con));
            die();
        }
        if($row = $result->fetch_assoc()){
            ?>
            
            <div class="container">
                <div class="card">
                    <div class="medium-card-container">
                        <h1 class='text-center'>Edit Product</h1><br>

                        <form method="post" action="" enctype="multipart/form-data" onsubmit="return validate(this);">

                            <img src='<?php echo $row['imagePath'];?>' height='400' width='400'><br><br>
                            <input type='file' name='productpic'>
                            
                            <br><br>

                            <label>Name: </label>
                            <input type='text' name='name' value='<?php echo $row['name']; ?>'>

                            <div class='alert alert-danger' id="NameAlert" style="visibility: hidden" >               
                                <i class="glyphicon glyphicon-exclamation-sign"></i>
                                <label id="NameError"></label>
                                <a href class="close" alert-hide=".alert">
                                    <span aria-hidden="true">&times;</span>
                                </a> 
                            </div>

                            <div class='alert alert-danger' id="NameTakenAlert" style="visibility: hidden" >               
                                <i class="glyphicon glyphicon-exclamation-sign"></i>
                                <label id="NameTakenError"></label>
                                <a href class="close" alert-hide=".alert">
                                    <span aria-hidden="true">&times;</span>
                                </a> 
                            </div>

                            <br><br>

                            <label>Price: </label>
                            <input type='number' name='price' min='0' step='0.25' value='<?php echo $row['price']; ?>'> LE
                            <br><br>
                            
                            <label>Category: </label>
                            <select name='category'> 
                                <option value='' selected>Choose category</option>
                                <option value='Motherboard'>Motherboard</option>
                                <option value='RAM'>RAM</option> 
                                <option value='Graphics Card'>Graphics Card</option>
                                <option value='Fan'>Fan</option> 
                                <option value='HDD/SSD'>HDD/SSD</option>
                                <option value='Processor'>Processor</option> 
                            </select>

                            <div class='alert alert-danger' id="CategoryAlert" style="visibility: hidden" >               
                                <i class="glyphicon glyphicon-exclamation-sign"></i>
                                <label id="CategoryError"></label>
                                <a href class="close" alert-hide=".alert">
                                    <span aria-hidden="true">&times;</span>
                                </a> 
                            </div>
                            <br><br>  

                            <label>Description: </label>
                            <br>
                            <textarea name='description' style="height:150px;"><?php echo $row['description']; ?></textarea><br>
                            
                            <div class='alert alert-danger' id="DescriptionAlert" style="visibility: hidden" >               
                                <i class="glyphicon glyphicon-exclamation-sign"></i>
                                <label id="DescriptionError"></label>
                                <a href class="close" alert-hide=".alert">
                                    <span aria-hidden="true">&times;</span>
                                </a> 
                            </div>
                            <br>

                            <input type='submit' name='submit'>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        else{
            echo "Product missing<br>";
        }
        
        if(isset($_POST['submit'])){

            $checkProduct="SELECT * FROM product WHERE name='" . $_POST['name'] . "' AND id!=".$id;
            $productResult = $con->query($checkProduct);
            try{
                dbException($productResult);
            }
            catch(Exception $e){
                printf("Database Error: %s\n", mysqli_error($con));
                die();
            }
            if($productResult->num_rows > 0){
                
                ?>
                <script>
                    document.getElementById("NameTakenError").innerHTML = "Product already exists";
                    document.getElementById("NameTakenAlert").style.visibility = "visible";
                </script>
                <?php
            }
            else{
                if($_FILES["productpic"]["size"]>0) {
                    $sql= "SELECT imagePath FROM product WHERE id='" . $id . "'";
                    $result = mysqli_query($con,$sql);	
                    try{
                        dbException($result);
                    }
                    catch(Exception $e){
                        printf("Database Error: %s\n", mysqli_error($con));
                        die();
                    }
                    
                    if($row = $result->fetch_assoc()){
                        $imagePath=$row['imagePath'];
                        $target_dir="resources/images/ProductsPictures/";
                        $target_file=$target_dir . basename($_FILES["productpic"]["name"]);
                        $imageType= strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    
                        if(file_exists($target_file)){ //check if pic already exists, if it does don't move_uploaded_file so there are no duplicates
                            $imagePath=$target_file;
                        }
                        else if($_FILES["productpic"]["size"]>1000000){
                            echo "Error: Image size is too large";
                            echo "<br>";
                        }
                        else if($imageType != "jpeg" && $imageType != "jpg" && $imageType != "png"){
                            echo "Error: Incorrect file type, Please enter a jpg, jpeg or png";
                            echo "<br>";
                        }
                        else{
                            if(move_uploaded_file($_FILES["productpic"]["tmp_name"], $target_file)){
                                $imagePath=$target_file;
                            }
                            else{
                                echo "Error uploading image";
                                echo "<br>";
                            }
                        }
                        echo $imagePath;
                        $updateImage = "UPDATE product SET imagePath='" . $imagePath . "' WHERE id='" . $id . "'" ;
                        $imageresult = mysqli_query($con,$updateImage);	
                        try{
                            dbException($imageresult);
                        }
                        catch(Exception $e){
                            printf("Database Error: %s\n", mysqli_error($con));
                            die();
                        }
                        
                    }
                    else{
                        echo "image missing<br>";
                    }
                }
                
                $update = "UPDATE product SET name='" . $_POST['name'] . "',price='" . $_POST['price'] . "',description='" . $_POST['description'] .
                "',category='" . $_POST['category'] . "' WHERE id='" . $id . "'" ;
                $result = mysqli_query($con,$update);	
                
                if (!$result) {
                    printf("Error: %s\n", mysqli_error($con));
                    die();
                }
                echo "<script>window.location.href='DisplayProduct.php?id=".$id."'</script>";
                $con->close();
            }
        }
    ?>
                
               

</body>
</html>