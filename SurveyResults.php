<html>
    <head>
        <title>Survery Results</title>
    </head>
    <body>
    <?php   
        session_start();
        include "Menu.php";
        
        $conn = new mysqli("localhost","root","", "project");
        if(!$conn){
            echo "couldn't connect to the DataBase<br>";
             die();
        }

        $sql="SELECT * FROM survey";
        $result = mysqli_query($conn,$sql);
        if(!$result){
            echo "couldn't search inside the DataBase<br>";
            die();
        }
        ?>
        <div class="container">
            <div class="card justify-content-center">
                <div class="SurveyResults">
                    <h3 style="text-align: center";>Survey Results</h3>
                    <table class="content-table">
                        <tr>

                            <th>Customer </th>

                            <th>Rating</th>

                            <th>Suggested Improvements</th>

                            <th>age</th>


                        </tr>
                        <?php
                        while($row = $result->fetch_assoc()){

                            echo "<tr>";

                            echo "<td>";
                            $sql2="SELECT username,imagePath FROM users WHERE id='" . $row['customerID'] . "'";
                            $result2 = mysqli_query($conn,$sql2);
                            if(!$result2){
                                echo "COULDN'T SEARCH FOR THE NAME FROM THE DB<br>";
                                die();
                            }
                            while($rows = $result2->fetch_assoc()){
                                echo "<img src=". $rows['imagePath']. " class='user-pic-icon'><img>";
                                echo  $rows['username'];
                            }
                            echo "</td>";
                                                
                            echo "<td>" . $row['rating'] . "<i class='fa fa-star'></i></td>";
                        
                            echo "<td>" . $row['improvement'] . "</td>";
                        
                            echo "<td>" . $row['age'] . "</td>";

                            echo "</tr>";

                            //echo "<script>window.location.href='Home.php'</script>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    <?php
    $conn->close();     
            
    ?>
    
    </html>
    