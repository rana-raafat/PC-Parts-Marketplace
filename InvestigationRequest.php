<html>
    <head>
        <link rel="stylesheet" href="Style.css">
        <title> Investigation Request </title>
    </head>
    <body>
        <?php
        session_start();
        include "Menu.php";

        //use $_GET to get the hr id then use sql to get the hr name
        //at the end add the request data into the table 
        //then send the request as a message to the hr 
        //increment the investigationsmade value of this hr in the hrpartner table


        
        
        $con = new mysqli("localhost","root","", "project");
        if(!$con)
        {
            echo "couldn't connect to the DataBase<br>";
            die();
        }
        if(isset($_GET['id']))
        $HRid=$_GET['id'];
        
     
         $sql2="SELECT username FROM `users` WHERE userType='administrator'";
         $result2 = mysqli_query($con,$sql2);
        if ($result2->num_rows == 0) {
            echo "There are no Administrators at the moment<br>";
        }
        else{
           
           echo"<form method='post'>"; 
            echo "<Select name='admins'style='color:black;>";
            echo "<option value='' selected>Choose Admin</option>";
            while($row = $result2->fetch_assoc()){
                echo "<option value='". $row['username'] ."'>". $row['username'] ."</option>";
            }
            echo "</Select>";
            echo "<br>";echo "<br>";echo "<br>";echo "Write your problem";echo "<br>";
            
              echo "<textarea name='textarea' id='Textarea1'style='color:black; rows='5' cols='30'></textarea>";
              echo "<input type='Submit' name='submit'>";
              echo"<br>";
              echo"</form>"; 
              if(isset($_POST["submit"])){
                $reason=$_POST["textarea"];
                $admin=$_POST["admins"];
                $sql="SELECT id FROM `users` WHERE username='$admin'";
                $result=mysqli_query($con,$sql);
                $row2=$result->fetch_assoc();
                echo"$row2[id]";
                $insert="INSERT INTO investigationrequest( auditorID, hrID, adminID, reason) VALUES  ('".$_SESSION['id']."','$HRid','" . $row2['id'] . "','" . $reason . "')";
                $result3=mysqli_query($con,$insert);
                if (!$result3) {
                    printf("Error: %s\n", mysqli_error($con));
                    exit();
                }
                echo "$reason <br>";
               echo"$admin";    
              }
               
            }
         
    
       

        
        ?>
    </body>
</html>