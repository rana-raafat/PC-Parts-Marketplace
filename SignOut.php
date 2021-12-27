<html>
    <head>
        <link rel="stylesheet" href="Style.css">
        <title> Sign Out </title>
    </head>
    <body>

    <?php
        session_start();
        include "Menu.php";
        if(isset($_POST['Yes']))
        {
            session_destroy();
            header("Location:home.php");
        }

        if(isset($_POST['No']))
        {
            header("Location:home.php");
        }

    ?>

<form action="" method="post">

Are you sure you want to SignOut your account Yes/No<br>

<input type="submit" name="Yes" value="Yes"/>
<input type="submit" name="No" value="No"/>
</form>
</body>
</html>