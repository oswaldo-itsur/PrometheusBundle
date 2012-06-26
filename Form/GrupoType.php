<?php

namespace Informatica\PrometheusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class GrupoType extends AbstractType
{

    private $periodos;


    public function getPeriodos(){
        return $this->periodos;
    }

    public function setPeriodos($periodos){
      $this->periodos = $periodos;
    }
    
    public function buildForm(FormBuilder $generador, array $opciones) {

       $periodosOpciones = array();

        foreach ($this->periodos as $i => $value) {
           $periodosOpciones[$value] = $value;
        }
        
        $generador->add('clave', null,
            array('label' => 'Clave:')
        );

        $generador->add('periodo','choice',
            array(
                'choices'=>$periodosOpciones,
                'required'=>true,
                'expanded'=>false,
                'multiple'=>false,
        ));
        
        $generador->add('anio', null,
            array('label' => 'Año:')
        );
        $generador->add('semestre', null,
            array('label' => 'Semestre:')
        );
    }
    
    public function getName(){
      return 'Grupo';
    }
}
?>