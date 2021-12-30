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
        
        $reviewed=false; $reviewText=''; $currentRating=0; $itemError = '';

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
                    echo "<a href='EditProduct.php?id=" . $row['id'] . "'> Edit Product </a> ";
                    echo "<a href='DeleteProduct.php?id=" . $row['id'] . "'>Delete Product</a><br><br>";
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
                        $currentRating=$reviewRow['starRating'];
                    }
                }
            }
            else{
                echo "<b>Average Rating:</b> 0.0 Stars<br>";
            }

            $stars='';
            switch ($currentRating){
                case 1:
                    $stars='1star';
                    break;
                case 2:
                    $stars='2stars';
                    break;
                case 3:
                    $stars='3stars';
                    break;
                case 4:
                    $stars='4stars';
                    break;
                case 5:
                    $stars='5stars';
                    break;
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
                else{
                    //header("Location:DisplayProduct.php?id=".$id);
                    ?>
                    <script>
                        $(document).ready(function() {
                            window.location.href = window.location.href;
                        });
                    </script>
                    <?php
                }
            }
            else if(isset($_POST['editReview'])){
                
                $OldRatingsql="SELECT ". $_POST['newRating'] ." FROM product WHERE id='". $id ."'"; 

                $updateReview = "UPDATE review SET reviewText='" . $_POST['newreview'] . "', starRating='" . $_POST['newRating'] ."' WHERE productID='" . $_GET['id']. "' AND customerID='" . $_SESSION['id'] . "'";
                $reviewResult = $con->query($updateReview);
                $updateRating = "UPDATE product SET " . $_POST['newRating'] . "=" . $_POST['newRating'] . " + 1, ". $stars . "=" . $stars . "-1 WHERE id='" . $id . "'";
                $ratingResult = $con->query($updateRating);
                if(!$reviewResult){ //exception here
                    echo "Error updating the review table<br>";
                }
                if(!$ratingResult){
                    echo "Error updating the product table<br>";
                }
                else{
                    //header("Location:DisplayProduct.php?id=".$id);
                    ?>
                    <script>
                        $(document).ready(function() {
                            window.location.href = window.location.href;
                        });
                    </script>
                    <?php
                }
            }
            else if(isset($_POST['deleteReview'])){
                $deleteReview = "DELETE FROM review WHERE productID='" . $id . "' AND customerID='" . $_SESSION['id'] ."'";
                $deleteResult = $con->query($deleteReview);
                
                $decrement_reviews_sql = "UPDATE product SET " . $stars . "=" . $stars . "-1, numberOfReviews = numberOfReviews-1 WHERE id='" . $id . "'";
                $decrementResult = $con->query($decrement_reviews_sql);

                if(!$deleteResult){ //exception here
                    echo "Error deleting from the review table<br>";
                }
                else if(!$decrementResult){ //exception here
                    echo "Error decrementing the reviews in product table<br>";
                }
                else{
                    //header("Location:DisplayProduct.php?id=".$id);
                    ?>
                    <script>
                        $(document).ready(function() {
                            window.location.href = window.location.href;
                        });
                    </script>
                    <?php
                }
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
                    <input type='radio' name='newRating' value='1star' <?php echo ($currentRating==1)?'checked':'' ?> >1 star 
                    <input type='radio' name='newRating' value='2stars' <?php echo ($currentRating==2)?'checked':'' ?>>2 stars
                    <input type='radio' name='newRating' value='3stars' <?php echo ($currentRating==3)?'checked':'' ?>>3 stars
                    <input type='radio' name='newRating' value='4stars' <?php echo ($currentRating==4)?'checked':'' ?>>4 stars
                    <input type='radio' name='newRating' value='5stars' <?php echo ($currentRating==5)?'checked':'' ?>>5 stars<br><br>
                    <textarea name='newreview' rows='4' cols='50' maxlength='1000'><?php echo $reviewText; ?></textarea><br>
                    <input type='submit' name='editReview' value='submit'>
                </form>
                <?php
                }
            else{
                echo "<br><br><b> " . $_SESSION['username'] . " </b><br>";
                echo $currentRating . " stars<br>" . $reviewText;
                echo "<form id='edit' method='post' action=''> <button type='submit' name='edit' value='edit'> Edit review</button> ";
                echo "<button type='submit' name='deleteReview' value='delete'> Delete review</button></form>";
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
                        //need to make the username an href to the profile page
                        echo "<b><a href='profile.php?id=". $reviews['customerID'] ."'>" . $username['username'] . "</a></b><br>";
                        echo $reviews['starRating'] . " stars<br>" . $reviews['reviewText'] . "<br><br>";
                        $counter++;
                    }
                }
                echo "<a href='AllReviews.php'>View all reviews</a>"; //page not made yet
            }
            else{
                echo "No current reviews for this product<br>";
            }
        }
        else{
            echo "Product missing<br>";
        }

        
        $con->close();
    
    ?>

</body>
</html>