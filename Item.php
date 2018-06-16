<?php

class Item{
   public $name;
   public $path;

    public function __construct($name, $path){
        $this->name=$name;
        $this->path=$path;
        $this->rawPath=$path.'/'.$name;
    }

    public function getName(){
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

    public function getInfo($info){
        $nbSub = strlen($info)+1;
        foreach (file($this->rawPath) as $value) {
            if(strpos($value, $info.'=') !== false){
                return substr($value,$nbSub);
            }
        }
    }

    public function viewFile() {
        // Link to something or mht file
        if(strpos($this->name, '.mht') == false) {
            if($this->getInfo('BASEURL')){
                $link = $this->getInfo('BASEURL');
            } else {
                $link = $this->getInfo('URL');
            }
        } else {
            $link = $_SERVER['REQUEST_URI'].str_replace(getcwd(), '', $this->rawPath);
        }
        echo '<a class="item" href="'.$link.'" target="_blank" download="filename" /><span>'.cleanFilename($this->name).'</span></a>';
    }

    public function viewDir() {
echo '<ul >';
        // if root DIR
        if ($this->name === DIR) {
            $path = getcwd().DIR;
        } else {
            $path = $this->rawPath;
            $toggleId = uniqid();
            echo '<input type="checkbox" class="toggle" id="'.$toggleId.'"  checked="checked"/> <label class="toggle-label" for="'.$toggleId.'" >'.$this->name.'</label>';
        }

        foreach (getContentTree($path) as $elm) {
            $child = new Item($elm, $path);
            if ($child->isDir()) {
                $child->viewDir();
            } elseif ($child->isFile()) {
                echo '<li class="fold">';
                $child->viewFile();
                echo '</li>';
            };
        }
        echo '</ul>';
    }
}
