<?php

set_time_limit(0);

define('ZIP_NAME', 'package.zip');
define('TARGET_FOLDER', __DIR__.'/');

if (isset($_POST['extract'])) {

  $zip = new ZipArchive();
  $zip->open('package.zip');
  if (!$zip->extractTo(TARGET_FOLDER)) {
    die(json_encode([
      'error' => true,
      'message' => 'An error occured during the extraction',
    ]));
  }

  die(json_encode([
    'error' => false,
  ]));
}

if (isset($_GET['element'])) {
  switch ($_GET['element']) {
    case 'font':
      header('Content-Type: application/font-sfnt');
      echo base64_decode('OpenSans-Regular.ttf');
      break;
    case 'css':
      header('Content-Type: text/css');
      echo base64_decode('style.css');
      break;
    case 'jquery':
      header('Content-Type: text/javascript');
      echo base64_decode('jquery-2.2.3.min.js');
      break;
  }
  exit;
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>PrestaShop installation</title>
  <link rel="stylesheet" type="text/css" href="index.php?element=css">
</head>
<body>
  <div id="content">
    <div>
      <svg fill="#6C868E" height="96" viewBox="0 0 24 24" width="96" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 0h24v24H0z" fill="none"/>
        <path d="M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z"/>
      </svg>
    </div>
    <p>Please wait while we are preparing the installation</p>
    <div class="spinner">
      <div class="bounce1"></div>
      <div class="bounce2"></div>
      <div class="bounce3"></div>
    </div>
    <div id="error"></div>
  </div>
  <script type="text/javascript" src="index.php?element=jquery"></script>
  <script type="text/javascript">
    $(function() {

      var request = $.ajax({
        method: "POST",
        url: "index.php",
        data: {
          extract: true,
        },
        dataType: 'json'
      });

      request.done(function(msg) {
        if (msg.fail) {
          $('#error').html('An error has occured : <br />'+msg.message);
          $('.spinner').remove();
        } else {
          location.reload();
        }
      });

      request.fail(function() {
        $('#error').html('An error has occured');
        $('.spinner').remove();
      });

    });
  </script>
</body>
</html>
