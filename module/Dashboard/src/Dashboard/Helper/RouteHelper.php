<?php
/**
 * Description of routesHelper
 *
 * @author fragote
 */

namespace Dashboard\Helper;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class RouteHelper extends AbstractPlugin
{
    public function formUrl($module, $controller, $action)
    {
        $module = (!empty($module) && $module != 'index') ? "/" . $module : "#";
        $controller = (!empty($controller) && $controller != 'index') ? "/" . $controller : "";
        $action = (!empty($action) && $action != 'index') ? "/" . $action : "";
        
        $url = $module . $controller . $action;
        
        return $url;
    }
}
