var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
let timer;

$(document).click(function(click) {
	let target = $(click.target);

	if(!target.hasClass("item") && !target.hasClass("optionsButton")) {
		hideOptionsMenu();
	}
})

$(window).scroll(function() {
	hideOptionsMenu();
});

$(document).on("change", "select.playlist", function() {
	let playlistId = $(this).val();
	let songId = $(this).prev(".songId").val();
	console.log("playlistId: " + playlistId); 
	console.log("songId: " + songId); 
});

function openPage(url) {
	if (timer != null) {
		clearTimeout(timer);
	}
	if(url.indexOf("?") == -1) {
		url = url + "?";
	}

	var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
	console.log(encodedUrl);
	$("#mainContent").load(encodedUrl);
	$("body").scrollTop(0);
	history.pushState(null, null, url);
}

function createPlaylist() {
	
	let popup = prompt('Please enter the name of your playlist');

	if(popup != null) {
		
		$.post("includes/handlers/ajax/createPlaylist.php", { name: popup, username: userLoggedIn })
		.done(function(error) {
			// do something when ajax returns

			if(error != "") {
				alert(error);
				return
			}

			openPage("yourMusic.php");
		})
	}
}

function deletePlaylist(playlistId) {
	let prompt = confirm('Are you sure you want to delete this playlist?');

	if(prompt) {
		$.post("includes/handlers/ajax/deletePlaylist.php", { playlistId: playlistId })
		.done(function(error) {

			if(error != "") {
				alert(error);
				return
			}
			// do something when ajax returns
			openPage("yourMusic.php");
		})
	}
}

function playFirstSong() {
	setTrack(tempPlaylist[0], tempPlaylist, true);
}

function hideOptionsMenu() {
	let menu = $(".optionsMenu");
	if(menu.css("display") != "none") {
		menu.css("display", "none" );
	}
}

function showOptionsMenu(button) {

	let songId = $(button).prevAll(".songId").val();
	let menu = $(".optionsMenu");
	let menuWidth = menu.width();
	menu.find(".songId").val(songId);

	let scrollTop = $(window).scrollTop(); // distance from top of window to top of document
	let elementOffset = $(button).offset().top; // distance from top of document
	let top = elementOffset - scrollTop;
	let left = $(button).position().left;

	menu.css({ "top": top + "px", "left" : left - menuWidth + "px", "display": "inline" });


}

function formatTime(seconds) {
	var time = Math.round(seconds);
	var minutes = Math.floor(time / 60); //Rounds down
	var seconds = time - (minutes * 60);

	var extraZero = (seconds < 10) ? "0" : "";

	return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
	$(".progressTime.current").text(formatTime(audio.currentTime));
	$(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

	var progress = audio.currentTime / audio.duration * 100;
	$(".playbackBar .progress").css("width", progress + "%");
}

function updateVolumeProgressBar(audio) {
	var volume = audio.volume * 50;
	$(".volumeBar .progress").css("width", volume + "%");
}

function Audio() {

	this.currentlyPlaying;
	this.audio = document.createElement('audio');

	this.audio.addEventListener("ended", function() {
		nextSong();
	});

	this.audio.addEventListener("canplay", function() {
		//'this' refers to the object that the event was called on
		var duration = formatTime(this.duration);
		$(".progressTime.remaining").text(duration);
	});

	this.audio.addEventListener("timeupdate", function(){
		if(this.duration) {
			updateTimeProgressBar(this);
		}
	});

	this.audio.addEventListener("volumechange", function() {
		updateVolumeProgressBar(this);
	});

	this.setTrack = function(track) {
		this.currentlyPlaying = track;
		this.audio.src = track.path;
	}

	this.play = function() {
		this.audio.play();
	}

	this.pause = function() {
		this.audio.pause();
	}

	this.setTime = function(seconds) {
		this.audio.currentTime = seconds;
	}

}