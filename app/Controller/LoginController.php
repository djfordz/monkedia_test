<?php

namespace Monkedia\Test\Controller;

class LoginController extends AbstractController
{
    protected $_login;
    protected $_loginModel;

    public function __construct() 
    {
        // instantiate parent
        parent::__construct();
        // load view and model
        $this->_login = $this->_view->load('login');
        $this->_loginModel = $this->_model->load('login');
    }

    // abstract method
    public function index()
    {
        // render login page
        $this->_login->render('login', ['title' => 'Login']);
    }

    public function post()
    {
        // only accept POST requests
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // sanitize input
            $name = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

            // if validated let to account. Session id will keep validation until logout
            if ($this->_loginModel->validate($name, $password)) {
                $this->redirectBase('account');
            } else {
                // don't rely on frontend validation, just in case let them know.
                $this->apologize('Incorrect username and/or password');
            } 
        } else {
            // all else route to register page
            $this->redirectBase('login');
        } 
    }
}
