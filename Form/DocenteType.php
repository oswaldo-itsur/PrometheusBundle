<?php

namespace Informatica\PrometheusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class DocenteType extends AbstractType
{
    public function buildForm(FormBuilder $generador, array $opciones) {

        $generador->add('clave', null,
            array('label' => 'Clave:')
        );
        $generador->add('nombre', null,
            array('label' => 'Nombre:')
        );
        $generador->add('usuario', null,
            array('label' => 'Usuario:')
        );
        $generador->add('contrasena', 'password',
            array('label' => 'Contraseña:')
        );
    }
    
    public function getName(){
      return 'Docente';
    }
}
?>