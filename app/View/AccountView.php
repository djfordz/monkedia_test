<?php

namespace Monkedia\Test\View;

class AccountView extends BaseView
{

    protected $_accountModel;

    public function __construct()
    {
        parent::__construct();
        $this->_accountModel = $this->_model->load('account');
    }

    public function getUsername()
    {
        return $this->_accountModel->getUsername($_SESSION['id']);
    }

    public function getAccountPostUrl()
    {
        return $this->url . 'account/post';
    }
}
