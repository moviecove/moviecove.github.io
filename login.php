<?php

session_start();

header("Content-Type: application/json");

$email = trim($_POST['email'] ?? '');

$password = trim($_POST['password'] ?? '');

if (!$email || !$password) {

    echo json_encode(["success"=>false,"message"=>"Missing credentials"]);

    exit;

}

$file = "user.txt";

if (!file_exists($file)) {

    echo json_encode(["success"=>false,"message"=>"User database not found"]);

    exit;

}

$users = file($file, FILE_IGNORE_NEW_LINES);

foreach ($users as $user) {

    list($storedEmail, $storedPass) = explode("|", $user);

    if ($storedEmail === $email && $storedPass === $password) {

        $_SESSION["user"] = $email;

        echo json_encode(["success"=>true,"email"=>$email]);

        exit;

    }

}

echo json_encode(["success"=>false,"message"=>"Invalid login"]);