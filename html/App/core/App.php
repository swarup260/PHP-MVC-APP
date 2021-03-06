<?php

class App
{
    protected $controller = 'home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();
        // print_r($url);
        // echo "../App/controller/" . $url[0] . ".php";
        /*
            parse the url 0 index which contain the controller name 
            if exist then set the controller to $url[0]
            else load the default home controller
        */
        if (file_exists("../App/controller/" . $url[0] . ".php")) {
            $this->controller = $url[0];
            unset($url[0]);
        }
        require_once "../App/controller/" . $this->controller . ".php";
        $this->controller = new $this->controller;
        
        /*
            parse the url 1 index which contain the controller name 
            if exist then set the method to $url[1]
            else load the default home method
        */
        if(method_exists($this->controller,$url[1])){
            $this->method = $url[1];
            unset($url[1]);
        }
        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller ,$this->method],$this->params);
    }

    /*
    Parse the url based upon the parameter 'q'

    */
    private function parseUrl()
    {
        if (isset($_GET['q'])) {
            return $url = explode('/', filter_var(trim($_GET['q'], '/'), FILTER_SANITIZE_URL));
        }
    }

}
