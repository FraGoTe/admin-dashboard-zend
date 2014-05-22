<?php

/**
 * Role Table
 * @autor Francis Gonzales <fgonzalestello91@gmail.com>
 */

namespace Dashboard\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class RoleTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
     
    public function getTableGateway()
    {
        return $this->tableGateway;
    }
 
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function addRole($data) 
    {
        return $this->tableGateway->insert($data);
    }
    
    
    public function getRole($roleId)
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $select =  $sql
                    ->select()
                    ->from(array(
                    'r' => 'role'
                    ))
                    ->where(array('r.id' => $roleId))
                    ->order('r.id');
        
        $stmt = $sql->prepareStatementForSqlObject($select);
        $results = $stmt->execute(); 
        return $results;
    }
    
    public function editRole($set, $where)
    {
        $rs = $this->tableGateway->update($set, $where);
        return $rs;
    }
    
    public function getRoleList()
    {
        $select = new Select();
        $select->from(array(
                    'r' => 'role'
                ))
                ->order('r.id');
        
        return $select;
    }
    
    public function deleteRole($roleId)
    {
        $where = array('id' => $roleId);
        $rs = $this->tableGateway->delete($where);
        return $rs;
    }
}
