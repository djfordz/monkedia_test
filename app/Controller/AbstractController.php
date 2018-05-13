<?php

namespace Monkedia\Test\Controller;

use Monkedia\Test\View\BaseView;
use Monkedia\Test\Model\BaseModel;

/**
 * This is the "base controller class". All other "real" controllers extend this class.
 */
abstract class AbstractController
{

    // base uri
    const BASE = 'http://monkedia.io/';

    protected $_view;
    protected $_model;
    
    public function __construct()
    {
        // instantiate base view and base model
        $this->_view = new BaseView();
        $this->_model = new BaseModel();
    }

    // every controller must have at least an index method
    abstract public function index();

    // redirect action
    public function redirect($url) {
        header("Location: $url");
        exit;
    }

    // send to model
    public function session($id)
    {
        return $this->_model->session($id);
    }

    // redirect base
    public function redirectBase($url = '') {
        $buildUrl = self::BASE . $url;
        header("Location: $buildUrl");
        exit;
    }

    // send to view
    public function apologize($data)
    {
        $this->_view->apologize(['message' => $data]);
    }
    
}
