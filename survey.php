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
                    echo "connection error<br>";
                    die();
                }//('14')
                $sql="INSERT INTO survery(customerID,rating,improvement,age) VALUES('" . $_SESSION['id'] ."','" . $_POST['rating']  ."','" . $_POST['review'] . "','" . $_POST['Age'] . "')";
                $result=$conn->query($sql);
                if(!$result){
                    echo "connection error<br>";
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

<form action="" method="post" onsubmit="return validate(this);">
    Please rate your experience
    <input type="radio" name="rating" value="1">1</input>
    <input type="radio" name="rating" value="2">2</input>
    <input type="radio" name="rating" value="3">3</input>
    <input type="radio" name="rating" value="4">4</input>
    <input type="radio" name="rating" value="5">5</input>
    <br>
    review:
    <input type="textarea" name="review">

    What is your Age:
    <input type="text" name="Age">
    <input type="submit" value="submit" name="submit">
</form>   

</html>