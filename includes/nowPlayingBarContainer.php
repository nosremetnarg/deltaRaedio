
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
        let newPlaylist = <?php echo $jsonArray; ?>;
        audioElement = new Audio();
        setTrack(newPlaylist[0], newPlaylist, false);
        updateVolumeProgressBar(audioElement.audio);

        $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
            e.preventDefault();
        })

        $('.playbackBar .progressBar').mousedown(function() {
            mouseDown = true;
        });

        $('.playbackBar .progressBar').mousemove(function(e) {
            if(mouseDown) {
                // Set time of song, depending on position of mouse
                timeFromOffset(e, this);
            }
        });
        $('.playbackBar .progressBar').mouseup(function(e) {
            timeFromOffset(e, this);

        });

        $('.volumeBar .progressBar').mousedown(function() {
            mouseDown = true;
        });

        $('.volumeBar .progressBar').mousemove(function(e) {
            if(mouseDown) {
                let percentage = e.offsetX / $(this).width();
                if(percentage >= 0 && percentage <=1) { 
                audioElement.audio.volume = percentage;
                }
            }
        });
        $('.volumeBar .progressBar').mouseup(function(e) {
            let percentage = e.offsetX / $(this).width();
            if(percentage >= 0 && percentage <=1) { 
                audioElement.audio.volume = percentage;
                }
        });

        $(document).mouseup(function() {
            mouseDown = false;
        })
        
    });

    function timeFromOffset(mouse, progressBar) {

        let percentage = mouse.offsetX / $(progressBar).width() * 100;
        let seconds = audioElement.audio.duration * ( percentage / 100 ); 
        audioElement.setTime(seconds);

    }

    function prevSong() {
        if(audioElement.audio.currentTime >= 3 || currentIndex == 0) {
            audioElement.setTime(0);
        } else {
            currentIndex = currentIndex - 1;
            setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
        }
    }

    function nextSong() {
        if(repeat == true) {
            audioElement.setTime(0);
            playSong();
            return;
        }
        if(currentIndex == currentPlaylist.length - 1) {
            currentIndex = 0;
        } else {
            currentIndex++;
        }
        let trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
        setTrack(trackToPlay, currentPlaylist, true);
    }

    function setRepeat() {
        repeat = !repeat;
        let imageName = repeat ? 'repeat-active.png' : 'repeat.png';
        $('.controlButton.repeat img').attr('src', 'Assets/images/icons/' + imageName);
    }

    function setMute() {
        audioElement.audio.muted = !audioElement.audio.muted;
        let imageName = audioElement.audio.muted ? 'volume-mute.png' : 'volume.png';
        $('.controlButton.volume img').attr('src', 'Assets/images/icons/' + imageName);
    }

    function setShuffle() {
        shuffle = !shuffle;
        let imageName = shuffle ? 'shuffle-active.png' : 'shuffle.png';
        $('.controlButton.shuffle img').attr('src', 'Assets/images/icons/' + imageName);

        if(shuffle == true) {
            //randomize playlist
            shuffleArray(shufflePlaylist);
            currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);

        } else {
            currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
        }
    }

  
    function shuffleArray(a) {
    var j, x, i;
    for (i = a.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = a[i];
        a[i] = a[j];
        a[j] = x;
    }
    return a;
}
    

    function setTrack(trackId, newPlaylist, play) {

        if(newPlaylist != currentPlaylist) {
            currentPlaylist = newPlaylist;
            shufflePlaylist = currentPlaylist.slice();
            shuffleArray(shufflePlaylist);
        }
        if (shuffle == true) {
            currentIndex = shufflePlaylist.indexOf(trackId);
        } else {
            currentIndex = currentPlaylist.indexOf(trackId);
        }
        
        pauseSong();

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
            audioElement.setTrack(track);
            
           
        } )
        if(play) {
            audioElement.play();
        }
}
    function playSong() {

        if (audioElement.audio.currentTime == 0 ) {
            $.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
        } 
        
       

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

                    <button class="controlButton shuffle" title="Shuffle Button" onclick="setShuffle()">
                    <img src="Assets/images/icons/shuffle.png" alt="Shuffle">
                    </button>

                    <button class="controlButton previous" title="Previous Button" onclick="prevSong()">
                    <img src="Assets/images/icons/previous.png" alt="Previous">
                    </button>

                    <button class="controlButton play" title="Play Button" onclick="playSong()">
                    <img src="Assets/images/icons/play.png" alt="Play">
                    </button>

                    <button class="controlButton pause" title="Pause Button" style="display: none;" onclick="pauseSong()">
                    <img src="Assets/images/icons/pause.png" alt="Pause">
                    </button>

                    <button class="controlButton next" title="Next Button" onclick="nextSong()">
                    <img src="Assets/images/icons/next.png" alt="Next">
                    </button>

                    <button class="controlButton repeat" title="Repeat Button" onclick="setRepeat()" >
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
                        
                    </span>
                </div>
            </div>
        </div>
        <div id="nowPlayingRight">
            <div class="volumeBar">
                <button class="controlButton volume" title="Volume Button" onclick="setMute()">
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