<?php
/**
 * Description of authentication
 *
 * @author fragote
 */
namespace Dashboard\Plugin;

  
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\Plugin\PluginInterface;

class Authentication extends AbstractPlugin
{
     
    public function isAuthtenticated()
    {
        $controller = $this->getController();
        $controllerClass = get_class($controller);
        $namespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
        
        if ($controllerClass !== $namespace . "\Controller\LoginController"){
            $auth = new AuthenticationService();
            if (!$auth->hasIdentity()) {
                $redirector = $controller->getPluginManager()->get('Redirect');
                return $redirector->toRoute('dash_login');
            }
        }
    }
}