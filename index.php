<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bookmarks reader</title>
    <style>
      body {
        font-family: sans-serif;
        color: gray;
      }
      h1 {
        font-size: 1.2em;
      }
      a {
        text-decoration: none;
      }
      a:hover , a:active {
        text-decoration: underline;
      }
      ul, li {
        list-style: none;
        padding-left: 1.2em;
      }
      ul {
        margin-bottom: 1em;
        border-left: 1px dotted white;
        padding-bottom: 0.5em;
      }
      body>ul {
        border: 0;
        width: 95%;
        margin: auto;
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
      .toggle-label:hover, .toggle:not(:checked) ~ .toggle-label {
        color: #e50;
      }
      .toggle-label:hover ~ ul, .toggle-label:hover ~ .fold {
        border-left: 1px dotted lightgrey;
      }
      .fold {
        line-height: 1.8em;
        border-left: 1px dotted lightgrey;
        border-bottom: 1px dotted lightgrey;
        font-size: .9em;
        -webkit-transition: all 0.2s linear;
        -moz-transition: all 0.2s linear;
        transition: all 0.2s linear;
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
    <h1>My bookmarks</h1>
      <?php
        include('inc/bookmarks.php');
        viewTree();
      ?>
  </body>
</html>
