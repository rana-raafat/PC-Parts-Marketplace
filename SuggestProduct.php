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
?>
<div class="container">
            <div class="card justify-content-center">
                <div class="carda">
                    <h1>Suggest A Product</h1>
<form method='post' action='' enctype='multipart/form-data' onsubmit='return validate(this);'class="form-horizontal">
<div class ="form-group">
            <label>Image:</label><br>
            <input type="file" name="productpic" class="form-control"><br> 
            <label>Name:</label><br>
            <input type="text" name="name" placeholder="Enter product name" class="form-control"><br> 
            <label>Link:</label><br>
            <input type="url" name="link" placeholder="The link for the product" style="color:black" class="form-control"><br> 
            <label>Description:</label><br>
        <textarea name="description" rows="4" cols="30" style="color:black";></textarea><br>
        <input type='Submit' name='submit'>

        </form>
</div>
</div>
</div>
<?php 

$con = new mysqli("localhost", "root", "", "project");

if(!$con){ 
    echo "connection error<br>";
    die();
}

if(isset($_POST["submit"])){
    $imagePath='';
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
        $pic=$imagePath;
        $name=$_POST["name"];
        $link=$_POST["link"];
        $description=$_POST["description"];
        $sql="INSERT INTO productsuggestion(imagePath, customerID, hrID, adminID,productLink,productname,productDescription) VALUES  ('" . $pic . "','10','1','3','" . $link . "','" . $name . "','" . $description . "')";
        $result=mysqli_query($con,$sql);
    }

?>

</form>
    </body>
</html>