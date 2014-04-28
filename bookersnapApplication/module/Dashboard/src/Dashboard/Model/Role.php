<?php

/**
 * Role Model
 * @autor Francis Gonzales <fgonzalestello91@gmail.com>
 */

namespace Dashboard\Model;

class Role
{
    public $id;
    public $name;
    
    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
