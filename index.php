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
    <link rel="stylesheet" type="text/css" href="Assets/css/style.css">
    
</head>
<body>
    
    <div id="nowPlayingBarContainer">
        <div id="nowPlayingBar">
        
        </div>
    </div>

</body>
</html>