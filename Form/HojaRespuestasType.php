<?php

namespace Informatica\PrometheusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Informatica\PrometheusBundle\Entity\Pregunta;

class HojaRespuestasType extends AbstractType
{

    private $hojaRespuestas;


    public function getHojaRespuestas(){
        return $this->hojaRespuestas;
    }

    public function setHojaRespuestas($hojaRespuestas){
      $this->hojaRespuestas = $hojaRespuestas;
    }
    
    public function buildForm(FormBuilder $generador, array $opciones) {
        
        foreach($this->getHojaRespuestas()->getPreguntas() as $pregunta =>$valor){
        
            if($valor->getPregunta()->getTipo() == Pregunta::SELECCIONMULTIPLE){
       
               $generador->add("".$valor->getId(),'choice',
               array(
                  'choices'=>array(
                     1 => $valor->getPregunta()->getOpcion1(),
                     2 => $valor->getPregunta()->getOpcion2(),
                     3 => $valor->getPregunta()->getOpcion3(),
                ),
                'label'=>$valor->getOrden().'. '.$valor->getPregunta()->getSentencia(),
                'required'=>false,
                'expanded'=>true,
                'multiple'=>true,
               ));
               
            }elseif($valor->getPregunta()->getTipo() == Pregunta::SELECCIONUNICA){
        
               $generador->add("".$valor->getId(),'choice',
               array(
                  'choices'=>array(
                     1 => $valor->getPregunta()->getOpcion1(),
                     2 => $valor->getPregunta()->getOpcion2(),
                     3 => $valor->getPregunta()->getOpcion3(),
                ),
                'label'=>$valor->getOrden().'. '.$valor->getPregunta()->getSentencia(),
                'required'=>false,
                'expanded'=>true,
                'multiple'=>false,
               ));
               
            } 
        
        }
    }
    
    public function getName(){
      return 'Grupo';
    }
}
?>