<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Dashboard;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Dashboard\Model\Privilege;
use Dashboard\Model\PrivilegeTable;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $application = $e->getApplication();
        $sm = $application->getServiceManager();
        $sharedManager = $eventManager->getSharedManager();

        $router = $sm->get('router');
        $request = $sm->get('request');
        
        $matchedRoute = $router->match($request);
        if (null !== $matchedRoute) {
            //Check the Authentication in every controller different with Login
            //If there is no identity this will redirect to Login
            $sharedManager->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function() use ($sm) {
                $sm->get('ControllerPluginManager')->get('Authentication')->isAuthtenticated();    
            }, 2);
            // @todo implement ACL
            //Check ACL and show the menu
            //$sharedManager->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function() use ($sm) {
            //    $sm->get('ControllerPluginManager')->get('Privileges')->doAuthorization();
            //}, 2);
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                    'Navigation'  => 'Dashboard\Navigation\DashboardMenuFactory',
                    //Registrando Modelos
                    'Dashboard\Model\PrivilegeTable' => function($sl){
                        $gateway = $sl->get('PrivilegeTableGateway');
                        $table = new PrivilegeTable($gateway);
                        return $table;
                    },
                    'PrivilegeTableGateway' => function($sl) {
                        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
                        $rsPrototype = new ResultSet();
                        $rsPrototype->setArrayObjectPrototype(new Privilege());
                        $tableGateway = new TableGateway('privilege', $adapter, null, $rsPrototype);
                        return $tableGateway;
                },
                )
            );
            
    }
}
