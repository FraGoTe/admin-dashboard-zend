<?php

/**
 * LoginController - The Login controller class
 * @autor Francis Gonzales <fgonzalestello91@gmail.com>
 */

namespace Dashboard\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Dashboard\Form\LoginForm;
use Dashboard\FormFilter\LoginFormFilter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Session\SessionManager;

class LoginController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout('layout/login');
        $auth = new AuthenticationService();
        $viewmodel = new ViewModel();
        $form = new LoginForm();
        $request = $this->getRequest();
        $filters = new LoginFormFilter();
        $form->get('submit')->setValue('Login');
        $message = ""; //Message
        
        if ($auth->hasIdentity()) {
            return $this->redirect()->toRoute('dash_index');
        }
        
        if ($request->isPost()) {
            $form->setInputFilter($filters);
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $sm = $this->getServiceLocator();
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                $authAdapter = new AuthAdapter(
                                  $dbAdapter, //Adapter
                                  'user', //User table
                                  'username', //field
                                  'password',  // field
                                  'SHA1(?)' //custom functions
                              );
                
                $authAdapter->setIdentity($data['username'])
                            ->setCredential($data['password']);
                
                $result = $auth->authenticate($authAdapter);
                
                switch ($result->getCode()) {
                    case Result::SUCCESS:
                        $storage = $auth->getStorage();
                        $storage->write(
                                $authAdapter->getResultRowObject(
                                            null,
                                            'password'
                                    )
                                );
                       return $this->redirect()->toRoute('dash_index');
                       break;
                   default :
                       $message = "Usuario o clave incorrecto.";
                       break;

                }
            }
        }
        $viewmodel->form = $form;
        $viewmodel->message = $message;
        return $viewmodel;
    }
    
    public function logoutAction()
    {
	$auth = new AuthenticationService();

	if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
            $auth->clearIdentity();
            $sessionManager = new SessionManager();
            $sessionManager->forgetMe();
	}			

        $this->redirect()->toRoute('dash_login');		
    }
}
