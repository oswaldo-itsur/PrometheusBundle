<?php

namespace Informatica\PrometheusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Informatica\PrometheusBundle\Form\AsignaturaType;
use Informatica\PrometheusBundle\Entity\Asignatura;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/asignatura")
 */
class AsignaturaController extends Controller
{
	 /**
     * @Route("/")
     * @Template()
     */
    public function indexAction($name)
    {
         return $this->redirect($this->generateUrl('asignatura_list'));
    }
	
    /**
     * @Route("/new", name="asignatura_new")
     * @Template()
     */
   	public function newAction(Request $request)
	{
		 $asignatura = new Asignatura();
         $form = $this->createForm(new AsignaturaType(),$asignatura);

		 if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($asignatura);
                $em->flush();
                return $this->redirect($this->generateUrl('asignatura_message'));
            }
        }
        return array('form'=>$form->createView());
		
	}
	
	/**
     * @Route("/list", name="asignatura_list")
     * @Template()
     */
	public function listAction()
	{
		$repository = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Asignatura');
        $asignaturas = $repository->findAll();

        return array('asignaturas'=>$asignaturas);
		
		
	}
	
	
	 /**
     * @Route("/update/{clave}", name="asignatura_update")
     * @Template()
     */
	public function updateAction(Request $request, $clave)
	{
	   $repository = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Asignatura');
        $asignatura = $repository->findOneByClave($clave);

        $form = $this->createForm(new AsignaturaType(),$asignatura);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($asignatura);
                $em->flush();
                return $this->redirect($this->generateUrl('asignatura_message'));
            }
        }
        return array('form'=>$form->createView(),'clave'=>$clave);
	 
	}
	
	 /**
     * @Route("/remove/{clave}", name="asignatura_remove")
     * @Template()
     */
	public function removeAction($clave)
	{
		$em = $this->getDoctrine()->getEntityManager();

        $asignatura = $em->getRepository('InformaticaPrometheusBundle:Asignatura')->findOneByClave($clave);
        if (!$clave) {
            throw $this->createNotFoundException('No se encontro la asignatura con clave: '.$clave);
        }
        $em->remove($asignatura);
        $em->flush();

        return array('mensaje'=>"asignatura con clave $clave eliminado correctamente");
	}
	
	
	 /**
     * @Route("/show/{clave}", name="asignatura_clave")
     * @Template()
     */
    public function showAction($clave)
	{

    }
	
	 /**
     * @Route("/message", name="asignatura_message")
     * @Template()
     */
    public function messageAction(){
        return array("mensaje" => "Asignatura guardada");
    }
	
}
?>