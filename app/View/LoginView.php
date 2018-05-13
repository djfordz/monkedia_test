<?php

namespace Monkedia\Test\View;

class LoginView extends BaseView
{
    public function getLoginPostUrl()
    {
        return $this->url . 'login/post';
    }
}
