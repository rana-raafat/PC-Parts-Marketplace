<html>
<head>
    <link rel="stylesheet" href="Style.css">
    <title>Product page</title>
</head>
<body>
    <script>
    function validate(form){ 
        var fail="";
        if(form.rating.value == ""){
            fail+="Star rating required\n";
        }
        if(form.review.value == "" || form.review.value == "Write a review..."){
            fail+="Review required\n";
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
    <?php 
        session_start();
        include "Menu.php";

        $con = new mysqli("localhost", "root", "", "project");
        if(!$con){ //maybe here we can throw an exception? instead of using die()
            echo "connection error<br>";
            die();
        }
        
        $reviewed=false; $reviewText=''; $rate=''; $itemError = '';

        $id = $_GET['id'];
        
        $sql= "SELECT * FROM product WHERE id='" . $id . "'";
        $result = mysqli_query($con,$sql);	

        if (!$result) { //exception here
            printf("Error: %s\n", mysqli_error($con));
            exit();
        }

        if(isset($_POST['addButton'])){ 
            $checkCart = "SELECT * FROM cartitem WHERE customerID='". $_SESSION['id'] . "' AND productID='" . $id . "'";
            $checkResult = $con->query($checkCart);
            if($checkResult->num_rows != 0){
                $itemError= "Item is already in cart<br>";
            }
            else if($checkResult->num_rows == 0){
                $addToCart = "INSERT INTO cartitem VALUES('". $_SESSION['id'] . "','" . $id . "','" . $_POST['amount'] ."')";
                $addResult = $con->query($addToCart);

                if(!$addResult){ //exception here
                    echo "Error inserting into cart<br>";
                }
            }
            //header("Location:DisplayProduct.php?id=".$id);
            //$con->close();
        }
        
        if($row = $result->fetch_assoc()){
            if(isset($_SESSION['username'])){
                
                if($_SESSION['userType'] == "administrator"){
                    echo "<a href=EditProduct.php?id=" . $row['id'] . ">Edit Product</a> ";
                    echo "<a href=DeleteProduct.php?id=" . $row['id'] . ">Delete Product</a><br><br>"; //not made yet
                }
            }
            echo "<img src='" . $row['imagePath'] ."'>";
            
            if(isset($_SESSION['username'])){
                if($_SESSION['userType'] == "customer"){
                    //add to cart button, adds product as a row in cartitem table 
                    ?>
                    <form id='addCart' method='post' action=''> 
                    <input type='number' name='amount' min='1' max='50' value='0'>
                    <button type='submit' name='addButton' value='addButton'>Add to Cart</button></form> <?  ?>
                    <?php
                    echo $itemError;
                }
            }

            echo  "<br><b>" . $row['name'] . "</b>";
            echo "<br><br>" . $row['price'] . " LE<br><br>";
            echo "<b>Description :</b> <br>". $row['description'] . "<br>";
            if($row['numberOfReviews']>0){
                $averageRating = (1.0*$row['1star'] + 2.0*$row['2stars'] + 3.0*$row['3stars'] + 4.0*$row['4stars'] + 5.0*$row['5stars']) / $row['numberOfReviews'];
                echo "<a href='AllReviews.php'>Average Rating: " . $averageRating . " Stars</a><br>"; 
                //average rating needs to be a link that also redirects to the "view all reviews" page with all the details and stuff
                $select = "SELECT * FROM review WHERE productID='" . $id . "' AND customerID='" . $_SESSION['id'] . "'";
                $selectResult = $con->query($select);
                if($selectResult->num_rows != 0){
                    $reviewed=true;
                    if($reviewRow = $selectResult->fetch_assoc()){
                        $reviewText=$reviewRow['reviewText'];
                        $rate=$reviewRow['starRating'];
                    }
                }
            }
            else{
                echo "<b>Average Rating:</b> 0.0 Stars<br>";
            }
            
            //if the logged in user has reviewed this product remove the form and place a "edit review" option instead 
            if(!$reviewed){
                ?>
                <br><b>Rate this product:</b>
                <form method='post' action='' onsubmit='return validate(this);'>
                    <input type='radio' name='rating' value='' hidden checked>
                    <input type='radio' name='rating' value='1star'>1 star 
                    <input type='radio' name='rating' value='2stars'>2 stars
                    <input type='radio' name='rating' value='3stars'>3 stars
                    <input type='radio' name='rating' value='4stars'>4 stars
                    <input type='radio' name='rating' value='5stars'>5 stars<br><br>
                    <textarea name='review' rows='4' cols='50' maxlength='1000'>Write a review...</textarea><br>
                    <input type='submit' name='submitReview' value='submit'>
                </form>
                <?php
            }
            else{
                if(isset($_POST['edit'])){
                ?>
                <br><b>Edit your review:</b>
                <form method='post' action='' onsubmit='return validate(this);'>
                    <input type='radio' name='rating' value='1star' <?php echo ($rate=='1')?'checked':'' ?> >1 star 
                    <input type='radio' name='rating' value='2stars' <?php echo ($rate=='2')?'checked':'' ?>>2 stars
                    <input type='radio' name='rating' value='3stars' <?php echo ($rate=='3')?'checked':'' ?>>3 stars
                    <input type='radio' name='rating' value='4stars' <?php echo ($rate=='4')?'checked':'' ?>>4 stars
                    <input type='radio' name='rating' value='5stars' <?php echo ($rate=='5')?'checked':'' ?>>5 stars<br><br>
                    <textarea name='review' rows='4' cols='50' maxlength='1000'><?php echo $reviewText; ?></textarea><br>
                    <input type='submit' name='editReview' value='submit'>
                </form>
                <?php
                }
            else{
                echo "<form id='edit' method='post' action=''> <button type='submit' name='edit' value='edit'> Edit review </button></form>";
                //output user's review here
                echo "<b>" . $_SESSION['username'] . "</b><br>";
                echo $rate . " stars<br>" . $reviewText . "<br><br>";
            }
            }
            //need to add rating and reviews and such here
            if($row['numberOfReviews']>0){
                //output a few of the reviews and have a view-all-reviews button that redirects to a page with all the reviews for this product
                $selectReviews = "SELECT * FROM review WHERE productID='" . $id . "' AND customerID <>'" . $_SESSION['id'] . "'";
                $selectReviewResult = $con->query($selectReviews);
                $counter=0;
                while($reviews=$selectReviewResult->fetch_assoc()){
                    if($counter==2){
                        break;
                    }
                    $usernameSql = "SELECT username FROM users WHERE id='" . $reviews['customerID'] . "'";
                    $usernameResult = $con->query($usernameSql);
                    if($username=$usernameResult->fetch_assoc()){
                        echo "<b>" . $username['username'] . "</b><br>";
                        echo $reviews['starRating'] . " stars<br>" . $reviews['reviewText'] . "<br><br>";
                        $counter++;
                    }
                }
                echo "<a href='AllReviews.php'>View all reviews</a>"; //page not made yet
            }
            else{
                echo "No current reviews for this product<br>";
            }

            if(isset($_POST['submitReview'])){
                $update = "UPDATE product SET " . $_POST['rating'] . "=" . $_POST['rating'] . "+1, numberOfReviews = numberOfReviews+1 WHERE id='" . $id . "'";
                $insert = "INSERT INTO review VALUES('" . $id . "','" . $_SESSION['id'] . "','" . $_POST['review'] . "','" . $_POST['rating'] ."')";
                $updateResult = $con->query($update);
                $insertResult = $con->query($insert);

                if(!$updateResult){ //exception here
                    echo "Error updating the product table<br>";
                }
                if(!$insertResult){ //exception here
                    echo "Error inserting in the review table<br>";
                }
            }
            else if(isset($_POST['editReview'])){
                $updateReview = "UPDATE review SET reviewText='" . $_POST['review'] . "', starRating='" . $_POST['rating'] ."' WHERE productID='" . $_GET['id']. "' AND customerID='" . $_SESSION['id'] . "'";
                $editResult = $con->query($updateReview);

                if(!$editResult){ //exception here
                    echo "Error updating the review table<br>";
                }
                header("Location:DisplayProduct.php?id=".$id); //could be replaced if we use ajax i think
                //$con->close();
            }
        }
        else{
            echo "Product missing<br>";
        }

        
        $con->close();
    
    ?>

</body>
</html>