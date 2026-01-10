<?php
session_start();
if(!isset($_SESSION['user'])) exit;

$user = $_SESSION['user'];
$videoId = $_POST['videoId'];
$timestamp = $_POST['timestamp'];

$file = "watch_history.txt";
$lines = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES) : [];
$updated = false;
$newLines = [];

foreach($lines as $line){
    list($u, $v, $t) = explode("|",$line);
    if($u == $user && $v == $videoId){
        $newLines[] = "$user|$videoId|$timestamp";
        $updated = true;
    } else {
        $newLines[] = $line;
    }
}

if(!$updated){
    $newLines[] = "$user|$videoId|$timestamp";
}

file_put_contents($file, implode("\n",$newLines));