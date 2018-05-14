<?php

namespace Monkedia\Test\Model;

class AccountModel extends BaseModel
{
    public function getUsername($id)
    {
        $rows = $this->query('SELECT username FROM users where id = ?', $id);

        if (count($rows) === 1) {
            $row = $rows[0];

            return $row['username'];
        }

        return false;
    }

    public function searchId($value)
    {
        $rows = $this->query('SELECT * FROM clients where id = ?', $value);

        if (count($rows) > 0) {
            return $rows;
        }

        return false;
    }

    public function searchName($value)
    {
        $rows = $this->query('SELECT * from clients where first_name = ?', $value);

        if (count($rows) > 0) {
            return $rows;
        }

        return false;
    }

    public function listClients()
    {
        $rows = $this->query('SELECT * from clients');

        if (count($rows) > 0) {
            return $rows;
        }

        return false;
    }
}
