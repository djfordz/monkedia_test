<?php

namespace Monkedia\Test\Controller;

class IndexController extends AbstractController
{
    protected $_index;
    protected $_indexModel;

    public function __construct()
    {
        parent::__construct();
        $this->_index = $this->_view->load('index');
        $this->_indexModel = $this->_model->load('index'); 
    }
    public function index()
    {
        $this->_view->render('index');
    }
}
