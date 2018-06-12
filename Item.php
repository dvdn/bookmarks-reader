<?php

class Item{
   public $name;
   public $path;

    public function __construct($name, $path){
        $this->name=$name;
        $this->path=$path;
        $this->rawPath=$path.'/'.$name;
    }

    public function getname(){
        return $this->name;
    }

    public function getPath(){
        return $this->path;
    }

    public function isDir(){
        return is_dir($this->rawPath);
    }

    public function isFile(){
        return is_file($this->rawPath);
    }

    public function getInfo($info='URL'){
        $nbSub = strlen($info)+1;
        foreach (file($this->rawPath) as $value) {
            if(strpos($value, $info.'=') !== false){
                return substr($value,$nbSub);
            }
        }
    }

    public function renderFile() {

/*if(strpos($item, '.mht') == false) {
            $link = getUrl($item, $pathItem);
        } else {
            $link = $_SERVER["REQUEST_URI"].$linkItem;
        }*/

    // rendering
    echo '<a class="item" href="'.$this->getInfo().'" target="_blank" download="filename" /><span>'.cleanFilename($this->name).'</span></a>';
    }

    public function renderDir($isRoot=false) {
        if ($isRoot) {
            $path = getcwd().DIR;
        } else {
            $path = $this->rawPath;
        }
    echo '<h2>'.$this->name.'</h2>';
    echo '<ul>';
        foreach (getContentTree($path) as $elm) {

            
            $child = new Item($elm, $path);
            if ($child->isDir()) {
                $child->renderDir();
            } elseif ($child->isFile()) {
                echo '<li>';
                $child->renderFile();
                echo '</li>'; 
            };
           
        }
        echo '</ul>';
    }
}
