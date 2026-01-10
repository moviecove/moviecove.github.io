let player;
let updateInterval;

// Called automatically by YouTube API
function onYouTubeIframeAPIReady() {
  player = new YT.Player('ytPlayer', {
    height: '180',
    width: '320',
    playerVars: { autoplay: 1, controls: 0, modestbranding: 1 }
  });
}

// Play a movie in the floating popup player
async function playMovie(videoId, title) {
  document.getElementById("playerTitle").innerText = title;
  document.getElementById("playerBox").classList.remove("hidden");

  // Load last saved progress
  const lastTime = await loadProgress(videoId);

  player.loadVideoById({
    videoId: videoId,
    startSeconds: lastTime
  });

  // Clear any previous interval
  clearInterval(updateInterval);

  // Save progress every 5 seconds
  updateInterval = setInterval(() => {
    const currentTime = Math.floor(player.getCurrentTime());
    saveProgress(videoId, currentTime);
  }, 5000);
}

// Close the floating player
function closePlayer() {
  if (player) player.stopVideo();
  document.getElementById("playerBox").classList.add("hidden");
  clearInterval(updateInterval);
}

// Minimize / reduce the player height
function toggleMini() {
  const box = document.getElementById("playerBox");
  if(box.style.height === "45px") {
    box.style.height = "180px";
  } else {
    box.style.height = "45px";
  }
}

// Rotate / switch between portrait & landscape
function rotatePlayer() {
  document.getElementById("playerBox").classList.toggle("landscape");
}

// ========================
// CONTINUE WATCHING FUNCTIONS
// ========================

// Save current progress to server
async function saveProgress(videoId, timestamp) {
  try {
    await fetch("save_progress.php", {
      method: "POST",
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `videoId=${videoId}&timestamp=${timestamp}`
    });
  } catch (err) {
    console.error("Failed to save progress", err);
  }
}

// Load last progress from server
async function loadProgress(videoId) {
  try {
    const res = await fetch("load_progress.php?videoId=" + videoId);
    const seconds = await res.text();
    return parseInt(seconds) || 0;
  } catch (err) {
    console.error("Failed to load progress", err);
    return 0;
  }
}

// ========================
// OPTIONAL: Drag the player
// ========================

const playerBox = document.getElementById("playerBox");
let isDragging = false;
let offsetX, offsetY;

playerBox.addEventListener("mousedown", function(e) {
  isDragging = true;
  offsetX = e.clientX - playerBox.offsetLeft;
  offsetY = e.clientY - playerBox.offsetTop;
});

document.addEventListener("mousemove", function(e) {
  if(isDragging) {
    playerBox.style.left = (e.clientX - offsetX) + "px";
    playerBox.style.top = (e.clientY - offsetY) + "px";
  }
});

document.addEventListener("mouseup", function() {
  isDragging = false;
});