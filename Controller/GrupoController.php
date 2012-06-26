<?php

namespace Informatica\PrometheusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Informatica\PrometheusBundle\Form\GrupoType;
use Informatica\PrometheusBundle\Entity\Grupo;


/**
 * @Route("/grupos")
 */
class GrupoController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
         return $this->redirect($this->generateUrl('grupo_list'));
    }
    
     /**
     * @Route("/new", name="grupo_new" )
     * @Template()
     */
    public function newAction(Request $request){
        $periodos = $this->container->getParameter('periodos');

        $grupo = new Grupo();
        $periodoType = new GrupoType();
        $periodoType->setPeriodos($periodos);
        
        $form = $this->createForm($periodoType, $grupo);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($grupo);
                $em->flush();
                return $this->redirect($this->generateUrl('grupo_list'));
            }
        }
        return array('form'=> $form->createView());
    }

    /**
     * @Route("/list", name="grupo_list" )
     * @Template()
     */
    public function listAction(){
        $repository = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Grupo');
        $grupos =  $repository->findAll();

        return array('grupos' => $grupos);
    }

    /**
     * @Route("/update/{clave}", name="grupo_update" )
     * @Template()
     */
    public function updateAction(Request $request, $clave){

        $periodos = $this->container->getParameter('periodos');
        $repository = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Grupo');
        $grupo =  $repository->findOneByClave($clave);
        
        $periodoType = new GrupoType();
        $periodoType->setPeriodos($periodos);

        $form = $this->createForm($periodoType, $grupo);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($grupo);
                $em->flush();
                return $this->redirect($this->generateUrl('grupo_list'));
            }
        }
        return array('form'=> $form->createView(),
                              'clave'=>$clave);
    }

    /**
     * @Route("/remove/{clave}", name="grupo_remove" )
     * @Template()
     */
    public function removeAction($clave){
        $em = $this->getDoctrine()->getEntityManager();

        $grupo = $em->getRepository('InformaticaPrometheusBundle:Grupo')
           ->findOneByClave($clave);

        if(!$grupo){
            throw $this->createNotFoundException('No se encontro el grupo con
                la clave:'.$clave);
        }

        $em->remove($grupo);
        $em->flush();

        return $this->redirect($this->generateUrl('grupo_list'));
    }

   /**
     * @Route("/messages", name="grupo_messages" )
     * @Template()
     */
    public function messagesAction(){
      return array('mensaje'=>'exito');
    }
}
