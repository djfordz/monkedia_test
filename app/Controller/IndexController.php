<?php

namespace Monkedia\Test\Controller;

class IndexController extends AbstractController
{
    protected $_index;
    protected $_indexModel;

    public function __construct()
    {
        // load model and view
        parent::__construct();
        $this->_index = $this->_view->load('index');
        $this->_indexModel = $this->_model->load('index'); 
    }
    public function index()
    {
        // render page
        $this->_view->render('index');
    }
}
