<html>
    <head>  
        <title> Sign Out </title>
    </head>
    <body>
        <?php
            session_start();
            include "Menu.php";
        
            if(isset($_POST['Yes']))
            {
                session_destroy();
                echo "<script>window.location.href='Home.php'</script>";
            }   

            if(isset($_POST['No']))
            {
                echo "<script> 
                        $('#signOutModal .close').click(); 
                        window.history.go(-1);
                      </script>";
                
            }      
        ?>
    </body>
</html>
