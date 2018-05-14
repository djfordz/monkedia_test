<?php

namespace Monkedia\Test\Model;

use Monkedia\Test\Config\Config;

/**
 * Not a real abstract class as it gets instantiated.
 * All "real" models will get extended from this base class.
  */
class BaseModel
{
    const MODEL = 'Monkedia\\Test\\Model\\';

    protected $db;

    public $url;

    public function __construct()
    {
        // load config
        $this->_config = new Config();
        // establish database connection
        $this->dbConn();
        $this->url = $this->_config->getUrl();
    }

    public function load($name)
    {
        $model = self::MODEL . ucwords($name) . 'Model';

        // if exists instantiate model
        if (class_exists($model)) {
            return new $model();
        } else {
            throw new \Exception('Model does not exist.');
        }
        
    }

    private function dbConn()
    {
        try {
            // make database connection.
            $this->db = new \PDO($this->_config->getDbType() . ':host=' . $this->_config->getDbHost() . ';dbname=' . $this->_config->getDbName(), $this->_config->getDbUser(), $this->_config->getDbPass());
            // disable emulate prepares if enabled.
            $this->db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        } catch (\PDOException $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
            exit;
        }
    }

    protected function query(/* $sql [, ... ] */)
    {
        // get first argument (sql query) 
        $sql = func_get_arg(0);

        // get parameters 
        $parameters = array_slice(func_get_args(), 1);


        // prepare database statement
        $statement = $this->db->prepare($sql);

        // if incorrect statement trigger error and exit
        if ($statement === false) {
            trigger_error($this->db->errorInfo()[2], E_USER_ERROR);
            exit;
        }

        // execute prepared statement with parameters
        $results = $statement->execute($parameters);

        // return result set's rows if any
        if ($results !== false) {
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return false;
        }
        
    }

    public function session($id) {
        // match user id to session id
        $rows = $this->query('SELECT * FROM users where id = ?', $id);
        if (count($rows) == 1) {
            $row = $rows[0];
            if ($row['id'] === $id) {
                return true;
            }

            return false;
        }

        return false;
    }
}
