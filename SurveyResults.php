<html>
<head>
        <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
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
     /*   echo "<table border='1'>
            <tr>

            <th>Name </th>

            <th>CustomerID </th>

            <th>Rating</th>

            <th>Suggested Improvements</th>

            <th>age</th>


            </tr>";
*/
            ?>
        <body>

        <table class="content-table">
        
        <thead>
          <tr >
            <th >Name </th>

            <th>CustomerID </th>

            <th>Rating</th>

            <th>Suggested Improvements</th>

            <th>age</th>
    
            </tr>
            </thead>
            <tbody>
					<tr>
						<td>John</td>
						<td>Salma</td>
						<td>Ahmed</td>
					</tr>
					<tr>
						<td>Michael</td>
						<td>Salwa</td>
						<td>Saed</td>
					</tr>
					<tr>
						<td>Asma</td>
						<td>Lobna</td>
						<td>Mohammed</td>
					</tr>
				</tbody>
    </table>

    </body>

            <?php
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

            //echo "<script>window.location.href='Home.php'</script>";
        }
       // echo "</table>";

    $conn->close();     
            
    ?>
    
    </html>
    