<?php

/**
 * UserController - This allows add, delete and edit users
 * @autor Francis Gonzales <fgonzalestello91@gmail.com>
 */

namespace Dashboard\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Dashboard\Form\UserForm;

class UserController extends AbstractActionController
{
    public function indexAction()
    {
        $viewmodel = new ViewModel();
        $form = new UserForm();
//        $request = $this->getRequest();
//        $serviceLocator = $this->getServiceLocator();
//        $form->get('submit');
//        $message = ""; //Message
//        
//        if ($request->isPost()) {
//            // @TODO addfilters
//            //$form->setInputFilter($filters);
//            $form->setData($request->getPost());
//            if ($form->isValid()) {
//                $data = $form->getData();
//                $userTable = $serviceLocator->get('Dashboard\Model\UserTable');
//                unset($data['submit']);
//                
//                if ($rs) {
//                    $form = new UserForm();
//                }
//            }
//        }
        $viewmodel->form = $form;
        $viewmodel->message = $message;
        return $viewmodel;
    }
}
