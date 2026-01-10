<?php

$file="support.json";

if(!file_exists($file)){

  file_put_contents($file,"{}");

}

$data=json_decode(file_get_contents($file),true);

if($_SERVER["REQUEST_METHOD"]==="GET"){

  $user=$_GET["user"] ?? "";

  echo json_encode($data[$user] ?? []);

  exit;

}

$input=json_decode(file_get_contents("php://input"),true);

$user=$input["user"];

$text=$input["text"];

$from = isset($input["admin"]) ? "admin" : "user";

$data[$user][]=[

  "from"=>$from,

  "text"=>$text,

  "time"=>time()

];





file_put_contents($file,json_encode($data));

echo json_encode(["ok"=>true]);