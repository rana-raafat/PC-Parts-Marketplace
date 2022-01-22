<html>
<head>
    <title>Product page</title>

    <script>
    function validate(form){ 
    
        if(form.rating.value == ""){
   
            document.getElementById("RatingError").innerHTML = "Rating required";
            document.getElementById("RatingAlert").style.visibility = "visible";
            return false;
        }
        if(form.review.value == "" || form.review.value == "Write a review..."){
     
            document.getElementById("ReviewError").innerHTML = "Review required";
            document.getElementById("ReviewAlert").style.visibility = "visible";
            return false;
        }
        return true;    
    }

    function validateReply(form2){ 
  
        if(form2.replyText.value == "" || form2.replyText.value == "Write a reply..."){
      
            document.getElementById("ReplyError").innerHTML = "Reply required";
            document.getElementById("ReplyAlert").style.visibility = "visible";
            return false;
        }
        return true;
    }

    </script>
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

        echo "<div class='container justify-content-center'>";
            $con = new mysqli("localhost", "root", "", "project");
            if(!$con){ 
                echo "connection error<br>";
                die();
            }
            
            $reviewed=false; $reviewText=''; $currentRating=0; $itemError = '';

            $id = $_GET['id'];
            
            $sql = "SELECT * FROM product WHERE id='" . $id . "'";
            $result = mysqli_query($con,$sql);	
            try{
                dbException($result);
            }
            catch(Exception $e){
                printf("Database Error: %s\n", mysqli_error($con));
                die();
            }

            if(isset($_POST['reply'])){
                $text=$_POST['replyText'];
                $text=filter_var($text, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                $insertReply='INSERT INTO reviewreply(reviewID,userID,replyText) VALUES ("' . $_POST['reply'] . '","' . $_SESSION['id'] . '","' . $text . '")';
                $insertReplyResult = $con->query($insertReply);
                try{
                    dbException($insertReplyResult);
                }
                catch(Exception $e){
                    printf("Database Error: %s\n", mysqli_error($con));
                    die();
                }
                
                    ?>
                    <script>
                        $(document).ready(function() {
                            window.location.href = window.location.href;
                        });
                    </script>
                    <?php
               
            }


            if(isset($_POST['addButton'])){ 
                $checkCart = "SELECT * FROM cartitem WHERE customerID='". $_SESSION['id'] . "' AND productID='" . $id . "'";
                $checkResult = $con->query($checkCart);
                try{
                    dbException($checkResult);
                }
                catch(Exception $e){
                    printf("Database Error: %s\n", mysqli_error($con));
                    die();
                }
                if($checkResult->num_rows != 0){
                    $itemError= "Item is already in cart<br>";
                }
                else if($checkResult->num_rows == 0){
                    $orderIDsql = "SELECT orderID FROM orders WHERE customerID='" . $_SESSION['id'] . "' AND completed='0'";
                    $orderIDresult = $con->query($orderIDsql);
                    try{
                        dbException($orderIDresult);
                    }
                    catch(Exception $e){
                        printf("Database Error: %s\n", mysqli_error($con));
                        die();
                    }
                    if($orderIDresult->num_rows == 0){
                        echo "Error: order not found<br>";
                    }
                    else if($orderRow = $orderIDresult->fetch_assoc()){ 
                        $addToCart = "INSERT INTO cartitem VALUES('" . $orderRow['orderID'] . "','". $_SESSION['id'] . "','" . $id . "','" . $_POST['amount'] ."')";
                        $addResult = $con->query($addToCart);
                        if(!$addResult){
                            echo "Error inserting into cart<br>";
                        }
                        else{
                           
                            $updateOrdersql = "UPDATE orders SET numberOfProducts = numberOfProducts+1 WHERE orderID='" . $orderRow['orderID'] . "' AND customerID='" . $_SESSION['id'] . "'"; 
                            $updateOrderResult = $con->query($updateOrdersql);
                            if(!$updateOrderResult){ 
                                echo "Error updating order<br>";
                            }
                        }   
                        echo "<meta http-equiv='refresh' content='0'>";
                    }
                }
            }
            
            if($row = $result->fetch_assoc()){
                echo "<br><img src='" . $row['imagePath'] ."' class='img-responsive product-img' alt='product_image'>";
                if(isset($_SESSION['username'])){
                    if($_SESSION['userType'] == "administrator"){
                        echo "<div class='text-right'>";
                        echo "<a href='EditProduct.php?id=" . $row['id'] . "' class='href-btn'><button>Edit Product</button></a> ";

                        ?>
                        <!-------------------------------------------------- Delete Product Modal -------------------------------------------------->
                        <div class="container">
                            <div class="modal fade" id="deleteProductModal" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h3 class="modal-title">Delete Product</h3>
                                </div>

                                <div class="modal-body">
                                    <form action="DeleteProduct.php?id=<?php echo $row['id']; ?>" method="post">
                                        Are you sure you want to delete this product?<br>
                                        <input type="submit" name="Yes" value="Yes">
                                        <input type="submit" name="No" value="No">
                                    </form>
                                </div>

                                </div>      
                            </div>
                            </div>
                        </div>
                        <?php

                        echo "<a data-toggle='modal' data-target='#deleteProductModal' class='href-btn'><button>Delete Product</button></a></div>";
                    }
                }                
                if(isset($_SESSION['username'])){
                    if($_SESSION['userType'] == "customer"){
                        //add to cart button, adds product as a row in cartitem table 
                        ?>
                        <form id='addCart' method='post' action='' class="text-right"> 
                        <input type='number' name='amount' min='1' max='50' value='1'>
                        <button type='submit' name='addButton' value='addButton'>Add to Cart</button></form>
                        <?php
                        echo $itemError;
                    }
                }

                echo  "<h1 class='product-name'>" . $row['name'] . "</h1>";
                echo "<h3 class='product-price'><i>" . $row['price'] . " LE</i></h3>";
                if($row['numberOfReviews']>0){
                    $averageRating = (1.0*$row['1star'] + 2.0*$row['2stars'] + 3.0*$row['3stars'] + 4.0*$row['4stars'] + 5.0*$row['5stars']) / $row['numberOfReviews'];
                 
                    echo "<h4><a href='#reviews'>Average Rating :</a> ";
                    for($i=1; $i<= 5; $i++){
                        if($i<=$averageRating)
                            echo "<i class='fa fa-star product-dsc'></i>";
                        else
                            echo "<i class='fa fa-star-o'></i>";
                    }
                    echo " " . $averageRating . " Stars</h4><br>"; 
                
                   
                    if(isset($_SESSION['id'])){
                        $select = "SELECT * FROM review WHERE productID='" . $id . "' AND customerID='" . $_SESSION['id'] . "'";
                        $selectResult = $con->query($select);
                        try{
                            dbException($selectResult);
                        }
                        catch(Exception $e){
                            printf("Database Error: %s\n", mysqli_error($con));
                            die();
                        }
                        if($selectResult->num_rows != 0){
                            $reviewed=true;
                            if($reviewRow = $selectResult->fetch_assoc()){
                                $reviewText=$reviewRow['reviewText'];
                                $currentRating=$reviewRow['starRating'];
                            }
                        }
                    }
                }
                else{
                    echo "<b>Average Rating:</b> ";
                    for($i=1; $i<= 5; $i++){
                        echo " <i class='fa fa-star-o'></i>";
                    }
                    echo " 0.0 Stars<br><br>";
                }
                echo "<h4 class='product-dsc'>Product Description :</h4> <p class='desc'>". $row['description'] . "</p><br>";
                echo "<hr><hr>";
                
            
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
                    if(isset($_SESSION['id'])){
                        $review=$_POST['review'];
                        $review=filter_var($review, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                        $update = "UPDATE product SET " . $_POST['rating'] . "=" . $_POST['rating'] . "+1, numberOfReviews = numberOfReviews+1 WHERE id='" . $id . "'";
                        $insert = 'INSERT INTO review(productID,customerID,reviewText,starRating) VALUES("' . $id . '","' . $_SESSION['id'] . '","' . $review . '","' . $_POST['rating'] .'")';
                        
                        $insertResult = $con->query($insert);
                        if(!$insertResult){ 
                            echo "Error inserting in the review table<br>";
                        }
                        else{
                            $updateResult = $con->query($update);
                            if(!$updateResult){ 
                                echo "Error updating the product table<br>";
                            }
                            else{
                       
                            ?>
                            <script>
                                $(document).ready(function() {
                                    window.location.href = window.location.href;
                                });
                            </script>
                            <?php
                            }
                        }
                    }
                    else{
                 
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

                    $updateReview = "UPDATE review SET reviewText='" . $_POST['newreview'] . "', starRating='" . $_POST['newRating'] ."' WHERE productID='" . $_GET['id']. "' AND customerID='" . $_SESSION['id'] . "'";
                    $reviewResult = $con->query($updateReview);
                    
                    $updateRating = "UPDATE product SET " . $_POST['newRating'] . "=" . $_POST['newRating'] . " + 1, ". $stars . "=" . $stars . "-1 WHERE id='" . $id . "'";
                
                    if(!$reviewResult){
                        echo "Error updating the review table<br>";
                    }
                    else{
                        $ratingResult = $con->query($updateRating);
                        if(!$ratingResult){
                            echo "Error updating the product table<br>";
                        }
                        else{
                           
                            ?>
                            <script>
                                $(document).ready(function() {
                                    window.location.href = window.location.href;
                                });
                            </script>
                            <?php
                        }
                    }
                }
                else if(isset($_POST['deleteReview'])){
                    $deleteReview = "DELETE FROM review WHERE productID='" . $id . "' AND customerID='" . $_SESSION['id'] ."'";
                    $deleteResult = $con->query($deleteReview);
                    
                    $decrement_reviews_sql = "UPDATE product SET " . $stars . "=" . $stars . "-1, numberOfReviews = numberOfReviews-1 WHERE id='" . $id . "'";
                    if(!$deleteResult){ 
                        echo "Error deleting from the review table<br>";
                    }
                    else {
                        $decrementResult = $con->query($decrement_reviews_sql);
                        if(!$decrementResult){ 
                            echo "Error decrementing the reviews in product table<br>";
                        } 
                        else{
                           
                            ?>
                            <script>
                                $(document).ready(function() {
                                    window.location.href = window.location.href;
                                });
                            </script>
                            <?php
                        }
                    }
                
                }
                
                //if the logged in user has reviewed this product remove the form and place a "edit review" option instead 
                if(isset($_SESSION['id'])){
                    if($_SESSION['userType']=='customer'){
                        if(!$reviewed){
                            ?>
                            <h4 class='product-dsc'>Rate this product:</h4>
                            <form method='post' action='' onsubmit='return validate(this);'>
                                <input type='radio' name='rating' value='' hidden checked>
                                <input type='radio' name='rating' value='1star'>1 star 
                                <input type='radio' name='rating' value='2stars'>2 stars
                                <input type='radio' name='rating' value='3stars'>3 stars
                                <input type='radio' name='rating' value='4stars'>4 stars
                                <input type='radio' name='rating' value='5stars'>5 stars
                                <div class='alert alert-danger' id="RatingAlert" style="visibility: hidden" >               
                                    <i class="glyphicon glyphicon-exclamation-sign"></i>
                                    <label id="RatingError"></label>
                                    <a href class="close" alert-hide=".alert">
                                        <span aria-hidden="true">&times;</span>
                                    </a>  
                                </div><br><br>
                                <textarea name='review' rows='4' cols='50' maxlength='255'placeholder='Write a review...'></textarea>
                                <div class='alert alert-danger' id="ReviewAlert" style="visibility: hidden" >               
                                    <i class="glyphicon glyphicon-exclamation-sign"></i>
                                    <label id="ReviewError"></label>
                                    <a href class="close" alert-hide=".alert">
                                        <span aria-hidden="true">&times;</span>
                                    </a> 
                                </div><br>
                                <input type='submit' name='submitReview' value='submit'>
                            </form>
                            <?php
                        }
                        else{
                            echo "<img src='" . $_SESSION['imagePath'] . "' class='profile-icon'> ";
                            echo "<b> " . $_SESSION['username'] . " </b><br>";
                            if(isset($_POST['edit'])){
                            ?>
                            <br><b>Edit your review:</b>
                            <form method='post' action='' onsubmit='return validate(this);'>
                                <input type='radio' name='newRating' value='1star'  <?php echo ($currentRating==1)?'checked':'' ?> >1 star 
                                <input type='radio' name='newRating' value='2stars' <?php echo ($currentRating==2)?'checked':'' ?>>2 stars
                                <input type='radio' name='newRating' value='3stars' <?php echo ($currentRating==3)?'checked':'' ?>>3 stars
                                <input type='radio' name='newRating' value='4stars' <?php echo ($currentRating==4)?'checked':'' ?>>4 stars
                                <input type='radio' name='newRating' value='5stars' <?php echo ($currentRating==5)?'checked':'' ?>>5 stars<br><br>
                                <textarea name='newreview' rows='4' cols='50' maxlength='255' wrap='hard' autofocus><?php echo $reviewText; ?></textarea>
                                <div class='alert alert-danger' id="ReviewAlert" style="visibility: hidden" >               
                                    <i class="glyphicon glyphicon-exclamation-sign"></i>
                                    <label id="ReviewError"></label>
                                    <a href class="close" alert-hide=".alert">
                                        <span aria-hidden="true">&times;</span>
                                    </a> 
                                </div><br>
                                <input type='submit' name='editReview' value='submit'>
                            </form>
                            <?php
                            }
                            else{
                                
                                for($i=1; $i<= 5; $i++){
                                    if($i<=$currentRating)
                                        echo "<i class='fa fa-star'></i>";
                                    else
                                        echo "<i class='fa fa-star-o'></i>";
                                }
                                echo " ". $currentRating . " stars<br><p class='review'>" . $reviewText."</p>";
                                echo "<form id='edit' method='post' action=''> <button type='submit' name='edit' value='edit'> Edit review</button> ";
                                echo "<button type='submit' name='deleteReview' value='delete'> Delete review</button></form>";
                            }
                        }
                    }
                }
                echo "<h3 class='product-price'>Customers Reviews: </h3><br>";
               
                echo  "<div id='reviews'>";
                    if($row['numberOfReviews']>0){
                        
                        $itemid=$_GET['id'];
                        $reviewsql="SELECT * FROM `review` Where productID='". $itemid."'";
                        if(isset($_SESSION['id'])){
                            $reviewsql="SELECT * FROM `review` Where productID='". $itemid."' AND customerID <>'" . $_SESSION['id'] . "'";
                        }
                        $reviewResult=mysqli_query($con,$reviewsql);
                        try{
                            dbException($reviewResult);
                        }
                        catch(Exception $e){
                            printf("Database Error: %s\n", mysqli_error($con));
                            die();
                        }
                        if (!$reviewResult) {
                            echo "Error fetching reviews<br>";
                        }
                        else{
                            while($reviewRow = $reviewResult->fetch_assoc()){
                                $namesql="SELECT username,imagePath FROM users WHERE id='".$reviewRow['customerID']."' ";
                                $nameresult=mysqli_query($con,$namesql);
                                try{
                                    dbException($nameresult);
                                }
                                catch(Exception $e){
                                    printf("Database Error: %s\n", mysqli_error($con));
                                    die();
                                }
                                if($namerow=$nameresult->fetch_assoc()){
                            
                                    echo "<img src='" . $namerow['imagePath'] . "' class='profile-icon'> ";
                                    echo "<b><a href='profile.php?id=". $reviewRow['customerID'] ."'>" . $namerow['username'] . "</a></b><br>";
                                    for($i=1; $i<= 5; $i++){
                                        if($i<=$reviewRow['starRating'])
                                            echo "<i class='fa fa-star'></i>";
                                        else
                                            echo "<i class='fa fa-star-o'></i>";
                                    }
                                    echo " ". $reviewRow['starRating'] . " stars<br><p class='review'>" . $reviewRow['reviewText']."</p><br>";
                            
                                    //if the user clicked on reply show the textarea
                                    if(isset($_POST['addreply']) && !isset($_POST['viewreplies'])){
                                        echo "<br><img src='" . $_SESSION['imagePath'] . "' class='profile-icon'> ";
                                        echo "<b>" . $_SESSION['username'] . "</b>";
                                        ?>
                                        <form method='post' action='' onsubmit='return validateReply(this);'><br>
                                            <textarea name='replyText' rows='4' cols='50' maxlength='255' autofocus wrap='hard' placeholder='Write a reply...'></textarea>
                                            <br><br>
                                            <div class='alert alert-danger' id="ReplyAlert" style="visibility: hidden" >               
                                                <i class="glyphicon glyphicon-exclamation-sign"></i>
                                                <label id="ReplyError"></label>
                                                <a href class="close" alert-hide=".alert">
                                                    <span aria-hidden="true">&times;</span>
                                                </a> 
                                            </div><br>
                                            <button type='submit' name='reply' value='<?php echo $_POST['addreply']; ?>'>Post Reply</button>
                                        </form>
                                        <?php
                                    }//if the user is logged in show the reply button next to each message
                                    else if(isset($_SESSION['id'])){
                                        if($_SESSION['userType']=='administrator' || $_SESSION['userType']=='customer'){
                                            ?>
                                            <form method='post' action=''>
                                            <button type='submit' class='reply-btn' name='addreply' value='<?php echo $reviewRow['id']; ?>'>Reply</button>
                                            </form>
                                            <?php
                                        }
                                    }
                                    $replies_sql="SELECT * FROM reviewreply WHERE reviewID='" . $reviewRow['id'] . "'";//get all replies to this review
                                    $repliesresult=$con->query($replies_sql);
                                    try{
                                        dbException($repliesresult);
                                    }
                                    catch(Exception $e){
                                        printf("Database Error: %s\n", mysqli_error($con));
                                        die();
                                    }
                                    if($repliesresult->num_rows > 0){//if there are replies
                                        if(isset($_POST['viewreplies'])){//if the users clicks on view replies button
                                            echo "<div class='reply-div' id='reply-div'>";
                                            while($replyrows = $repliesresult->fetch_assoc()){ //get all replies
                                                $reply_usernamesql = "SELECT * FROM users WHERE id='" . $replyrows['userID'] . "'"; //select username
                                                $reply_username_result = $con->query($reply_usernamesql);
                                                try{
                                                    dbException($reply_username_result);
                                                }
                                                catch(Exception $e){
                                                    printf("Database Error: %s\n", mysqli_error($con));
                                                    die();
                                                }
                                                if($reply_username_result->num_rows > 0){ //if the query returned a username
                                                    if($username_row = $reply_username_result->fetch_assoc()){
                                                        
                                                        echo "<img src='" . $username_row['imagePath'] . "' class='profile-icon'> ";
                                                        echo "<b><a href='profile.php?id=". $username_row['id'] ."'>" . $username_row['username'] . "</a></b><br>";
                                                        echo "<p class='review'>" . $replyrows['replyText'] . "</p><br>";
                                                    }
                                                }
                                                else{
                                                    echo "<br>Error user not found";
                                                }
                                            }
                                            echo "</div>";
                                        }
                                        else if(!isset($_POST['addreply'])) { //if there are replies + the user didn't click on view replies, show the view replies button <form method='post' action=''> 
                                            ?>
                                            <form method='post' action=''>
                                            <button type='submit' class='reply-btn' name='viewreplies' value='<?php echo $reviewRow['id']; ?>'>View replies</button>
                                            </form>
                                            <?php
                                        }
                                    }
                                }
                            }
                        } 
                    }
                    else{
                        echo "<p>No current reviews for this product</p>";
                    }
                echo "</div>";

            }
            else{
                echo "Product missing<br>";
            }

            
            $con->close();
        
        ?>
    </div>


</body>
</html>