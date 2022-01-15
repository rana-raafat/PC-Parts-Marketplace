<html>
    <head>
        <link rel="stylesheet" href="Style.css">
        <title> View Investigation Request </title>
    </head>
    <?php
        session_start();
        include "Menu.php";
        ?>
    <body>
    <div class="container">
            <div class="card justify-content-center">
                <div class="carda">
        <?php
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
            if($requestResult->num_rows == 0){
                echo "Error: Request not found<br>";
            }
            else if($requestRow = $requestResult->fetch_assoc()){
                echo "<h1>Investigation Request " . $_GET['id'] . "</h1>";

                $auditorsql = "SELECT username FROM users WHERE id='" . $requestRow['auditorID'] . "'";
                $auditorResult = $con->query($auditorsql);
                if($auditorResult->num_rows == 0){
                    echo "Error: Auditor not found<br>";
                }
                else if($auditorRow = $auditorResult->fetch_assoc()){
                    echo "This investigation was requested by: " . $auditorRow['username'] . "<br>";
                }

                $hrsql = "SELECT username FROM users WHERE id='" . $requestRow['hrID'] . "'";
                $hrResult = $con->query($hrsql);
                if($hrResult->num_rows == 0){
                    echo "Error: Hr not found<br>";
                }
                else if($hrRow = $hrResult->fetch_assoc()){
                    echo "This request was sent to: " . $hrRow['username'] . "<br>";
                }

                $adminsql = "SELECT username FROM users WHERE id='" . $requestRow['adminID'] . "'";
                $adminResult = $con->query($adminsql);
                if($adminResult->num_rows == 0){
                    echo "Error: Admin not found<br>";
                }
                else if($adminRow = $adminResult->fetch_assoc()){
                    echo "This investigation will be made into: " . $adminRow['username'] . "<br>";
                }

                echo "Reason for investigation: " . $requestRow['reason'] . "<br>";
                echo "<form method='post' action=''><input type='submit' name='exit' value='exit'/><form><br>";
            }

            $con->close();
        }
        else{
            echo "Error: invalid link<br>";
        }
        ?>
        </div>
        </div>
        </div>
    </body>
</html>