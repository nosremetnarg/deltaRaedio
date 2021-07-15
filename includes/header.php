<?php 
include("includes/config.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");

if(isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = $_SESSION['userLoggedIn'];
    echo "<script>
 userLoggedIn = '$userLoggedIn';
 </script>";
       
}
else {
    header("Location: register.php");
}
?>

<!DOCTYPE html>
<head>
    <title>Delta Raedio</title>
    <link rel="stylesheet" type="text/css" href="Assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src='Assets/js/script.js'></script>
    
</head>
<body>


    <div id="mainContainer">
    
        <div id="topContainer">

             <?php include('includes/navBarContainer.php')?>
        
            <div id="mainViewContainer">

                <div id="mainContent">