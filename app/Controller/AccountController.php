<?php

namespace Monkedia\Test\Controller;

class AccountController extends AbstractController
{
    protected $_accountView;
    protected $_accountModel;

    public function __construct()
    {
        parent::__construct();
        $this->_accountView = $this->_view->load('account');
        $this->_accountModel = $this->_model->load('account');
    }

    public function index()
    {
        $this->_accountView->render('account', ['title' => 'Welcome']);
    }

    public function post()
    {
        // only accept post requests
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // sanitize input
            $clientName = trim(filter_input(INPUT_POST, 'clientname', FILTER_SANITIZE_STRING));
            $clientId = trim(filter_input(INPUT_POST, 'client-id', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

            $rows;
            if (!empty($clientId)  && !empty($clientName)) {
                $rows = ["error" => "Please use only client id or client first name to search"];
            } else if (!empty($clientId)) {
                $rows = $this->_accountModel->searchId($clientId);
            } else if (!empty($clientName)) {
                $rows = $this->_accountModel->searchName($clientName);
            } else {
                $rows = ['error' => 'Please fill in either Client Id or Client First Name to Search'];
            }
            
            if (count($rows) === 1) {
                print json_encode($rows[0]);
            } else {
                print json_encode($rows);
            }            
        }
    }
}
