<?php

namespace Informatica\PrometheusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Informatica\PrometheusBundle\Form\AlumnoType;
use Informatica\PrometheusBundle\Entity\Alumno;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/alumnos")
 */
class AlumnoController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
         return $this->redirect($this->generateUrl('alumno_list'));
    }
    
    
    /**
     * @Route("/new", name="alumno_new")
     * @Template()
     */
    public function newAction(Request $request){

        $alumno = new Alumno();

        $form = $this->createForm(new AlumnoType(),$alumno);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($alumno);
                $em->flush();
                return $this->redirect($this->generateUrl('alumno_list'));
            }
        }
        return array('form'=>$form->createView());
    }

    /**
     * @Route("/list", name="alumno_list")
     * @Template()
     */
    public function listAction(){
        $repository = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Alumno');
        $alumnos = $repository->findAll();

        return array('alumnos'=>$alumnos);
    }

    /**
     * @Route("/update/{nocontrol}", name="alumno_update")
     * @Template()
     */
    public function updateAction(Request $request, $nocontrol){
        $repository = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Alumno');
        $alumno = $repository->findOneByNocontrol($nocontrol);

        $form = $this->createForm(new AlumnoType(),$alumno);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($alumno);
                $em->flush();
                return $this->redirect($this->generateUrl('alumno_list'));
            }
        }
        return array('form'=>$form->createView(),'nocontrol'=>$nocontrol);
    }

    /**
     * @Route("/remove/{nocontrol}", name="alumno_remove")
     * @Template()
     */
    public function removeAction($nocontrol){
        $em = $this->getDoctrine()->getEntityManager();

        $alumno = $em->getRepository('InformaticaPrometheusBundle:Alumno')->findOneByNocontrol($nocontrol);
        if (!$alumno) {
            throw $this->createNotFoundException('No se encontro el alumno con numero de control: '.$nocontrol);
        }
        $em->remove($alumno);
        $em->flush();

        return $this->redirect($this->generateUrl('alumno_list'));
    }

    /**
     * @Route("/show/{nocontrol}", name="alumno_nocontrol")
     * @Template()
     */
    public function showAction($nocontrol){

    }

    /**
     * @Route("/message", name="alumno_message")
     * @Template()
     */
    public function messageAction(){
        return array("mensaje" => "Alumno guardado");
    }
    
     /**
     * @Route("/ajax")
     * @Template()
     */
    public function ajaxAction(){
        $repository = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Alumno');
        $alumnos = $repository->findAll();
        
        $request = $this->getRequest(); 
        //if ($request->isXmlHttpRequest()) { 
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($alumnos));
        return $response;
        // )); 
    }

  
}