<?php

/**
 * RoleController - This allows add, delete and edit users
 * @autor Francis Gonzales <fgonzalestello91@gmail.com>
 */

namespace Dashboard\Controller;

use Dashboard\Form\RoleForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

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
}
