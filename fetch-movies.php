<?php
$API_KEY = "AIzaSyDjjGTcw6Of1SKLSkAsLVcD82iNyPCh7yM";
$query = "latest full movie";
$maxResults = 12;

$url = "https://www.googleapis.com/youtube/v3/search?
part=snippet
&type=video
&videoDuration=long
&maxResults=$maxResults
&q=".urlencode($query)."
&key=$API_KEY";

$response = file_get_contents($url);
$data = json_decode($response, true);

$movies = [];

foreach ($data['items'] as $item) {
  $movies[] = [
    "title" => $item['snippet']['title'],
    "poster" => $item['snippet']['thumbnails']['high']['url'],
    "videoId" => $item['id']['videoId']
  ];
}

file_put_contents("data/movies.json", json_encode($movies, JSON_PRETTY_PRINT));

echo "Movies updated successfully";