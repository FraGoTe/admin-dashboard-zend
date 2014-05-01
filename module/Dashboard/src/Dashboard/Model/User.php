<?php

/**
 * User Model
 * @autor Francis Gonzales <fgonzalestello91@gmail.com>
 */

namespace Dashboard\Model;

class User
{
    public $id;
    public $username;
    public $password;
    public $fullName;
    public $email;
    public $roleId;
    
    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->username = (isset($data['username'])) ? $data['username'] : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
        $this->fullName = (isset($data['full_name'])) ? $data['full_name'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->roleId = (isset($data['role_id'])) ? $data['role_id'] : null;
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
