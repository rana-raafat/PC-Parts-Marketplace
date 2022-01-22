<html>
    <head>
        <title> Suggest a Product </title>
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

    if(!isset($_SESSION['id'])){
        echo "Please log in to suggest a product<br>";
        die();
    }

?>
<script>
    function validate(form){
     
        if(form.name.value=="" || form.name.value=="Enter product name"){
            document.getElementById("NameError").innerHTML = "Name required";
            document.getElementById("NameAlert").style.visibility = "visible";
            return false;
        }
        if(form.description.value==""){
          
            document.getElementById("DescError").innerHTML = "Description required";
            document.getElementById("DescAlert").style.visibility = "visible";
            return false;
        }
        return true;
    }
</script>
<div class="container">
            <div class="card">
                <div class="carda">
<form method='post' action='' enctype='multipart/form-data' onsubmit='return validate(this);'>
<h3>Suggest Product</h3><br>
<div class ="form-group">
        <label>Image:</label> 
        <br>
        <input type="file" name="productpic" ><br>
        <br><br>
        <label>Name:</label>
        <input type="text" name="name" placeholder="Enter product name"  class="form-control">
        <div class='alert alert-danger' id="NameAlert" style="visibility: hidden">               
            <i class="glyphicon glyphicon-exclamation-sign"></i>
            <label id="NameError"></label>
            <a href class="close" alert-hide=".alert">
                <span aria-hidden="true">&times;</span>
            </a> 
        </div><br>
        <label>Link:</label><br>
        <input type="text" name="link" placeholder="The link for the product" class="form-control"><br><br>
        <label>Description:</label> <br>
        <textarea name="description" style="width: 100%;"></textarea>
        <div class='alert alert-danger' id="DescAlert" style="visibility: hidden" >               
            <i class="glyphicon glyphicon-exclamation-sign"></i>
            <label id="DescError"></label>
            <a href class="close" alert-hide=".alert">
                <span aria-hidden="true">&times;</span>
            </a> 
        </div>  <br>      
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
        $imagePath='resources/images/SuggestedProducts/default.jpg';
        $target_dir="resources/images/SuggestedProducts/";
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
        $name = filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $link='No link';
        if($_POST["link"]!=''){
            $link=$_POST["link"];
            $link = filter_var($link,FILTER_SANITIZE_URL);
            
        }
        
        $description=$_POST["description"];
        $description = filter_var($description, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $sql="INSERT INTO productsuggestion(imagePath, customerID, productLink,productname,productDescription) VALUES  ('" . $pic . "','" . $_SESSION['id'] . "','" . $link . "','" . $name . "','" . $description . "')";
        $result=mysqli_query($con,$sql);
        try{
            dbException($result);
        }
        catch(Exception $e){
            printf("Error: %s\n", mysqli_error($con));
            die();
        }
        
        $adminsql="SELECT id FROM administrator";
        $adminresult=mysqli_query($con,$adminsql);
        try{
            dbException($adminresult);
        }
        catch(Exception $e){
            printf("Error: %s\n", mysqli_error($con));
            die();
        }
        
        
        $suggestionlink = 'A new product was suggested <a href="DisplaySuggestions.php">Click Here</a> to view';
      
        while($row=$adminresult->fetch_assoc()){
            $msg="INSERT INTO message(senderID,recepientID,auditorFlag,messageText,readStatus) VALUES('". $_SESSION['id'] ."','". $row['id'] ."','0','". $suggestionlink ."','0') " ;
            $surveyResult = mysqli_query($con,$msg);
            if(!$surveyResult){
                echo "couldn't send suggestion to admin " . $row['id'] . "<br>";
                printf("Error: %s\n", mysqli_error($con));
                echo "<br>";
                //die();
            }
        }
        $con->close();
        echo "<script>window.location.href='Home.php'</script>";
        
    }

?>

</form>
    </body>
</html>