<?php

define('DIR', '/bookmarks');
/* define an array */
function listExtensions(){
    return array ('.desktop', '.URL', '.url', '.mht');
}

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
    $items = sortItemsDir($items);
    return ($items);
}

/**
* sort items and folders
*
* @param array $items
* @return array $items
*/
function sortItemsDir($items){
    foreach ($items as $key => $item) {
        foreach (listExtensions() as $value) {
            if(strpos($item, $value) !== false){
                unset($items[$key]);
                array_push($items, $item);
            }
        }
    }
    return $items;
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
        if(strpos($item, '.mht') == false) {
            $link = getUrl($item, $pathItem);
        } else {
            //$link = 'file:///'.$pathItem;
            $link = $_SERVER["REQUEST_URI"].$linkItem;
            /* var_dump($linkItem, '<br>');
            var_dump($pathItem, '<br>');
            var_dump($dirPath, '<br>');
            var_dump($_SERVER["REQUEST_URI"], '<br>');*/
        }
        renderLink($item, $link);
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
   $item =cleanFilename($item);
    // rendering
    echo '<a class="item" href="'.$pathItem.'" target="_blank" download="filename" /><span>'.$item.'</span></a>';
}

// extract url from file
function getUrl($item, $pathItem){
    foreach (file($pathItem) as $value) {
        if(strpos($value, 'URL=') !== false){
            return substr($value,4);
        }
    }
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
    foreach (listExtensions() as $value) {
        if(strpos($name, $value) !== false){
            $name=substr($name, 0, -strlen($value));
        }
        return $name;
    }
    return;
}

?>
