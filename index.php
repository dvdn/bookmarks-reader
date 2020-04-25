<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bookmarks reader</title>
    <link rel="stylesheet" href="inc/main.css">
  </head>
  <body>
    <h1>My bookmarks</h1>
      <?php
        include('inc/bookmarks.php');
        viewTree();
      ?>
    <footer>2020 // source code <a target="_blank" href="https://github.com/dvdn/bookmarks-reader">dvdn/bookmarks-reader</a></footer>
  </body>
</html>
