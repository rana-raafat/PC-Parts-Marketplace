<html>
    <head>
        <title>Investigation Requests</title>
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

        $sql="SELECT * FROM investigationrequest";
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
            <div class="card justify-content-center">
                <div class="List">
                    <h3 style="text-align: center";>Investigation Requests</h3>
                    <table class="table  content-table">
                        <tr>
                            <th>ID </th>
                            <th>Auditor </th>

                            <th>HRPartner</th>

                            <th>Administrator</th>

                            <th>Reason</th>


                        </tr>
                        <?php
                        while($row = $result->fetch_assoc()){

                            echo "<tr>";
                            echo "<td><a href='ViewInvestigationRequest.php?id=" . $row['id'] . "'>Request " . $row['id'] . "</a></td>";
                            echo "<td>";
                            $sql2="SELECT username,imagePath FROM users WHERE id='" . $row['auditorID'] . "'";
                            $result2 = mysqli_query($conn,$sql2);
                            try{
                                dbException($result2);
                            }
                            catch(Exception $e){
                                printf("Error: %s\n", mysqli_error($conn));
                                die();
                            }
                            
                            if($rows = $result2->fetch_assoc()){
                                echo "<img src=". $rows['imagePath']. " class='user-pic-icon'><img>";
                                echo  "<a href='Profile.php?id=". $row['auditorID'] . "'>".$rows['username'] . "</a>";
                            }
                            echo "</td><td>";

                            $sql3="SELECT username,imagePath FROM users WHERE id='" . $row['hrID'] . "'";
                            $result3 = mysqli_query($conn,$sql3);
                            try{
                                dbException($result3);
                            }
                            catch(Exception $e){
                                printf("Error: %s\n", mysqli_error($conn));
                                die();
                            }   
                            if($row3 = $result3->fetch_assoc()){
                                echo "<img src=". $row3['imagePath']. " class='user-pic-icon'><img>";
                                echo  "<a href='Profile.php?id=". $row['hrID'] . "'>".$row3['username'] . "</a>";
                            }                 
                            echo "</td><td>";
                            $sql4="SELECT username,imagePath FROM users WHERE id='" . $row['adminID'] . "'";
                            $result4 = mysqli_query($conn,$sql4);
                            try{
                                dbException($result4);
                            }
                            catch(Exception $e){
                                printf("Error: %s\n", mysqli_error($conn));
                                die();
                            }   
                            if($row4 = $result4->fetch_assoc()){
                                echo "<img src=". $row4['imagePath']. " class='user-pic-icon'><img>";
                                echo  "<a href='Profile.php?id=". $row['adminID'] . "'>".$row4['username'] . "</a>";
                            }                 
                            echo "</td>";
                        
                            echo "<td>" . $row['reason'] . "</td>";

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
    
    </html>
    