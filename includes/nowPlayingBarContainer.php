
<?php
    $songQuery = mysqli_query($con, "SELECT * FROM Songs ORDER BY RAND() LIMIT 10");
    $resultArray = array();

    while($row = mysqli_fetch_array($songQuery)) {
        array_push($resultArray, $row['id']);

    }

    $jsonArray = json_encode($resultArray);
?>

<script>
    
    $(document).ready(function() {
        currentPlaylist = <?php echo $jsonArray; ?>;
        audioElement = new Audio();
       // document.querySelector("body").addEventListener("click", setTrack);
        setTrack(currentPlaylist[0], currentPlaylist, false);
        
    });

    function setTrack(trackId, newPlaylist, play) {

        $.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data){

            let track = JSON.parse(data);
            $(".trackName span").text(track.title);

            $.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data){
                let artist = JSON.parse(data);
                $(".artistName span").text(artist.name);
                
            });

            $.post("includes/handlers/ajax/getArtworkJson.php", { albumId: track.album }, function(data){
                let album = JSON.parse(data);
                $(".albumLink img").attr("src", album.artworkPath);
                
            });
            audioElement.setTrack(track.path);
            audioElement.play();
        } )
        if(play) {
            audioElement.play();
        }
}
    function playSong() {
        $('.controlButton.play').hide();
        $('.controlButton.pause').show();
        audioElement.play();

    }
    function pauseSong() {
        $('.controlButton.play').show();
        $('.controlButton.pause').hide();
        audioElement.pause();
    }


// document.querySelector("body").addEventListener("click", setTrack);



</script>



<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">

        <div id="nowPlayingLeft">

            <div class="content">
                <span class="albumLink">
                    <img src="" class="albumArtwork">
                </span>

                <div class="trackInfo">
                    <span class="trackName">
                        <span></span>
                    </span>
                    <span class="artistName">
                        <span></span>
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

                    <button class="controlButton play" title="Play Button" onclick="playSong()">
                    <img src="Assets/images/icons/play.png" alt="Play">
                    </button>

                    <button class="controlButton pause" title="Pause Button" style="display: none;" onclick="pauseSong()">
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