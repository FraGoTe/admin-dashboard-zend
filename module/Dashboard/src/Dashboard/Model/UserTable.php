<?php

/**
 * User Table
 * @autor Francis Gonzales <fgonzalestello91@gmail.com>
 */

namespace Dashboard\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class UserTable
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
    
    /**
     * This functions returns a query to get 
     * all the users
     * @return \Zend\Db\Sql\Select
     */
    public function getUsersList()
    {
        $select = new Select();
        $select->from(array(
                    'u' => 'user'
                ))
                ->join(array(
                    'r' => 'role'
                    ), 
                    'u.role_id = r.id'
                 )
                ->order('u.id');
        
        return $select;
    }
    
    /**
     * This function returns the user by ID
     * @param int $userId
     * @return array
     */
    public function getUser($userId)
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = $sql
                  ->select()
                  ->from(array('u' => 'user'))
                  ->join(
                        array('r' => 'role'),
                        'r.id = u.role_id',
                        array('*')
                    )
                  ->where(array('u.id' => $userId))
                  ->order('u.id');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $results = $stmt->execute(); 
        return $results;
    }
    
    /**
     * This function allows to add users
     * @param array $params
     * @return boolean
     */
    public function addUser($params)
    {
        $params['password'] = sha1($params['password']);
        $rs = $this->tableGateway->insert($params);
        return $rs;
    }
}
