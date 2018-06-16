<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bookmarks reader</title>
    <style>
      body{
        font-family: sans-serif;
      }
      a{
          text-decoration: none;
      }
      a:hover , a:active {
          text-decoration: underline;
      }
      ul, li {
        list-style: none;
        padding-left: 1.5em;
      }
      ul {
        margin-bottom: 1em;
        border-left: 1px dotted lightgrey;
        border-top: 1px dotted lightgrey;
        border-bottom: 1px dotted lightgrey;
        padding-bottom: 0.5em;
      }
      body>ul{
        border: 0;
      }
      .toggle {
        display: none;
      }
      .toggle-label {
        display: block;
        font-size: 1em;
        margin: 0.5em 0;
        cursor: pointer;
      }
      .fold {
        line-height: 1.8em;
        font-size: .9em;
        -webkit-transition: all 0.3s linear;
        -moz-transition: all 0.3s linear;
        transition: all 0.3s linear;
      }
      .toggle:checked ~ .fold {
        margin-top: -25px;
        -webkit-transform: perspective(0) rotateX(-90deg);
        -moz-transform: perspective(0) rotateX(-90deg);
        transform: perspective(0) rotateX(-90deg);
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
