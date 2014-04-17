<?php

/**
 * Description of DashboardMenu
 *
 * @author fragote
 */
namespace Dashboard\Navigation;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;
use Zend\Authentication\AuthenticationService;
use Dashboard\Helper\RouteHelper;

class DashboardMenu extends DefaultNavigationFactory
{
    protected function getPages(ServiceLocatorInterface $serviceLocator) 
    {
        $menu = array();
        //if (null == $this->pages) {
            $auth = new AuthenticationService();
            $mvcEvent = $serviceLocator->get('Application')->getMvcEvent();
            $privilegeMenu = $serviceLocator->get('Dashboard\Model\PrivilegeTable');
            
            $identity = $auth->getIdentity();
            $dataMenu = $privilegeMenu->getMenuByUser($identity->id);
            $menu = $this->menuFormat($dataMenu);
            
            $routeMatch = $mvcEvent->getRouteMatch();
            $router = $mvcEvent->getRouter();
            $pages = $this->getPagesFromConfig($menu);
            $this->pages = $this->injectComponents($pages, $routeMatch, $router);
        //}
        
        return $this->pages;
    }
    
    public function menuFormat($dataMenu) 
    {
        $menu = array();
        $routHelper = new RouteHelper();
        foreach ($dataMenu as $opt) {
            if (empty($opt['parent'])) {
                $menu[] = array(
                    'label' => $opt['label'],
                    'uri' => $routHelper->formUrl($opt['module'], $opt['controller'], $opt['action'])
                );
            } else {
                $menu[$opt['parent']]['pages'][] = array(
                    'label' => $opt['label'],
                    'uri' => $routHelper->formUrl($opt['module'], $opt['controller'], $opt['action'])
                );
            }
        }
        //Logout
        $menu[] = array(
            'label' => 'Logout',
            'uri' => '/dashboard/logout'
        );
         return $menu;
    }
}
