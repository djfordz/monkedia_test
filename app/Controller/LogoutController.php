<?php

namespace Monkedia\Test\Controller;

class LogoutController extends AbstractController
{
    public function index()
    {
        // call logout function
        $this->_logout();
    }

    protected function _logout()
    {
        // unset any session variables
        $_SESSION = [];

        // expire cookie
        if (!empty($_COOKIE[session_name()])) {
            setcookie(session_name(), "", time() - 42000);
        }

        // destroy session
        session_destroy();

        // redirect to home
        $this->redirectBase();
    }
}
