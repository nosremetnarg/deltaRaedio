<?php 
include("includes/config.php");
if(isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = $_SESSION['userLoggedIn'];
}
else {
    header("Location: register.php");
}

?>

<!DOCTYPE html>
<head>
   
    <title>Delta Raedio</title>
</head>
<body>
    Hello
</body>
</html>