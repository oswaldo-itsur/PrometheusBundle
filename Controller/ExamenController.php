<?php

namespace Informatica\PrometheusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Informatica\PrometheusBundle\Form\ExamenType;
use Informatica\PrometheusBundle\Entity\Examen;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/examenes")
 */
class ExamenController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
         return $this->redirect($this->generateUrl('examen_list', array('_format' => 'html')));
    }
    
    
    /**
     * @Route("/new", name="examen_new")
     * @Template()
     */
    public function newAction(Request $request){

        $opciones = $this->container->getParameter('opciones');
        $periodos = $this->container->getParameter('periodos');
        
        $examen = new examen();
        //$examen->setAnio();
        $examen->setFecha(new \DateTime());
        $examen->setHora(new \DateTime());
        $examenType = new ExamenType();
        $examenType->setOpciones($opciones);
        $examenType->setPeriodos($periodos);
     
        

        $form = $this->createForm($examenType,$examen);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($examen);
                $em->flush();
                return $this->redirect($this->generateUrl('examen_list', array('_format' => 'html')));
            }
        }
        return array('form'=>$form->createView());
    }

    /**
     * @Route("/list", defaults={"_format"="html"}),
     * @Route("/list.{_format}", name="examen_list", requirements={"_format"= "html|xml|json"})
     * @Template()
     */
    public function listAction(){
        $repository = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Examen');
        $examenes = $repository->findAll();

        $format = $this->getRequest()->getRequestFormat();
        
        return $this->render('InformaticaPrometheusBundle:Examen:list.'.$format.'.twig',
            array('examenes'=>$examenes));
    }

    /**
     * @Route("/update/{id}", name="examen_update")
     * @Template()
     */
    public function updateAction(Request $request, $id){
        $opciones = $this->container->getParameter('opciones');
        $periodos = $this->container->getParameter('periodos');
        
        $repository = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Examen');
        $examen = $repository->findOneById($id);
        
        $examenType = new ExamenType();
        $examenType->setOpciones($opciones);
        $examenType->setPeriodos($periodos);

        $form = $this->createForm($examenType,$examen);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($examen);
                $em->flush();
                return $this->redirect($this->generateUrl('examen_list', array('_format' => 'html')));
            }
        }
        return array('form'=>$form->createView(),'id'=>$id);
    }

    /**
     * @Route("/remove/{id}", name="examen_remove")
     * @Template()
     */
    public function removeAction($id){
        $em = $this->getDoctrine()->getEntityManager();

        $examen = $em->getRepository('InformaticaPrometheusBundle:Examen')->findOneById($id);
        if (!$examen) {
            throw $this->createNotFoundException('No se encontro el examen con numero de control: '.$id);
        }
        $em->remove($examen);
        $em->flush();

        return $this->redirect($this->generateUrl('examen_list', array('_format' => 'html')));
    }

    /**
     * @Route("/show/{id}", name="examen_show")
     * @Template()
     */
    public function showAction($id){

    }

    /**
     * @Route("/message", name="examen_message")
     * @Template()
     */
    public function messageAction(){
        return array("mensaje" => "examen guardado");
    }
    
 
}