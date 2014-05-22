<?php

/**
 * RoleController - This allows add, delete and edit users
 * @autor Francis Gonzales <fgonzalestello91@gmail.com>
 */

namespace Dashboard\Controller;

use Dashboard\Form\RoleForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfcDatagrid\Column;

class RoleController extends AbstractActionController
{
    public function indexAction()
    {   
        $viewmodel = new ViewModel();
        $form = new RoleForm();
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
                $roleTable = $serviceLocator->get('Dashboard\Model\RoleTable');
                unset($data['submit']);
                $rs = $roleTable->addRole($data);
                
                if ($rs) {
                    $form = new RoleForm();
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
                $this->redirect()->toRoute('dash_role');
            }
        }
        
        $sl = $this->getServiceLocator();
        $dbAdapter = $sl->get('Zend\Db\Adapter\Adapter');
        $grid = $sl->get('ZfcDatagrid\Datagrid');
        $grid->setDefaultItemsPerPage(5);
        $grid->setToolbarTemplate('layout/list-toolbar');
        $grid->setDataSource($sl->get('Dashboard\Model\RoleTable')
                                ->getRoleList(), $dbAdapter);
        
        $col = new Column\Select('id', 'r');
        $col->setLabel('id');
        $col->setWidth(25);
        $col->setIdentity(true);
        $col->setSortDefault(1, 'ASC');
        $grid->addColumn($col);
        
        $col = new Column\Select('name', 'r');
        $col->setLabel('Role');
        $col->setWidth(25);
        $grid->addColumn($col);
        
        $editBtn = new Column\Action\Button();
        $editBtn->setLabel('Edit');
        $editBtn->setAttribute('class', 'btn btn-primary');
        $editBtn->setAttribute('href', '/dashboard/role/edit/id/' . $editBtn->getRowIdPlaceholder());
        
        $delBtn = new Column\Action\Button();
        $delBtn->setLabel('Delete');
        $delBtn->setAttribute('class', 'btn btn-danger');
        $delBtn->setAttribute('href', '/dashboard/role/delete/id/' . $delBtn->getRowIdPlaceholder());
        
        $col = new Column\Action();
        $col->addAction($editBtn);
        $col->addAction($delBtn);
        $grid->addColumn($col);
        
        return $grid->getResponse();
    }
    
    public function deleteAction()
    {
        $sl = $this->getServiceLocator();
        $roleId = $this->params('id');
        $userTable = $sl->get('Dashboard\Model\RoleTable');
        $userTable->deleteRole($roleId);
        $this->redirect()->toRoute('dash_role_list');
    }
    
    public function editAction()
    {
        $roleId = $this->params('id');
        $request = $this->getRequest();
        $viewmodel = new ViewModel();
        $sl = $this->getServiceLocator();
        $roleTable = $sl->get('Dashboard\Model\RoleTable');
        
        $form = new RoleForm($roleTable);
        
        if ($request->isPost()) {
            // @TODO addfilters
            //$form->setInputFilter($filters);
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                unset($data['submit']);
                $dataId = array('id' => $roleId);
                $roleTable->editRole($data, $dataId);
            }
        } else {
            $roleData = $roleTable->getRole($roleId);
            foreach ($roleData as $role) {
                $form->get('name')->setValue($role['name']);
            }
        }
       
        $viewmodel->form = $form;
        return $viewmodel;
    }
}
