<?php

define('DIR', '/bookmarks');
define('EXTENSIONS', ['.desktop', '.URL', '.url']);

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

    $items = orderItemsDir($items);
    return ($items);
}

function orderItemsDir($items){
    usort($items, function($a, $b) {
        foreach (EXTENSIONS as $value) {
            return strpos($a, $value) < strpos($b, '.desktop');
        }
    });
    return($items);
}

/**
* View item
*
* @param string $item filename
* @param string $dirPath relative path
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
        renderDirName($item, $linkItem);
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
 * Render link
 *
 * @param string $item name
 * @param string $pathItem absolute
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
 * Render Dir Name
 *
 * @param string $name
 * @param string $linkItem relative path
 * @return string Html
 */
function renderDirName($name, $linkItem){
    $arrayDepth = explode ('/', str_replace(DIR, "", $linkItem));

    $depth = sizeof($arrayDepth);
    echo '<h'.$depth.'>'.$name.'</h'.$depth.'>';
}

/**
 * Clean Filename
 *
 * @param string $name name
 * @return string name or void
 */
function cleanFilename($name){
    foreach (EXTENSIONS as $value) {
        if(strpos($name, $value) !== false){
            $name=substr($name, 0, -strlen($value));
            return $name;
        }
    }
    return;
}
?>
