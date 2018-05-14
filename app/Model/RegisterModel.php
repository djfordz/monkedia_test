<?php

namespace Monkedia\Test\Model;

class RegisterModel extends BaseModel
{
    public function register($email, $name, $password)
    {
        
        // if params empty return false
        if (empty($email) || empty($name) || empty($password)) {
            return false;
        }

        // make insert query to db
        $this->query('INSERT INTO users (email, username, password) VALUES (?, ?, ?)', $email, $name, password_hash($password, PASSWORD_BCRYPT));

        // retrieve last insert
        $rows = $this->query('SELECT LAST_INSERT_ID() AS id');

        // set session id
        $_SESSION['id'] = $rows[0]['id'];

        // return true if session id is properly set
        if (isset($_SESSION['id'])) {
            return true;
        }

        // return false all else.
        return false;
    }
}
