<html>
<head>
    <title>Add a Product</title>
</head>
<body>
    <?php 
        session_start();
        include "Menu.php";
    ?>
    <script>
        function validate(form){ 
            //var fail="";
            if(form.name.value==""){
                //fail+="Name required\n";
                document.getElementById("NameError").innerHTML = "Name required";
                document.getElementById("NameAlert").style.visibility = "visible";
                return false;
            }
            if(form.description.value==""){
                //fail+="Description required\n";
                document.getElementById("DescriptionError").innerHTML = "Description required";
                document.getElementById("DescriptionAlert").style.visibility = "visible";
                return false;
            }
            /*if(fail == ""){
                return true;
            }
            else{
                alert(fail);
                return false;
            }*/
            return true;
        }
    </script>
    <div class="container">
        <div class="card justify-content-center"> 
            <br><h1 class='center'>Add a Product</h1>
            <div class="cardb">
   
                <form method="post" action="" enctype="multipart/form-data" onsubmit="return validate(this);"class="form-horizontal">
                    <label>Image:</label><br>
                    <input type="file" name="productpic"><br><br>
                    

                    <label>Name:</label><br>
                    <input type="text" name="name" placeholder="Enter product name" class='form-control'>
                    <div class='alert alert-danger' id="NameAlert" style="visibility: hidden" >               
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <label id="NameError"></label>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> 
                    </div>
                    <div class='alert alert-danger' id="NameTakenAlert" style="visibility: hidden" >               
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <label id="NameTakenError"></label>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> 
                    </div>
                    <br>


                    <label>Description:</label> <br>
                    <textarea name="description" placeholder="Enter description here"></textarea>
                    <div class='alert alert-danger' id="DescriptionAlert" style="visibility: hidden" >               
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <label id="DescriptionError"></label>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> 
                    </div><br>

                    <label>Price:</label> <br>
                    <input type="number" name="price" min="0" step="0.25" value="0"><br><br><br>

                    <label>Select a category:</label> <br>
                    <input type="radio" name="category" value="Motherboard" checked> Motherboard <br>
                    <input type="radio" name="category" value="RAM"> RAM <br>
                    <input type="radio" name="category" value="Graphics Card"> Graphics Card <br>
                    <input type="radio" name="category" value="Fan"> Fan <br>
                    <input type="radio" name="category" value="HDD/SSD"> HDD/SSD <br>
                    <input type="radio" name="category" value="Processor"> Processor <br><br>
                    <br>
                    <input type="submit" name="submit">
                </form>
            </div>
        </div>
    </div>
    <?php 
        if(isset($_POST["submit"])){
                
            $productName=$_POST["name"];
            $price=$_POST["price"];
            $description=$_POST["description"];
            $imagePath="resources/images/ProductsPictures/default.jpg"; //default image
            $category=$_POST["category"];


            $con = mysqli_connect("localhost","root","","project");
            if(!$con){
                echo "connection error<br>";
                die();
            }

            $checkProduct="SELECT * FROM product WHERE name='" . $productName . "'";
            $productResult = $con->query($checkProduct);

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
                $target_file=$target_dir . basename($_FILES["productpic"]["name"]);
                $imageType= strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                
                if($_FILES["productpic"]["size"]==0){ //check if no image is inserted
                    echo "Default picture used<br>";
                }
                else if(file_exists($target_file)){ //check if pic already exists, if it does don't move_uploaded_file so there are no duplicates
                    $imagePath=$target_file;
                }
                else if($_FILES["productpic"]["size"]>1000000){
                    echo "Error: Image size is too large<br>";
                }
                else if($imageType != "jpeg" && $imageType != "jpg" && $imageType != "png"){
                    echo "Error: Incorrect file type, Please enter a jpg, jpeg or png<br>";
                }
                else{
                    if(move_uploaded_file($_FILES["productpic"]["tmp_name"], $target_file)){
                        $imagePath=$target_file;
                    }
                    else{
                        echo "Error uploading image<br>";
                    }
                }
                
                $sql="INSERT INTO product(name,description,price,imagePath,1star,2stars,3stars,4stars,5stars,numberOfReviews,category) VALUES('" . $productName . "','" . $description 
                    . "','" . $price . "','" . $imagePath . "','0','0','0','0','0','0','" . $category . "')";

                $result = $con->query($sql);
                if(!$result){
                    echo "error inserting data into database<br>";
                    printf("Error: %s\n", mysqli_error($con));
                    exit(); //exit stops the program
                }
                else{
                    echo "Product added successfully<br>";
                    //echo "<script>window.location.href='addproduct.php'</script>";
                    echo "<script>window.location.href='Home.php'</script>";
                }
            }
            $con->close();
        }

    ?>



</body>
</html>