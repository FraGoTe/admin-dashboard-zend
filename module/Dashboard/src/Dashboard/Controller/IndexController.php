<?php

/**
 * IndexController - The Default controller class
 * @autor Francis Gonzales <fgonzalestello91@gmail.com>
 */
namespace Dashboard\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
       $viewmodel = new ViewModel();
       return $viewmodel;
    }
}
