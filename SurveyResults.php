<html>
    
    <?php   
        session_start();
        include "Menu.php";
        

        $conn = new mysqli("localhost","root","", "project");
        if(!$conn){
            echo "couldn't connect to the DataBase<br>";
             die();
        }

        /*

        */
        $sql="SELECT * FROM survey";
        $result = mysqli_query($conn,$sql);
        if(!$result){
            echo "couldn't search inside the DataBase<br>";
            die();
        }
        echo "<table border='1'>
            <tr>

            <th>Name </th>

            <th>CustomerID </th>

            <th>rating</th>

            <th>improvement</th>

            <th>age</th>


            </tr>";
        while($row = $result->fetch_assoc()){

            echo "<tr>";

            $sql2="SELECT username FROM users WHERE id='" . $row['customerID'] . "'";
            $result2 = mysqli_query($conn,$sql2);
            if(!$result2){
                echo "COULDN'T SEARCH FOR THE NAME FROM THE DB<br>";
                die();
            }
    
            while($rows = $result2->fetch_assoc()){
                echo "<td>" . $rows['username'] . "</td>";
            }
           
            echo "<td>" . $row['customerID'] . "</td>";
          
            echo "<td>" . $row['rating'] . "</td>";
          
            echo "<td>" . $row['improvement'] . "</td>";
          
            echo "<td>" . $row['age'] . "</td>";

            echo "</tr>";

            //header("Location:Home.php");
        }
        echo "</table>";

    $conn->close();


                

            
            
    ?>
    
    </html>
    