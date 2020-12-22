<!-- JKA -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Images | Random image generator</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="box">
    <form action="" method="GET">

      <?php
      $fp = fopen("words.txt", 'r');
      if ($fp) {
        $array = explode("\n", fread($fp, filesize("words.txt")));
      }
      $rand = rand(1, count($array));
      $word =  $array[$rand];
      ?>

      <div>
        <input type="hidden" name="query" placeholder="Search Images (e.g: animal,human,cat...)" value="<?php echo !empty($word) ? $word : 'cat' ?>">
        <input type="submit" name="picture" value="Generate Random Images">
      </div>

    </form>
  </div>
  <?php

  include_once "simplehtmldom_1_9_1/simple_html_dom.php";

  if (isset($_GET['picture'])) {
    if (isset($_GET['query']) && !empty($_GET['query'])) {
      $query = $_GET['query'];
      echo "<h2>Random Images For: " . $query . "</h2><br>";

      // from google
      $html = file_get_html('https://www.google.com/search?q=' . $query . '&rlz=1C1NHXL_enPK836PK836&sxsrf=ALeKk006mXoqNC0SE_ptnW4_-2iVTwCcIw:1608576584874&source=lnms&tbm=isch&sa=X&ved=2ahUKEwjiur3f3t_tAhXYQhUIHZrCAFsQ_AUoA3oECCMQBQ&biw=667&bih=640');
      $imgs = $html->find('img');
      foreach ($imgs as $element) {
        echo "<img src='$element->src'>";
      }

      //Wikipedia
      $wikilink = "http://en.wikipedia.org/wiki/" . $query . "";
      $html = file_get_html($wikilink);
      if ($html) {
        $images_array = array();
        foreach ($html->find('table.infobox vcard td, img') as $element) {
          $allimages = strtok($element->src . '|', '|');
          array_push($images_array, $allimages);
        }
        if (!empty($images_array)) {
          foreach ($images_array as $element) {
            echo "<img src='$element'>";
          }
        }
      }

      // some site
      $html = file_get_html('https://www.freeimages.com/search/' . $query . '');
      $imgs = $html->find('img');
      for ($i = 0; $i < count($imgs) - 2; $i++) {
        $img = $imgs[$i]->src;
        echo "<img src='$img'>";
      }

      // some site
      $html = file_get_html('https://all-free-download.com/free-photos/' . $query . '.html');
      $imgs = $html->find('img');
      for ($i = 0; $i < count($imgs) - 2; $i++) {
        $img = $imgs[$i]->src;
        echo "<img src='$img'>";
      }

      // some site
      $html = file_get_html('https://burst.shopify.com/photos/search?utf8=%E2%9C%93&q=' . $query . '');
      $imgs = $html->find('img');
      for ($i = 0; $i < count($imgs) - 54; $i++) {
        $img = $imgs[$i]->src;
        echo "<img src='$img'>";
      }

      // some site
      $html = file_get_html('https://www.everypixel.com/search?q=' . $query . '&meaning=&stocks_type=free&media_type=0&page=1');
      $imgs = $html->find('img');
      for ($i = 0; $i < count($imgs) - 54; $i++) {
        $img = $imgs[$i]->src;
        echo "<img src='$img'>";
      }
    } else {
      echo "<h2>Click Again :(</h2>";
    }
  }
  ?>

</body>

</html>
