<html>
<head>
    <title>Adding product</title>
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
        if(fail == ""){
            return true;
        }
        else{
            alert(fail);
            return false;
        }     
    }
    </script>
    <h1>Add a Product</h1>
    <form method="post" action="" enctype="multipart/form-data" onsubmit="return validate(this);" >
        Image: 
        <input type="file" name="productpic"><br>
        Name:
        <input type="text" name="name" placeholder="Enter product name"><br>
        Description: <br>
        <textarea name="description" rows="4" cols="30">Enter description here</textarea><br><br>
        Price: <br>
        <input type="number" name="price" min="0" step="0.01" value="0"><br><br>
        Select a category: <br>
        <input type="radio" name="category" value="Motherboard" checked> Motherboard <br>
        <input type="radio" name="category" value="RAM"> RAM <br>
        <input type="radio" name="category" value="Graphics Card"> Graphics Card <br>
        <input type="radio" name="category" value="Fan"> Fan <br>
        <input type="radio" name="category" value="HDD/SSD"> HDD/SSD <br>
        <input type="radio" name="category" value="Processor"> Processor <br>
        <input type="submit" name="submit"><br>
    </form>
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
        echo "A product with this name already exists<br>";
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
            //header("Location:addproduct.php");
            header("Location:home.php");
        }
    }
    $con->close();

}

?>



</body>
</html>