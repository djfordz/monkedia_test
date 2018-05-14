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
                // if both are filled
                $rows = array(["error" => "Please use only client id or client first name to search"]);
            } else if (!empty($clientId)) {
                // query db for id
                $rows = $this->_accountModel->searchId($clientId);
            } else if (!empty($clientName)) {
                // query db for first name
                $rows = $this->_accountModel->searchName($clientName);
            } else {
                // if fields empty
                $rows = array(['error'=> 'Please fill in either Client Id or Client First Name to Search']);
            }
            
            if (count($rows) === 1) {
                // if record found
                print json_encode($rows[0], JSON_PARTIAL_OUTPUT_ON_ERROR);
            } else if ($rows !== false) {
                // if row exists (error row) 
                print json_encode($rows, JSON_PARTIAL_OUTPUT_ON_ERROR);
            } else {
                // if false, (no record)
                print json_encode(["error" => "No Results"]);
            }
        }
    }

    public function listClients()
    {
        // query db
        $rows = $this->_accountModel->listClients();

        if (count($rows) > 0) {
            // print results
            print json_encode($rows, JSON_PARTIAL_OUTPUT_ON_ERROR);
        } else {
            // print error if false
            print json_encode(array(['error' => "Data could not be retrieved."]), JSON_PARTIAL_OUTPUT_ON_ERROR);
        }
    }
}
