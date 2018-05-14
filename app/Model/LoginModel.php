<?php

namespace Monkedia\Test\Model;

class LoginModel extends BaseModel
{
    public function validate($name, $password)
    {
        // if empty return false, never rely on just frontend validation.
        if (empty($name) || empty($password)) {
            return false;
        }

        // make query
        $rows = $this->query("SELECT * FROM users WHERE username = ?;", $name); 

        // if match
        if (count($rows) == 1) {
            $row = $rows[0];

            // check password
            if (password_verify($password, $row['password']) == $row["password"])
            {
                // assign session id.
                $_SESSION["id"] = $row["id"];
                return true;
            } else {
                // not valid return false;
                return false;
            }
        } 

        // everything else return false.
        return false;
    }
}
