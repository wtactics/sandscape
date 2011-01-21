<?php

class SandController {

    public function __construct() {
        //TODO: iniciar
    }

    public function controllerExists($page) {
        return true;
    }

    private function getFilteredRequest() {
        $failsafe = (object) array('controller' => 'Login', 'method' => 'index');

        if (!isset($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] == '') {
            return $failsafe;
        }

        $uri = preg_replace("|/(.*)|", "\\1", str_replace("\\", "/", $_SERVER['REQUEST_URI']));

        if ($uri == '') {
            return $failsafe;
        }

        $exploded = explode("index.php/", $uri);
        if (count($exploded) <= 1) {
            return $failsafe;
        }

        $exploded = explode('/', $exploded[1]);

        $request = array();
        $request['controller'] = $exploded[0];
        $request['method'] = isset($exploded[1]) ? $exploded[1] : 'index';

        if (isset($request[2])) {
            $request['params'] = array();
            $max = count($request);
            for ($i = 2; $i < $max; $i++) {
                $request['params'][] = $request[i];
            }
        }

        return (object)$request;
    }

    public function doRequest() {
        $controller = $this->getFilteredRequest();

        if ($this->controllerExists($controller)) {
            $request = $this->getFilteredRequest();
            $page = new $request->controller();

            if ($page instanceof Page) {
                $method = $request->method;
                $page->$method();
                $page->show();
            }
        } else {
            //404
            echo '404';
        }
    }

}
