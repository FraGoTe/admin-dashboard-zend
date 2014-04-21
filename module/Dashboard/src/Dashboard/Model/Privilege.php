<?php

/**
 * Description of Privileges
 *
 * @author fragote
 */
namespace Dashboard\Model;

class Privilege
{
    public $id;
    public $roleId;
    public $menuId;
    
    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->roleId = (isset($data['role_id'])) ? $data['role_id'] : null;
        $this->menuId = (isset($data['menu_id'])) ? $data['menu_id'] : null;
    }
 
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
