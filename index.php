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
    <div id="mainContainer">
        <div id="topContainer">

            <div id="navBarContainer">
                <nav class="navBar"> 
                    <a href="index.php" class="logo">
                        <img src="Assets/images/icons/radio.png">
                    </a>

                    <div class="group">
                        <div class="navItem">
                            <a href="search.php" class="navItemLink">Search</a>
                            <img src="Assets/images/icons/search.png" alt="Search" class="icon">
                        </div>
                    </div>

                    <div class="group">
                    <div class="navItem">
                            <a href="browse.php" class="navItemLink">Browse</a>
                        </div>
                        <div class="navItem">
                            <a href="yourMusic.php" class="navItemLink">Your Music</a>
                        </div>
                        <div class="navItem">
                            <a href="profile.php" class="navItemLink">Profile</a>
                        </div>
                    </div>

                </nav>
            </div>
        
        </div>
        <div id="nowPlayingBarContainer">
            <div id="nowPlayingBar">

                <div id="nowPlayingLeft">

                    <div class="content">
                        <span class="albumLink">
                            <img src="https://cdn-skill.splashmath.com/panel-uploads/GlossaryTerm/da5a861feb0e4bee9ca440a8751bca03/1547802408_square-shape.png" class="albumArtwork">
                        </span>

                        <div class="trackInfo">
                            <span class="trackName">
                                <span>Happy Birthday</span>
                            </span>
                            <span class="artistName">
                                <span>Grant Emerson</span>
                            </span>
                            
                        </div>

                    </div>

                </div>

                <div id="nowPlayingCenter">
                    <div class="content playerControls">

                        <div class="buttons">

                            <button class="controlButton shuffle" title="Shuffle Button">
                            <img src="Assets/images/icons/shuffle.png" alt="Shuffle">
                            </button>

                            <button class="controlButton previous" title="Previous Button">
                            <img src="Assets/images/icons/previous.png" alt="Previous">
                            </button>

                            <button class="controlButton play" title="Play Button">
                            <img src="Assets/images/icons/play.png" alt="Play">
                            </button>

                            <button class="controlButton pause" title="Pause Button" style="display: none;">
                            <img src="Assets/images/icons/pause.png" alt="Pause">
                            </button>

                            <button class="controlButton next" title="Next Button">
                            <img src="Assets/images/icons/next.png" alt="Next">
                            </button>

                            <button class="controlButton repeat" title="Repeat Button">
                            <img src="Assets/images/icons/repeat.png" alt="Repeat">
                            </button>

                        </div>

                        <div class="playbackBar">
                            <span class="progressTime current">
                                0:00
                            </span>
                            <div class="progressBar">

                                <div class="progressBarBg">
                                    <div class="progress">

                                    </div>
                                </div>

                            </div>
                            <span class="progressTime remaining">
                                0:00
                            </span>
                        </div>
                    </div>
                </div>
                <div id="nowPlayingRight">
                    <div class="volumeBar">
                        <button class="controlButton volume" title="Volume Button">
                            <img src="Assets/images/icons/volume.png" alt="Volume">
                        </button>

                        <div class="progressBar">
                            <div class="progressBarBg">
                                <div class="progress">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    

</body>
</html>