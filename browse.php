

<?php 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
   
   include('includes/includedFiles.php'); 

   
   ?>

<h1 class="pageHeadingBig">
    You Might Also Like
</h1>

<div class="gridViewContainer">

    <?php
        $albumQuery = mysqli_query($con, "SELECT * FROM albums LIMIT 10");
        
        while($row = mysqli_fetch_array($albumQuery)) {
                
            echo "<div class='gridViewItem'>
            <span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")' >
                        <img src='" . $row['artworkPath'] . "'>
                        <div class='gridViewInfo'> " . $row['title'] . "</div>
                        </span>
                    </div>";
        }
    ?>

</div>

