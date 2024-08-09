const videoPlayer = document.querySelector(".video-player");
const video = videoPlayer.querySelector(".video");
const playButton = videoPlayer.querySelector(".play-button");

// Play and Pause Button
playButton.addEventListener("click", (e) => {
  if (video.paused) {
    video.play();
    e.target.textContent = "&#9208;";
  } else {
    video.paused();
    e.target.textContent = "&#9654;";
  }
});
