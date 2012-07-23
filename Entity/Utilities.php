<?php

namespace Informatica\PrometheusBundle\Entity;

/**
 * Informatica\PrometheusBundle\Entity\Utilities
 *
 */
class Utilities
{
    public static function randomOrder($cantidad){
           $posiciones = array();
           $nuevo = 0;
           for($numero = 1; $numero<=$cantidad; $numero++){
               do{
                  $nuevo = rand(1,$cantidad);
               }while(Utilities::existeEn($nuevo,$posiciones)== 1);
               $posiciones[] =  $nuevo;
           }
           return $posiciones;
    }

    public static function existeEn($numero, $arreglo ){
        foreach($arreglo as $a => $value){
            if($numero == $value){
                 return true;
            }
        }
        return false;
    }
    
    
}