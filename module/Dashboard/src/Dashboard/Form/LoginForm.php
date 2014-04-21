<?php
/**
 * Description of LoginForm
 *
 * @author fragote
 */
namespace Dashboard\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null) {
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Usuario',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
            ),
            'options' => array(
                'label' => 'Clave',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Entrar',
                'id' => 'submitbutton',
            ),
        ));
    }
}
