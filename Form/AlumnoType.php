<?php  
namespace Informatica\PrometheusBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
class AlumnoType extends AbstractType
{
	public function buildForm(FormBuilder $generador, array $opciones)
	{
		$generador->add('nocontrol',null,array('label'=>'Numero de Control:'));
		$generador->add('nombre',null,array('label' => 'Nombre del Alumno:'));
		$generador->add('correo','email',array('label' => 'E-Mail:'));
		$generador->add('contrasena','password', array( 'label' => 'Contraseña: '));
	}
	public function getName(){
		return 'Alumno';
	}
}
?>