<?php

namespace Monkedia\Test\View;

use Monkedia\Test\Model\AccountModel as Account;

class AccountView extends BaseView
{

    protected $_model;

    public function __construct()
    {
        parent::__construct();
        $this->_model = new Account();
    }

    public function getUsername()
    {
        return $this->_model->getUsername($_SESSION['id']);
    }

    public function getAccountPostUrl()
    {
        return $this->url . 'account/post';
    }
}
