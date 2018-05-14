<?php

namespace Monkedia\Test;

use Monkedia\Test\Controller\IndexController;

final class App
{
    const CONTROLLER = 'Monkedia\\Test\\Controller\\';
    const LOGIN_CONTROLLER = 'Monkedia\\Test\\Controller\\LoginController';
    const REGISTER_CONTROLLER = 'Monkedia\\Test\\Controller\\RegisterController';
    
    protected $controller = null;

    protected $action = null;

    protected $params = array();

    public function __construct()
    {
        // start session
        session_start();

        // instantiate index controller
        $index = new IndexController();

        // separate url into controller, action, and params.
        $this->splitUrl();

        // camelcase classes.
        $this->controller = ucwords($this->controller) . 'Controller';

        // check if controller exists
        if (class_exists(self::CONTROLLER . $this->controller)) {
            // ensure proper controller namespace is applied.
            $this->controller = self::CONTROLLER . $this->controller;
            
            // don't allow other pages unless logged in except login and register page of course.
            if ($this->controller === self::LOGIN_CONTROLLER || $this->controller === self::REGISTER_CONTROLLER) {
                // instantiate the controller
                $this->controller = new $this->controller();
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->controller->post();
                } else {
                    $this->controller->index();
                } 
                // if session id exists
            } else if (isset($_SESSION['id'])) {
                // instantiate the controller.
                $this->controller = new $this->controller();
                // check to see if logged in.
                if ($index->session($_SESSION['id'])) {
                    // check if controller has action (method).
                    if (method_exists($this->controller, $this->action)) {
                        if (!empty($this->params)) {
                            // if has action with params call action with params.
                            call_user_func_array(array($this->controller, $this->action), $this->params);
                        } else {
                            // if has action call action.
                            $this->controller->{$this->action}();
                        }
                    } else {
                        // if no action return index
                        $this->controller->index();
                    } 
                } else {
                    // If not authorized route to home page.
                    $index->index();
                }
            } else {
                // If Session Id not set route to home page. 
                $index->index();
            }
        } else {
            // If controller does not exist route to home page.
            $index->index();
        }
    }

     /**
     * Get and split the URL
     */
    protected function splitUrl()
    {
        // for nginx using request_uri
        if (isset($_SERVER['REQUEST_URI'])) {

            // split URL
            $url = rtrim($_SERVER['REQUEST_URI'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            array_shift($url);

            // Put URL parts into according properties
            $this->controller = isset($url[0]) ? $url[0] : null;
            $this->action = isset($url[1]) ? $url[1] : null;

            // Remove controller and action from the split URL
            unset($url[0], $url[1]);
            //
            // Rebase array keys and store the URL params
            $this->params = array_values($url);
        }
    }
}
