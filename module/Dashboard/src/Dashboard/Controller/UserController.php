<?php

/**
 * UserController - This allows add, delete and edit users
 * @autor Francis Gonzales <fgonzalestello91@gmail.com>
 */

namespace Dashboard\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Dashboard\Form\UserForm;
use ZfcDatagrid\Column;

class UserController extends AbstractActionController
{
    public function indexAction()
    {
        $viewmodel = new ViewModel();
        $sl = $this->getServiceLocator();
        $roleTable = $sl->get('Dashboard/Model/RoleTable');
        $form = new UserForm($roleTable);
        $request = $this->getRequest();
        $serviceLocator = $this->getServiceLocator();
        $form->get('submit');
        $message = ""; //Message
        
        if ($request->isPost()) {
            // @TODO addfilters
            //$form->setInputFilter($filters);
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $userTable = $serviceLocator->get('Dashboard\Model\UserTable');
                unset($data['submit']);
                
                $rs = $userTable->addUser($data);
                if ($rs) {
                    $form = new UserForm($roleTable);
                }
            }
        }
        $viewmodel->form = $form;
        $viewmodel->message = $message;
        return $viewmodel;
    }
    
    public function listAction()
    {
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $postData = $request->getPost();
            if ($postData->btnAdd === 'add') {
                $this->redirect()->toRoute('dash_user');
            }
        }
        
        $sl = $this->getServiceLocator();
        $dbAdapter = $sl->get('Zend\Db\Adapter\Adapter');
        $grid = $sl->get('ZfcDatagrid\Datagrid');
        $grid->setDefaultItemsPerPage(5);
        $grid->setToolbarTemplate('layout/list-toolbar');
        $grid->setDataSource($sl->get('Dashboard\Model\UserTable')
                                ->getUsersList(), $dbAdapter);
        
        $col = new Column\Select('id', 'u');
        $col->setLabel('id');
        $col->setWidth(25);
        $col->setIdentity(true);
        $col->setSortDefault(1, 'ASC');
        $grid->addColumn($col);
        
        $col = new Column\Select('username', 'u');
        $col->setLabel('Username');
        $col->setWidth(25);
        $grid->addColumn($col);
        
        $col = new Column\Select('full_name', 'u');
        $col->setLabel('Name');
        $col->setWidth(25);
        $grid->addColumn($col);
        
        $col = new Column\Select('email', 'u');
        $col->setLabel('Email');
        $col->setWidth(25);
        $grid->addColumn($col);
        
        $col = new Column\Select('name', 'r');
        $col->setLabel('Rol');
        $col->setWidth(25);
        $grid->addColumn($col);
        
        $editBtn = new Column\Action\Button();
        $editBtn->setLabel('Edit');
        $editBtn->setAttribute('class', 'btn btn-primary');
        $editBtn->setAttribute('href', '/dashboard/user/edit/id/' . $editBtn->getRowIdPlaceholder());
        
        $delBtn = new Column\Action\Button();
        $delBtn->setLabel('Delete');
        $delBtn->setAttribute('class', 'btn btn-danger');
        $delBtn->setAttribute('href', '/dashboard/user/edit/id/' . $delBtn->getRowIdPlaceholder());
        
        $col = new Column\Action();
        $col->addAction($editBtn);
        $col->addAction($delBtn);
        $grid->addColumn($col);
        
        return $grid->getResponse();
    }
    
    public function editAction()
    {
        $userId = $this->params('id');
        $request = $this->request();
        $viewmodel = new ViewModel();
        $sl = $this->getServiceLocator();
        $roleTable = $sl->get('Dashboard\Model\RoleTable');
        $userTable = $sl->get('Dashboard\Model\UserTable');
        $form = new UserForm($roleTable);
        
//        if ($request->isPost()) {
//            
//        }
        
        $userData = $userTable->getUser($userId);
        foreach ($userData as $user) {
            $form->get('username')->setValue($user['username']);
            $form->get('email')->setValue($user['email']);
            $form->get('role_id')->setValue($user['role_id']);
        }
        $viewmodel->form = $form;
        return $viewmodel;
    }
}
