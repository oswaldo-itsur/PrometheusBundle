<?php

namespace Informatica\PrometheusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Informatica\PrometheusBundle\Entity\Pregunta;


class PreguntaType extends AbstractType
{

    
    public function buildForm(FormBuilder $generador, array $opciones) {
        
        $generador->add('id', null,
            array('label' => 'Numero:',
                   'read_only' => true,
                   'required' =>false)
        );
        
        $generador->add('noUnidad', null,
            array('label' => 'Unidad:')
        );
  
        $generador->add('tipo', 'choice',
            array(
                'choices'=> array(
                   Pregunta::SELECCIONMULTIPLE => 'Selección multiple',
                   Pregunta::SELECCIONUNICA => 'Selección única',
                   Pregunta::ANOTACION => 'Anotación',
                ),
                'required'=>true,
                'expanded'=>false,
                'multiple'=>false,
        ));
       
        
        $generador->add('sentencia', null,
            array('label' => 'Sentencia:')
        );
        
        $generador->add('opcion1',null,
            array(
                'label'=>'Opción 1'
        ));
        
        $generador->add('opcion2',null,
            array(
                'label'=>'Opción 2'
        ));

        $generador->add('opcion3',null,
            array(
                'label'=>'Opción 3'
        ));
        
        $generador->add('respuesta',null,
            array(
                'label'=>'Respuesta'
        ));
            
        $generador->add('valor', null,
            array('label' => 'Valor:'));
        
        $generador->add('tema', null,
            array('label' => 'Tema:'));
    }
    
    public function getName(){
      return 'Grupo';
    }
}
?>