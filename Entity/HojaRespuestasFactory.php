<?php

namespace Informatica\PrometheusBundle\Entity;
use Informatica\PrometheusBundle\Entity\Examen;
use Informatica\PrometheusBundle\Entity\HojaRespuestas;
use Informatica\PrometheusBundle\Entity\PreguntaEvaluable;

class HojaRespuestasFactory
{
    /**
     * Crea una hoja de respuestas.
     *
     */
    public static function getHojaRespuestas($claveexamen, $doctrine){
         $fabrica = new HojaRespuestasFactory();
         $hoja = $fabrica->crearHoja($claveexamen, $doctrine);
         return $hoja;
    }//End getHojaRespuestas($claveexamen, $doctrine)
    
    
     private function crearHoja($claveexamen, $doctrine){
        
        //Recupear el Examen que contiene las preguntas
        $examen = $doctrine->getRepository('InformaticaPrometheusBundle:Examen')
         ->findOneById($claveexamen);
         
        //Construir el objeto Hoja de Respuestas
        $this->hoja = new HojaRespuestas();
        //Se asgina el Examen a la Hoja de respuestas
        $this->hoja->setExamen($examen);

        //Creamos las preguntas de la hoja
        $this->hoja->crearPreguntas();
        //Regresamos la hoja de respuestas creada
        return $this->hoja;

    }
    
    
}