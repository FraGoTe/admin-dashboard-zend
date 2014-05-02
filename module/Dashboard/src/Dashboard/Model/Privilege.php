<?php

/**
 * Privilege Model
 * @autor Francis Gonzales <fgonzalestello91@gmail.com>
 */

namespace Dashboard\Model;

class Privilege
{
    public $id;
    public $roleId;
    public $menuId;
    
    public function getId()
    {
        return $this->id;
    }

    public function getRoleId()
    {
        return $this->roleId;
    }

    public function getMenuId()
    {
        return $this->menuId;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }

    public function setMenuId($menuId)
    {
        $this->menuId = $menuId;
    }

        
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
