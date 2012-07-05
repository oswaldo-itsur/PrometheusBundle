<?php

namespace Informatica\PrometheusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class ExamenType extends AbstractType
{

    private $periodos;

    private $opciones;
    
    
    public function getPeriodos(){
        return $this->periodos;
    }

    public function setPeriodos($periodos){
      $this->periodos = $periodos;
    }
    
    public function getOpciones(){
        return $this->opciones;
    }

    public function setOpciones($opciones){
      $this->opciones = $opciones;
    }
    
    public function buildForm(FormBuilder $generador, array $opciones) {

        $periodosOpciones = array();
        $opcionesDespegables = array();

        foreach ($this->opciones as $i => $value) {
           $opcionesDespegables[$value] = $value;
        }
        
        foreach ($this->periodos as $i => $value) {
           $periodosOpciones[$value] = $value;
        }
        
        $generador->add('id', null,
            array('label' => 'Numero:',
                   'read_only' => true,
                   'required' =>false)
        );
  
        $generador->add('anio', null,
            array('label' => 'Año:')
        );
        
        $generador->add('periodo','choice',
            array(
                'choices'=>$periodosOpciones,
                'required'=>true,
                'expanded'=>false,
                'multiple'=>false,
        ));
        
        $generador->add('nounidades', null,
            array('label' => 'No unidad:')
        );
        $generador->add('nombreunidad', null,
            array('label' => 'Nombre de la unidad:')
        );
        
        $generador->add('opcion','choice',
            array(
                'choices'=>$opcionesDespegables,
                'required'=>true,
                'expanded'=>false,
                'multiple'=>false,
        ));
        $generador->add('fecha','date',
            array('label' => 'Fecha:'));
            
        $generador->add('hora','time',
            array('label' => 'Hora:'));
            
        $generador->add('ponderacion', null,
            array('label' => 'Ponderacion:'));
      
    }
    
    public function getName(){
      return 'Grupo';
    }
}
?>