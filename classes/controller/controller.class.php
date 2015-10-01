<?php

class Controller {

    private $uriComponents, $file, $path;

    public function __construct() {
        $this->uriComponents = isset($_REQUEST['page'])?explode('/', $_REQUEST['page']):false;
        $this->getPath();
    }

    public static function getInstance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new Controller();
        }
        return $instance;
    }

    public function getPageContent() {
        if (!$this->file) return false;
        include PAGES_PATH.$this->file;
    }

    private function getPath() {
        $this->path = array();
        if (!$this->uriComponents)
            return false;

       $this->composePath();

        if (count($this->path) > 0) {
            $this->file = implode("/", $this->path);
            $_REQUEST['path'] = $this->path;
            return $this->file;
        }
        return $this->throwPageNotFound();
    }

    private function composePath($index = 0, $path = PAGES_PATH) {
        if (isset($this->uriComponents[$index])) {
            if (is_dir($path.$this->uriComponents[$index]."/")) {
                $this->path[] = $this->uriComponents[$index];
                if (!$this->composePath($index + 1, $path.$this->uriComponents[$index]."/")) {
                    $this->composePath($index, $path.$this->uriComponents[$index]."/");
                }
                return true;
            } else if (is_file($path.$this->uriComponents[$index].".php")) {
                $this->path[] = $this->uriComponents[$index].".php";
                $this->repairRequest($index + 1);
                return true;
            }
        }
        else
            return false;
    }

    private function repairRequest($index) {
        for ($i = $index; $i < count($this->uriComponents); $i++ )
            $_REQUEST['vars'][] = $this->uriComponents[$i];
    }

    private function controllerInclude($file) {
        global $_pageContent;
        if (is_file($file)) {
            $_pageContent = $file;
        } else {
            throwPageNotFound();
        }
    }

    private function throwPageNotFound() {
        header("HTTP/1.0 404 Not Found - Archive Empty");
        require PAGES_PATH.'404.php';
        exit;
    }
}