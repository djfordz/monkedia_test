<?php

namespace Monkedia\Test\View;

use Monkedia\Test\Model\BaseModel as BaseModel;

/**
 * This is not a real abstract class as it is instantiated in abstract controller. 
 * Just called abstract as it is the base View Class where all real views will extend from.
 */
class BaseView
{
    const VIEW = 'Monkedia\\Test\\View\\';

    protected $dir;
    protected $_model;

    public $url;

    public function __construct() {
        $this->_model = new BaseModel;
        $this->dir = dirname(dirname(__FILE__));
        $this->url = $this->_model->url;
    }

    public function render($templateName, Array $data = null) 
    {
        $template = $this->dir . "/_layouts/{$templateName}" . '.phtml';

        if (file_exists($template)) {
            if (isset($data)) {
                extract($data);
            }
            ob_start();
            require $this->dir . "/_layouts/header.phtml";
            require $template;
            require $this->dir . "/_layouts/footer.phtml";

            $strView = ob_get_contents();
            ob_clean();

            echo $strView;
        } else {
            $this->apologize(['message' => 'Template does not exist']); 
        }
        
    }

    public function load($viewName)
    {
        $view =  self::VIEW . ucwords($viewName) . 'View';

        // If exists, Instantiate the view.
        if (class_exists($view)) {
            return new $view();
        } else {
            throw new \Exception('View does not exist.');
        }
    }

    public function apologize(Array $data)
    {
        $template = $this->dir . '/_layouts/apologize.phtml';

        extract($data);

        ob_start();
        require $this->dir . "/_layouts/header.phtml";
        require $template;
        require $this->dir . "/_layouts/footer.phtml";

        $strView = ob_get_contents();
        ob_clean();

        echo $strView;
    }

    public function __($message)
    {
        return htmlspecialchars($message);
    }
}
