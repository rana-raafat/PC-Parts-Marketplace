<html>
<head>
    <link rel="stylesheet" href="Style.css">
    <title>redirecting to product</title>
</head>
<body>
<?php
    $cookie_name = "user";
    $cookie_value = "John Doe";
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
?>
</body>
</html>