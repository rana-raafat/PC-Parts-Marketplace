<html>
    <head>
        <link rel="stylesheet" href="Style.css">
        <title> View Investigation Request </title>
    </head>
    <?php
        session_start();
        include "Menu.php";

        function dbException($queryResult){
            if(!$queryResult){
                throw new Exception("SQL Error");
            }
            return true;
        }
        ?>
    <body>
    <div class="container">
            <div class="card justify-content-center">
                <div class="carda">
        <?php
        if(isset($_SESSION['id'])){
            if($_SESSION['userType']=='hrpartner'){

                if(isset($_POST['exit'])){
                    echo "<script>window.location.href='Home.php'</script>";
                }
                if(isset($_GET['id'])){
                    $con = new mysqli("localhost","root","", "project");
                    if(!$con){
                        echo "Error: Couldn't connect to the database<br>";
                        die();
                    }
                    $requestsql = "SELECT * FROM investigationrequest WHERE id='". $_GET['id'] . "'";
                    $requestResult = $con->query($requestsql);
                    try{
                        dbException($requestResult);
                    }
                    catch(Exception $e){
                        printf("Error: %s\n", mysqli_error($con));
                        die();
                    }
                    if($requestResult->num_rows == 0){
                        echo "Error: Request not found<br>";
                    }
                    else if($requestRow = $requestResult->fetch_assoc()){
                        echo "<h3>Investigation Request</h3>";
                        //echo "<br>";
                        echo "<text class='header'>Number " . $_GET['id'] . "</text>";
                        echo "<br><br>";

                        $auditorsql = "SELECT username FROM users WHERE id='" . $requestRow['auditorID'] . "'";
                        $auditorResult = $con->query($auditorsql);
                        try{
                            dbException($auditorResult);
                        }
                        catch(Exception $e){
                            printf("Error: %s\n", mysqli_error($con));
                            die();
                        }
                        if($auditorResult->num_rows == 0){
                            echo "Error: Auditor not found<br>";
                        }
                        else if($auditorRow = $auditorResult->fetch_assoc()){
                            echo "<text class='header2'><i class='glyphicon glyphicon-triangle-right'></i> This investigation was requested by: </text>"; 
                            echo "<br>";
                            echo "<i>" .$auditorRow['username'] . "</i>";
                            echo "<br><br>";
                        }

                        $hrsql = "SELECT username FROM users WHERE id='" . $requestRow['hrID'] . "'";
                        $hrResult = $con->query($hrsql);
                        try{
                            dbException($hrResult);
                        }
                        catch(Exception $e){
                            printf("Error: %s\n", mysqli_error($con));
                            die();
                        }
                        if($hrResult->num_rows == 0){
                            echo "Error: Hr not found<br>";
                        }
                        else if($hrRow = $hrResult->fetch_assoc()){
                            echo "<text class='header2'><i class='glyphicon glyphicon-triangle-right'></i> This request was sent to: </text>";
                            echo "<br>";
                            echo "<i>" . $hrRow['username'] . "</i>";
                            echo "<br><br>";
                        }

                        $adminsql = "SELECT username FROM users WHERE id='" . $requestRow['adminID'] . "'";
                        $adminResult = $con->query($adminsql);
                        try{
                            dbException($adminResult);
                        }
                        catch(Exception $e){
                            printf("Error: %s\n", mysqli_error($con));
                            die();
                        }
                        if($adminResult->num_rows == 0){
                            echo "Error: Admin not found<br>";
                        }
                        else if($adminRow = $adminResult->fetch_assoc()){
                            echo "<text class='header2'><i class='glyphicon glyphicon-triangle-right'></i> This investigation will be made into: </text>";
                            echo "<br>";
                            echo "<i>" . $adminRow['username'] . "</i>";
                            echo "<br><br>";
                        }

                        echo "<text class='header2'><i class='glyphicon glyphicon-triangle-right'></i> Reason for investigation: </text>";
                        echo "<br>";
                        echo "<i>" .$requestRow['reason'] . "</i>";
                        echo "<br><br>";
                        echo "<form method='post' action=''><input type='submit' name='exit' value='exit'/><form><br>";
                    }

                    $con->close();
                }
                else{
                    echo "Error: invalid link<br>";
                }
            }
        }
        ?>
        </div>
        </div>
        </div>
    </body>
</html>