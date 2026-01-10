<?php
session_start();
if(!isset($_SESSION['user'])) exit;

$user = $_SESSION['user'];
$videoId = $_GET['videoId'];
$file = "watch_history.txt";

if(!file_exists($file)) exit("0");

$lines = file($file, FILE_IGNORE_NEW_LINES);

foreach($lines as $line){
    list($u, $v, $t) = explode("|",$line);
    if($u == $user && $v == $videoId){
        echo $t;
        exit;
    }
}

echo "0";