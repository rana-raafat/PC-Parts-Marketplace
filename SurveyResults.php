<html>
    <head>
        <title>Survery Results</title>
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
        
        $conn = new mysqli("localhost","root","", "project");
        if(!$conn){
            echo "couldn't connect to the DataBase<br>";
             die();
        }

        $sql="SELECT * FROM survey";
        $result = mysqli_query($conn,$sql);
        try{
            dbException($result);
        }
        catch(Exception $e){
            printf("Error: %s\n", mysqli_error($conn));
            die();
        }
        
        ?>
        <div class="container">
            <div class="card">
                <div class="SurveyResults">
                    <h3 class="text-center";>Survey Results</h3>
                    <table class="custom-table">
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
                            try{
                                dbException($result2);
                            }
                            catch(Exception $e){
                                printf("Error: %s\n", mysqli_error($conn));
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

                            
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    <?php
    $conn->close();     
            
    ?>
    </body>
    </html>
    