<html>
    <head>
        <!---------------------- ADDING A NEW PRODUCT, ONLY AVALIABLE FOR ADMINS IN MENU ------------------------>
        <title>Add a Product</title>
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
            //FORM VALIDATINO FUNCTION, IS CALLED ON FORM SUBMISSION
            function validate(form){ 

                //IF NAME FIELD IS EMPTY
                if(form.name.value==""){
                    //EDIT INNER TEXT OF HIDDEN ALERT PLACED BELOW THE NAME FIELD
                    document.getElementById("NameError").innerHTML = "Name required";
                    //AND MAKE IT VISIBLE
                    document.getElementById("NameAlert").style.visibility = "visible";
                    return false;
                }

                //IF DESCRIPTION FIELD IS EMPTY
                if(form.description.value==""){
                    document.getElementById("DescriptionError").innerHTML = "Description required";
                    document.getElementById("DescriptionAlert").style.visibility = "visible";
                    return false;
                }     
                return true;
            }
        </script>
        <div class="container">
            <div class="card"> 
                <div class="medium-card-container text-center">

                    <h1 class='text-center'>Add a Product</h1>

                    <!-- REMEMBER: 'enctype' IS NEEDED IF WE'RE SENDING FILES IN THE FORM POST SUBMISSION -->
                    <form method="post" class="padded-form" action="" enctype="multipart/form-data" onsubmit="return validate(this);">
                        <!-- IMAGE FIELD -->
                        <label>Image:</label><br>
                        <input type="file" name="productpic"><br><br>
                        
                        <!-- NAME FIELD -->
                        <label>Name:</label><br>
                        <input type="text" name="name" placeholder="Enter product name" style="width: 480px;">
                        <!-- ERROR ALERT IF NAME IS EMPTY (INITIALLY HIDDEN) -->
                        <div class='alert alert-danger' id="NameAlert" style="visibility: hidden" >               
                            <i class="glyphicon glyphicon-exclamation-sign"></i>
                            <label id="NameError"> </label>
                            <a href class="close" alert-hide=".alert">
                                <span aria-hidden="true">&times;</span>
                            </a> 
                        </div>
                        <!-- ERROR ALERT IF NAME IS ALREADY IN DATABASE (INITIALLY HIDDEN) -->
                        <div class='alert alert-danger' id="NameTakenAlert" style="visibility: hidden" >               
                            <i class="glyphicon glyphicon-exclamation-sign"></i>
                            <label id="NameTakenError"></label>
                            <a href class="close" alert-hide=".alert">
                                <span aria-hidden="true">&times;</span>
                            </a> 
                        </div>
                        <br>

                        <!-- DESCRIPTION FIELD -->
                        <label>Description:</label> <br>
                        <textarea name="description" placeholder="Enter description here"></textarea>
                        <!-- ERROR ALERT IF DESCRIPTION IS EMPTY (INITIALLY HIDDEN) -->
                        <div class='alert alert-danger' id="DescriptionAlert" style="visibility: hidden" >               
                            <i class="glyphicon glyphicon-exclamation-sign"></i>
                            <label id="DescriptionError"></label>
                            <a href class="close" alert-hide=".alert">
                                <span aria-hidden="true">&times;</span>
                            </a> 
                        </div><br>

                        <!-- PRICE INPUT -->
                        <label>Price:</label> <br>
                        <input type="number" name="price" min="0" step="0.25" value="0"><br><br><br>

                        <!-- CATEGORY INPUT (INITIALLY CHECKED AS MOTHERBOARD) -->
                        <label>Select a category:</label> <br>
                        <input type="radio" name="category" value="Motherboard" checked> Motherboard <br>
                        <input type="radio" name="category" value="RAM"> RAM <br>
                        <input type="radio" name="category" value="Graphics Card"> Graphics Card <br>
                        <input type="radio" name="category" value="Fan"> Fan <br>
                        <input type="radio" name="category" value="HDD/SSD"> HDD/SSD <br>
                        <input type="radio" name="category" value="Processor"> Processor <br>

                        <br><br>

                        <!-- SUBMIT BUTTON -->
                        <input type="submit" name="submit">
                    </form>
                </div>
            </div>
        </div>


        <?php 
            //IF FORM SUBMIT BUTTON WAS CLICKED
            if(isset($_POST["submit"])){
                //VALUES TO BE INSERTED IN DATABASE AFTER CHECKING FOR ERRORS
                $productName=$_POST["name"];
                $price=$_POST["price"];
                $description=$_POST["description"];
                $imagePath="resources/images/ProductsPictures/default.jpg"; //INITIALLY DEFAULT IMAGE
                $category=$_POST["category"];


                $con = mysqli_connect("localhost","root","","project");
                if(!$con){
                    echo "connection error<br>";
                    die();
                }

                //TO CHECK IF PRODUCT NAME IS REPEATED
                $checkProduct="SELECT * FROM product WHERE name='" . $productName . "'";
                $productResult = $con->query($checkProduct);

                //CATCHES EXCEPTION IF THERE WAS AN ERROR RUNNING SQL QUERY
                try{
                    dbException($productResult);
                }
                catch(Exception $e){
                    printf("Database Error: %s\n", mysqli_error($con));
                    die();
                }

                //IF THERE WERE ROWS IN TABLES WHERE PRODUCT NAME WAS A MATCH
                if($productResult->num_rows > 0){
                    ?>
                    <script>
                        document.getElementById("NameTakenError").innerHTML = "Product already exists";
                        document.getElementById("NameTakenAlert").style.visibility = "visible";
                    </script>
                    <?php
                }
                else{
                    $target_dir="resources/images/ProductsPictures/";
                    //'basename()' EXTRACTS FILENAME ONLY FROM UPLOADED FILE, NO PATHS 
                    $target_file=$target_dir . basename($_FILES["productpic"]["name"]);
                    $imageType= strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    //CHECK IF NO IMAGE IS INSERTED
                    if($_FILES["productpic"]["size"]==0){ 
                        echo "Default picture used<br>";
                    } 
                    //CHECK IF PIC ALREADY EXISTS, DON'T MOVE_UPLOADED_FILE IN THAT CASE SO THERE ARE NO DUPLICATES
                    else if(file_exists($target_file)){
                        $imagePath=$target_file;
                    }
                    //MAKE SURE FILE IS SMALLER THAN 1000000 BYTES
                    else if($_FILES["productpic"]["size"]>1000000){
                        echo "Error: Image size is too large<br>";
                    }
                    //MAKE SURE FILE IS OF ACCEPTABLE FORMATS
                    else if($imageType != "jpeg" && $imageType != "jpg" && $imageType != "png"){
                        echo "Error: Incorrect file type, Please enter a jpg, jpeg or png<br>";
                    }
                    //IF NO ISSUES OCCURED, PROCEEDS TO UPLOAD FILE
                    else{
                        //NOTE THAT IF 'MOVE_UPLOADED_FILE' RETURNS TRUE IF SUCCESSFUL
                        if(move_uploaded_file($_FILES["productpic"]["tmp_name"], $target_file)){
                            $imagePath=$target_file;  //UPDATE IMAGE PATH FROM ABOVE
                        }
                        else{
                            echo "Error uploading image<br>";
                        }
                    }
                    
                    $sql="INSERT INTO product(name,description,price,imagePath,1star,2stars,3stars,4stars,5stars,numberOfReviews,category) VALUES('" . $productName . "','" . $description 
                        . "','" . $price . "','" . $imagePath . "','0','0','0','0','0','0','" . $category . "')";

                    $result = $con->query($sql);
                    try{
                        dbException($result);
                    }
                    catch(Exception $e){
                        printf("Database Error: %s\n", mysqli_error($con));
                        die();
                    }
                    //PRODUCT ADDED SUCCESSFULLY
                    echo "<script>window.location.href='Home.php'</script>";
                    
                }
                $con->close();
            }

        ?>

    </body>
</html>