fetch("data/movies.json")
.then(res => res.json())
.then(movies => {
  const container = document.querySelector(".movies");
  container.innerHTML = "";

  movies.forEach(movie => {
    const img = document.createElement("img");
    img.src = movie.poster;
    img.onclick = () => canPlay(movie.videoId, movie.title);
    container.appendChild(img);
  });
});