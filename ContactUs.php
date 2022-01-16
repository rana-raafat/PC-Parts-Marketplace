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
$con = new mysqli("localhost", "root", "", "project");

if(!$con){
    echo "connection error<br>";
    die();
}
$sql= "SELECT imagePath,username,userType,id FROM users WHERE userType='hrpartner' OR userType='auditor' OR userType='administrator'";
$result = mysqli_query($con,$sql);
if ($result->num_rows == 0) {
    echo "No results found<br>";
}
?>
        <div class='container'>
            <div class='card justify-content-center'>
                <div class="ContactUs">
                    <div class="List">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>Name</th> 
                                    <th>Position</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while($row = $result->fetch_assoc()){
                                    ?>
                                    <tr>
                                        <td>
                                            <?php
                                            echo "<img src=". $row['imagePath']. " class='user-pic-icon'>";
                                            echo "<a href=profile.php?id=" . $row['id'] . "> " . $row['username'] . "</a>";
                                            ?> 
                                        </td>
                                        <td>
                                            <i class="fa fa-user"></i>
                                            <?php
                                            echo $row['userType'];
                                            ?> 
                                        </td>
                                        <td> 
                                            <?php
                                            echo "<a href=Chat.php?id=". $row['id'] . ">Send a Message</a>";
                                            ?> 
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <button onclick="location.href='SuggestProduct.php'">Suggest a Product</button>
                    <br>
                </div>
            </div>
        </div>

    </body>
</html>
