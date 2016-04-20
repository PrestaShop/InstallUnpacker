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
    case 'logo':
      header('Content-Type: image/png');
      echo base64_decode('logo.png');
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
  <img src="index.php?element=logo" style="width: 400px;" />
  <div id="content">
    <div>
      <svg fill="#DF0067" height="96" viewBox="0 0 24 24" width="96" style="display:inline-block;" xmlns="http://www.w3.org/2000/svg">
          <path d="M0 0h24v24H0z" fill="none"/>
          <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
      </svg>

      <svg fill="#251B5B" height="64" viewBox="0 0 24 24" width="64" style="display:inline-block; margin-bottom:16px" xmlns="http://www.w3.org/2000/svg">
          <path d="M0 0h24v24H0z" fill="none"/>
          <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
      </svg>

      <svg fill="#DF0067" height="96" viewBox="0 0 24 24" width="96" style="display:inline-block;" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 0h24v24H0z" fill="none"/>
        <path d="M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z"/>
      </svg>
    </div>
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
