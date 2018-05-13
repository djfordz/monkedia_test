<?php

namespace Monkedia\Test\View;

class RegisterView extends BaseView
{
    public function getRegisterPostUrl()
    {
        return $this->url . 'register/post';
    }
}
