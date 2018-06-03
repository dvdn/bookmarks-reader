<?php

define('DIR', '/bookmarks');

/**
 * View tree
 *
 * @param string $dir name
 * @return string Html
 */
function viewTree($dir=DIR) {
    echo '<ul id="explorer">';

    foreach (getContentTree($dir) as $item) {
        echo '<li>';
        view($item);
        echo '</li>';
    }

    echo '</ul>';
}

/**
 * Get dir tree
 *
 * @param string $dir name
 * @return array
 */
function getContentTree($dir){
    $path = getcwd().$dir;
    $exclude_list = array(".", "..");
    $items = array_diff(scandir($path), $exclude_list);
    // exclude hidden files
    $items = array_filter($items, create_function('$a','return ($a[0]!=".");'));
    return ($items);
}

/**
* View item
*
* @param string $item filename
* @return string Html
*/
function view($item, $dirPath=null) {
    // get path
    if ($dirPath) {
        $pathItem = $dirPath.'/'.$item;
        $linkItem = str_replace(getcwd(), "", $pathItem);
    } else {
        $linkItem = DIR.'/'.$item;
        $pathItem = getcwd().$linkItem;
    }

    // rendering
    if (is_dir($pathItem)) {
        echo '<h2>'.$item.'</h2>';
        echo '<ul>';
        foreach (getContentTree($linkItem) as $elm) {
            echo '<li>';
            view($elm, $pathItem);
            echo '</li>';
        }
        echo '</ul>';
    } else {
        renderLink($item, $pathItem);
    }
}

/**
 * Get renderLink
 *
 * @param string $item name, $pathItem path,
 * @return string Html
 */
function renderLink($item, $pathItem){
    // extract url from file
    foreach (file($pathItem) as $value) {
        if(strpos($value, 'URL=') !== false){
            $url=substr($value,4);
            break;
        }
    }
    $item =cleanFilename($item);
    // rendering
    echo '<a class="item" href="'.$url.'" target="_blank" /><span>'.$item.'</span></a>';
}

/**
 * Clean Filename
 *
 * @param string $name name
 * @return string name
 */
function cleanFilename($name){
    $strToClean = ['.desktop', '.URL', '.url'];
    foreach ($strToClean as $value) {
        if(strpos($name, $value) !== false){
            $name=substr($name, 0, -strlen($value));
            return $name;
        }
    }
    return;
}

viewTree();
?>
