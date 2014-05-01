<?php
/**
 * Description of RoleForm
 * @autor Francis Gonzales <fgonzalestello91@gmail.com>
 */
namespace Dashboard\Form;

use Zend\Form\Form;

class RoleForm extends Form
{
    public function __construct($name = null) {
        parent::__construct('role');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Rol',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add',
                'id' => 'submitbutton',
                'class' => 'btn btn-success'
            ),
        ));
    }
}
