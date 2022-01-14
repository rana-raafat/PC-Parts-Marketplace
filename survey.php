<html>
    <?php 
        session_start();
        include "Menu.php";
        
        if(isset($_POST["submit"]))
        {
            if(filter_var($_POST["Age"],FILTER_VALIDATE_INT))
            {
                $conn = new mysqli("localhost","root","", "project");
                if(!$conn){
                    echo "couldn't connect to the DataBase<br>";
                    die();
                }
               
                $sql="INSERT INTO survey(customerID,rating,improvement,age) VALUES('" . $_SESSION['id'] ."','" . $_POST['rating']  ."','" . $_POST['review'] . "','" . $_POST['Age'] . "')";
                $result = mysqli_query($conn,$sql);
                if(!$result){
                    echo "couldn't insert into the DataBase<br>";
                    die();
                }
                $conn->close();
            }
            else{
                echo "Please enter a number<br>";
            }
        }
        else{
            echo"Please fill in the values";
        }
    ?>

<script>
    function validate(form){
        var fail="";
        
        if(form.Age.value==""){
            fail+="Age is required\n";
        }
        if(form.rating.value==""){
            fail+="pleasse select a rating\n";
        }
        if(form.review.value==""){
            fail+="pleasse select enter a review\n";
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
<div class="container h-100">
    <div class="row align-items-center h-100">
        <div class="col-6 mx-auto">
            <div class="carda h-100 border-primary justify-content-center">
                <div>
<form action="" method="post" onsubmit="return validate(this);"class="form-horizontal"> 
<h3>Feedback</h3><br>
<label class="form-check-label">Please rate your experience</label>

<div class="form-check">
  <input class="form-check-input" type="radio" name="rating" id="exampleRadios1" value="1" >
  <label class="form-check-label">1</label>
  <input class="form-check-input" type="radio" name="rating" id="exampleRadios1" value="2" >
  <label class="form-check-label">2</label>
  <input class="form-check-input" type="radio" name="rating" id="exampleRadios1" value="3" >
  <label class="form-check-label">3</label>
  <input class="form-check-input" type="radio" name="rating" id="exampleRadios1" value="4" >
  <label class="form-check-label">4</label>
  <input class="form-check-input" type="radio" name="rating" id="exampleRadios1" value="5" >
  <label class="form-check-label">5</label>

</div>
    <br>
    <label >Suggested Improvements:</label><br>
    <textarea name="review" class="form-control" maxlength='255'></textarea><br>
    <label >What is your age?</label>
    <input type="text" name="Age" class="form-control">
    <input type="submit" value="submit" name="submit">
    <input type="reset" > <br><br>
</form>   
</div>
</div>
</div>
</div>
</div>
</html>