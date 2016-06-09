<?php

/**
 * LoginFactory - The Login Factory class
 * @autor Francis Gonzales <fgonzalestello91@gmail.com>
 */

namespace Dashboard\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoginFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sl)
    {
        $sm = $sl->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $ctl = new \Dashboard\Controller\LoginController($dbAdapter);
        
        return $ctl;
    }
}