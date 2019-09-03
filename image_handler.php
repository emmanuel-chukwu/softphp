<?php

  header('Access-Control-Allow-Origin: *'); 
  header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, X-Auth-Token, Accept");
  header("Access-Control-Allow-Methods: GET, POST, DELETE, PATCH, PUT, OPTIONS");
  header('Content-Type: text/plain');


  //include other origins
  $accepted_origins = array("http://localhost");

  $imageFolder = "assets/images/";
  reset($_FILES);
  $temp = current($_FILES);

  if (is_uploaded_file($temp['tmp_name'])){
    if (isset($_SERVER['HTTP_ORIGIN'])) {
      if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
      } 
      else {
        header("HTTP/1.1 403 Origin Denied");
        return;
      }
    }

    
    if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
        header("HTTP/1.1 400 Invalid file name.");
        return;
    }

    if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png", "txt"))) {
        header("HTTP/1.1 400 Invalid extension.");
        return;
    }                                                 
    
    
    $base64image = file_get_contents($temp['tmp_name']);
        
    $data = explode( ';base64,', $base64image );
    
    if (count($data) < 2) die(json_encode(array('location' => "Invalid base64 image")));
    
    $file_type = explode("image/", $data[0]);
    
    $file_name = substr(md5(rand(1, 213213212)), 1, 5) . "_" . str_replace(array('\'', '"', ' ', '`'), '_', $_FILES['file']['name']);
  
    $imageName = $file_name . "-" . time() . "." . $file_type[1];

    $temp_dir = $imageFolder . $imageName;
    
    $image_base64 = base64_decode($data[1]);

    file_put_contents($temp_dir, $image_base64);
      
    echo json_encode(array('location' => $temp_dir));
    
  } 
  else {
    header("HTTP/1.1 500 Server Error");
  }
?>
