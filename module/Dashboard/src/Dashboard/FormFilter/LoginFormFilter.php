<?php

/**
 * Description of LoginFormFilter
 *
 * @author fragote
 */

namespace Dashboard\FormFilter;

use Zend\InputFilter\InputFilter;

class LoginFormFilter extends InputFilter 
{

    public function __construct() 
    {    
        $input = new \Zend\InputFilter\Input('username');
        // Validadores
        $v = new \Zend\Validator\StringLength(array('min'=>3,'max'=>50));
        $v->setMin(3);
        $v->setMessage('El usuario ingresado es inválido', \Zend\Validator\StringLength::TOO_SHORT);
        $input->setRequired(true);
        $input->getValidatorChain()->attach($v);
        $this->add($input);
        
        $input = new \Zend\InputFilter\Input('password');
        // Validadores
        $v = new \Zend\Validator\StringLength(array('min'=>3,'max'=>50));
        $v->setMin(3);
        $v->setMessage('La clave ingresada es inválida', \Zend\Validator\StringLength::TOO_SHORT);
        $input->setRequired(true);
        $input->getValidatorChain()->attach($v);
        $this->add($input);
    }
    
}