<?php

namespace Informatica\PrometheusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Informatica\PrometheusBundle\Form\DocenteType;
use Informatica\PrometheusBundle\Entity\Docente;


/**
 * @Route("/docentes")
 */
class DocenteController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
         return $this->redirect($this->generateUrl('docente_list'));
    }
    
     /**
     * @Route("/new", name="docente_new" )
     * @Template()
     */
    public function newAction(Request $request){
        $docente = new Docente();
        $form = $this->createForm(new DocenteType(), $docente);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($docente);
                $em->flush();
                return $this->redirect($this->generateUrl('docente_messages'));
            }
        }
        return array('form'=> $form->createView());
    }

    /**
     * @Route("/list", name="docente_list" )
     * @Template()
     */
    public function listAction(){
        $repository = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Docente');
        $carreras =  $repository->findAll();

        return array('docentes' => $carreras);
    }

    /**
     * @Route("/update/{clave}", name="docente_update" )
     * @Template()
     */
    public function updateAction(Request $request, $clave){

        $repository = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Docente');
        $docente =  $repository->findOneByClave($clave);

        $form = $this->createForm(new DocenteType(), $docente);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($docente);
                $em->flush();
                return $this->redirect($this->generateUrl('docente_messages'));
            }
        }
        return array('form'=> $form->createView(),
                              'clave'=>$clave);
    }

    /**
     * @Route("/remove/{clave}", name="docente_remove" )
     * @Template()
     */
    public function removeAction($clave){
        $em = $this->getDoctrine()->getEntityManager();

        $docente = $em->getRepository('InformaticaPrometheusBundle:Docente')
           ->findOneByClave($clave);

        if(!$docente){
            throw $this->createNotFoundException('No se encontro el docente con
                la clave:'.$clave);
        }

        $em->remove($docente);
        $em->flush();

        return array('mensaje'=>'Docente eliminado');
    }

   /**
     * @Route("/messages", name="docente_messages" )
     * @Template()
     */
    public function messagesAction(){
      return array('mensaje'=>'exito');
    }
}
