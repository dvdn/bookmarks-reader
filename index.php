<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bookmarks reader</title>
    <style>
      ul, li {
          padding-bottom: .5em;
      }
    </style>
  </head>
  <body>
    <h1>Bookmarks</h1>
    <?php
        include('bookmarks.php');
        viewTree();
    ?>
  </body>
</html>
