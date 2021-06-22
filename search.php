<?php 

include("includes/includedFiles.php");

if(isset($_GET['term'])) {
    $term = urldecode($_GET['term']);
    
} else {
    $term = "";
}


?>

<div class="searchContainer">
    <h4>Search for an Artist, Album or Song</h4>
    <input type="text" class="searchInput" value="<?php echo $term;?>"placeholder="Start typing...." onfocus=" val = temp_value = this.value; this.value=''; this.value=temp_value" spellcheck="false" >

</div>

<script>

$(function() {
    
    let timer;
    $(".searchInput").keyup(function () {
        clearTimeout(timer);

        timer = setTimeout(function() {
           let val = $(".searchInput").val();
           openPage("search.php?term=" + val);

        }, 2000);
    }); 
    $(".searchInput").focus();
})
</script>

<div class="tracklistContainer borderBottom">
<h2>TOP SONGS</h2>
	<ul class="tracklist">
		<?php

        $songsQuery = mysqli_query($con, "SELECT id FROM Songs WHERE title LIKE '$term%' LIMIT 10");
            if(mysqli_num_rows($songsQuery) == 0) {
                echo "<span class='noResults'>No Songs Found " . $term . "</span>";
            }

			$songIdArray = array();
			$i = 1;
			while($row = mysqli_fetch_array($songsQuery)) {
                
                if($i > 15) {
                break;
                }

                array_push($songIdArray, $row['id']);

				$albumSong = new Song($con, $row['id']);
				$albumArtist = $albumSong->getArtist();

				echo "<li class='tracklistRow'>
					<div class='trackCount'>
						<img class='play' src='Assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
						<span class='trackNumber'>$i</span>
					</div>

					<div class='trackInfo'>
						<span class='trackName'>" .$albumSong->getTitle() . "</span>
						<span class='artistName'> " . $albumArtist->getName() . "</span>

					</div>

					<div class='trackOptions'>
						<img class='optionsButton' src='Assets/images/icons/more.png'>					
					</div>

					<div class='trackDuration'>
						<span class='duration'>" .$albumSong->getDuration() . "</span>
					</div>

				</li>";
				$i++;
			}
		?>

		<script>
			let tempSongIds = '<?php echo json_encode($songIdArray); ?>';
			tempPlaylist = JSON.parse(tempSongIds);


		</script>
	
	</ul>
</div>