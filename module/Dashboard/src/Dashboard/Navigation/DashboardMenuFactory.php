<?php
/**
 * Description of DashboardMenuFactory
 *
 * @author fragote
 */

namespace Dashboard\Navigation;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DashboardMenuFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $menu = new DashboardMenu();
        return $menu->createService($serviceLocator);
    }
}
