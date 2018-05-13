<?php

namespace Monkedia\Test\Controller;

class RegisterController extends AbstractController
{
    protected $_registerView;
    protected $_registerModel;

    public function __construct()
    {
        // instantiate parent
        parent::__construct();
        // load views and models
        $this->_registerView = $this->_view->load('register');
        $this->_registerModel = $this->_model->load('register');
    }

    public function index()
    {
        // render view
        $this->_registerView->render('register', ['title' => 'Register']);
    }

    public function post()
    {
        // only accept post requests
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // sanitize input
            $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
            $name = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

            
            // route to account if correct registration
            if ($this->_registerModel->register($email, $name, $password)) {
                $this->redirectBase('account');
            } else {
                // if POST and errors, route register page.
                $this->redirectBase('register');
            }

            
        } else {
            // route to register page everything else.
            $this->redirectBase('register');
        }
    }
}
