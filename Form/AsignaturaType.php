<?php  
namespace Informatica\PrometheusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class AsignaturaType extends AbstractType
{
    private $carreras;
    
    
    public function getCarreras(){
        return $this->carreras;
    }
    
    public function setCarreras($carreras){
      $this->carreras = $carreras;
    }

    public function getName(){
		    return 'Asignatura';
	  }
	
    public function buildForm(FormBuilder $generador, array $opciones)
    {
        $carrerasOpciones = array();
        
        foreach ($this->carreras as $i => $value) {
           $carrerasOpciones[$value] = $value;
        }
		    $generador->add('clave',null,array('label'=>'Clave materia:'));
		    $generador->add('nombre',null,array('label' => 'Nombre de la materia:'));
		    $generador->add('carrera','choice',
            array(
                'choices'=>$carrerasOpciones,
                'required'=>true,
                'expanded'=>false,
                'multiple'=>false,
            ));
	    	$generador->add('unidades',null,array('label' => 'Unidades:'));
	}

}

?>