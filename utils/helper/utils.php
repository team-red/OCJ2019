<?php

function check_page($page_name, $valid_pages){
    foreach ($valid_pages as $page) {
        if ($page["name"] === $page_name) {
            return true;
        }
    }
    return false;
}

function get_page_title($page_name, $valid_pages){
    // called only if page exists in valid_pages
    foreach ($valid_pages as $current_page) {
        if ($current_page["name"] === $page_name) {
            return $current_page["title"];
        }
    }
}

function generate_header($page_name, $sheet_path, $script_path, $valid_pages){
    $title = get_page_title($page_name, $valid_pages);
    $script_tag = $script_path === "" ? "" : "<script src='$script_path'></script>";
    echo <<<flag
  <head>
      <title>$title</title>
      <meta name="author" content="team-red">
      <meta name="keywords" content="manga">
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- icons stylesheet -->
      <link rel="stylesheet" href="css/icons.css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
      <!-- Bootstrap CSS -->
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="$sheet_path">
      <script src="js/jquery.min.js"></script>
      $script_tag
  </head>
flag;
}

?>