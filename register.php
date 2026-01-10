<?php

header("Content-Type: application/json");

$email = trim($_POST['email'] ?? '');

$password = trim($_POST['password'] ?? '');

if (!$email || !$password) {

    echo json_encode(["success"=>false,"message"=>"All fields required"]);

    exit;

}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    echo json_encode(["success"=>false,"message"=>"Invalid email"]);

    exit;

}

if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d).{8,}$/', $password)) {

    echo json_encode([

        "success"=>false,

        "message"=>"Password must be 8+ chars with letters & numbers"

    ]);

    exit;

}

$file = "user.txt";

if (!file_exists($file)) {

    file_put_contents($file, "");

}

$users = file($file, FILE_IGNORE_NEW_LINES);

foreach ($users as $user) {

    list($storedEmail,) = explode("|", $user);

    if ($storedEmail === $email) {

        echo json_encode(["success"=>false,"message"=>"Email already registered"]);

        exit;

    }

}

file_put_contents($file, "$email|$password\n", FILE_APPEND);

echo json_encode(["success"=>true]);