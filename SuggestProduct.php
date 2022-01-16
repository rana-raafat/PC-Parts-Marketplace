<html>
    <head>
        <link rel="stylesheet" href="Style.css">
        <title> Suggest a Product </title>
    </head>
    <body>

<?php
//
    session_start();
    include "Menu.php";
    if(!isset($_SESSION['id'])){
        echo "Please log in to suggest a product<br>";
        die();
    }

?>
<script>
    function validate(form){
        //alert(form.name.value);
        if(form.name.value=="" || form.name.value=="Enter product name"){
            document.getElementById("NameError").innerHTML = "Name required";
            document.getElementById("NameAlert").style.visibility = "visible";
            return false;
        }
        if(form.description.value==""){
            //alert("working!");
            document.getElementById("DescError").innerHTML = "Description required";
            document.getElementById("DescAlert").style.visibility = "visible";
            return false;
        }
        return true;
    }
</script>
<div class="container">
            <div class="card justify-content-center">
                <div class="carda">
<form method='post' action='' enctype='multipart/form-data' onsubmit='return validate(this);' class="form-horizontal">
<div class ="form-group">
        <label>Image:</label> 
        <input type="file" name="productpic" ><br>
        <label>Name:</label>
        <input type="text" name="name" placeholder="Enter product name"  class="form-control">
        <div class='alert alert-danger' id="NameAlert" style="visibility: hidden">               
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <label id="NameError"></label>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> 
        </div><br>
        <label>Link:</label><br>
        <input type="url" name="link" placeholder="The link for the product" style="color:black"  class="form-control"><br><br>
        <label>Description:</label> <br>
        <textarea name="description" rows="4" cols="30" style="color:black" maxlength='255'></textarea>
        <div class='alert alert-danger' id="DescAlert" style="visibility: hidden" >               
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <label id="DescError"></label>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> 
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
        $link='No link';
        if($_POST["link"]!=''){
            $link=$_POST["link"];
        }
        
        $description=$_POST["description"];
        $sql="INSERT INTO productsuggestion(imagePath, customerID, productLink,productname,productDescription) VALUES  ('" . $pic . "','" . $_SESSION['id'] . "','" . $link . "','" . $name . "','" . $description . "')";
        $result=mysqli_query($con,$sql);
        if(!$result){
            echo "couldn't insert suggestion into the DataBase<br>";
            printf("Error: %s\n", mysqli_error($con));
            die();
        }
        $adminsql="SELECT id FROM administrator";
        $adminresult=mysqli_query($con,$adminsql);
        if(!$adminresult){
            echo "couldn't select admin ids<br>";
            printf("Error: %s\n", mysqli_error($con));
            die();
        }
        
        $suggestionlink = 'A new product was suggested <a href="DisplaySuggestions.php">Click Here</a> to view';
        //don't sanatize this cause it needs to stay as a link obviously
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