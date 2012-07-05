<?php

namespace Informatica\PrometheusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Informatica\PrometheusBundle\Form\preguntaType;
use Informatica\PrometheusBundle\Entity\pregunta;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/preguntas")
 */
class preguntaController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
         return $this->redirect($this->generateUrl('pregunta_list', array('_format' => 'html')));
    }
    
    
    /**
     * @Route("/new", name="pregunta_new")
     * @Template()
     */
    public function newAction(Request $request){
 
        $pregunta = new pregunta();

        $form = $this->createForm(new PreguntaType(), $pregunta);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($pregunta);
                $em->flush();
                return $this->redirect($this->generateUrl('pregunta_list', array('_format' => 'html')));
            }
        }
        return array('form'=>$form->createView());
    }

    /**
     * @Route("/list", defaults={"_format"="html"}),
     * @Route("/list.{_format}", name="pregunta_list", requirements={"_format"= "html|xml|json"})
     * @Template()
     */
    public function listAction(){
        $repository = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Pregunta');
        $preguntas = $repository->findAll();

        $format = $this->getRequest()->getRequestFormat();
        
        return $this->render('InformaticaPrometheusBundle:Pregunta:list.'.$format.'.twig',
            array('preguntas'=>$preguntas));
    }

    /**
     * @Route("/update/{id}", name="pregunta_update")
     * @Template()
     */
    public function updateAction(Request $request, $id){
        
        $repository = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:pregunta');
        $pregunta = $repository->findOneById($id);


        $form = $this->createForm(new PreguntaType(), $pregunta);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($pregunta);
                $em->flush();
                return $this->redirect($this->generateUrl('pregunta_list', array('_format' => 'html')));
            }
        }
        return array('form'=>$form->createView(),'id'=>$id);
    }

    /**
     * @Route("/remove/{id}", name="pregunta_remove")
     * @Template()
     */
    public function removeAction($id){
        $em = $this->getDoctrine()->getEntityManager();

        $pregunta = $em->getRepository('InformaticaPrometheusBundle:pregunta')->findOneById($id);
        if (!$pregunta) {
            throw $this->createNotFoundException('No se encontro el pregunta con numero de control: '.$id);
        }
        $em->remove($pregunta);
        $em->flush();

        return $this->redirect($this->generateUrl('pregunta_list', array('_format' => 'html')));
    }

    /**
     * @Route("/show/{id}", name="pregunta_show")
     * @Template()
     */
    public function showAction($id){

    }

    /**
     * @Route("/message", name="pregunta_message")
     * @Template()
     */
    public function messageAction(){
        return array("mensaje" => "pregunta guardado");
    }
    
 
}