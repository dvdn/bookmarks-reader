<?php

require('Item.php');

define('DIR', 'bookmarks');
define('CWDIR', getcwd().'/');

/* define an array */
function listExtensions($linksOnly=false) {
    if ($linksOnly) {
        return array ('.desktop', '.URL', '.url');
    } else {
        return array ('.desktop', '.URL', '.url', '.mht');
    }
}

/**
 * View tree
 *
 * @return string Html
 */
function viewTree() {
    $item = new Item(DIR, getcwd().DIR);
    $item->viewDir();
}

/**
 * Get dir tree
 *
 * @param string $dir name
 * @return array
 */
function getContentTree($dir) {
    $exclude_list = array(".", "..");
    $items = array_diff(scandir($dir), $exclude_list);
    // exclude hidden files
    $items = array_filter($items, create_function('$a','return ($a[0]!=".");'));
    $items = sortItemsDir($items);
    return ($items);
}

/**
* Sort items and folders
*
* @param array $items
* @return array $items
*/
function sortItemsDir($items) {
    foreach ($items as $key => $item) {
        foreach (listExtensions() as $value) {
            if(strpos($item, $value) !== false) {
                unset($items[$key]);
                array_push($items, $item);
            }
        }
    }
    return $items;
}

/**
 * Render Dir Name
 *
 * @param string $name
 * @param string $linkItem relative path
 * @return string Html
 */
function renderDirName($name, $linkItem) {
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
function cleanFilename($name) {
    foreach (listExtensions(true) as $value) {
        if(strpos($name, $value) !== false) {
            $name=substr($name, 0, -strlen($value));
        }
    }
    return $name;
}

?>
