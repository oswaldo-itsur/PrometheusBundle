<?php  
namespace Informatica\PrometheusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class AsignaturaType extends AbstractType
{
	
	public function buildForm(FormBuilder $generador, array $opciones)
	{
		$generador->add('clave',null,array('label'=>'Clave materia:'));
		$generador->add('nombre',null,array('label' => 'Nombre de la materia:'));
		$generador->add('carrera',null,array('label' => 'Carrera:'));
		$generador->add('unidades',null,array('label' => 'Unidades:'));
	}
	public function getName(){
		return 'Asignatura';
	}
}

?>