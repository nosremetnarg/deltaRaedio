
let currentPlaylist = [];
let audioElement;
let mouseDown = false;

function formatTime(seconds) {
    let time = Math.round(seconds);
    let minute = Math.floor(time / 60);
    let second = time - (minute * 60);

    let extraZero;

    if(second < 10) {
        extraZero = "0";
    } else {
        extraZero = "";
    }

    return minute + ":" + extraZero + second;

}

function updateTimeProgressBar(audio) {
    $('.progressTime.current').text(formatTime(audio.currentTime));
    $('.progressTime.remaining').text(formatTime(audio.duration - audio.currentTime));

    let progress = audio.currentTime / audio.duration * 100;
    $('.playbackBar .progress').css("width", progress + "%");
}

function Audio() {

    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    this.audio.addEventListener("canplay", function() {
        let duration = formatTime(this.duration)

        $('.progressTime.remaining').text(duration);
    });

    this.audio.addEventListener("timeupdate", function() {
        if(this.duration) {
            updateTimeProgressBar(this);
        }
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