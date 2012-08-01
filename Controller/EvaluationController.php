<?php
namespace Informatica\PrometheusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Informatica\PrometheusBundle\Entity\HojaRespuestasFactory;
use Informatica\PrometheusBundle\Entity\HojaRespuestas;
use Informatica\PrometheusBundle\Entity\PreguntaEvaluable;
use Informatica\PrometheusBundle\Entity\Alumno;
use Informatica\PrometheusBundle\Form\AlumnoType;
use Informatica\PrometheusBundle\Form\HojaRespuestasType;
use Informatica\PrometheusBundle\Entity\Utilities;




/**
 * 
 *
 * @Route("/evaluation")
 */
class EvaluationController extends Controller
{
    private $periodo;

    /**
     * @Route("/index", name="evaluation_index")
     * @Template()
     */
    public function indexAction()
    {
         //$id = $this->container->getParameter('periodo.actual');
         //$this->periodo = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Periodo')
        //->find($id);
        
         return $this->render('InformaticaPrometheusBundle:Evaluation:index.html.twig');
    }
    
    /**
     * @Route("/identification", name="evaluation_identification")
     * @Template()
     */
    public function indentificationAction(Request $request)
    {

        $defaultData = array('aplicador' => 'Escribe el nombre el aplicador');
        $contrasena = $this->get('translator')->trans('evaluacion.contrasena');
        $form = $this->createFormBuilder($defaultData)
        ->add('nocontrol', 'text',array('label'=>$this->get('translator')->trans('evaluacion.nocontrol')))
        ->add('password', 'password',array('label'=>$contrasena))
        ->add('examen', 'text',array('label'=>'Clave Examen'))
        ->add('aplicador', 'text')
        ->getForm();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            $data = $form->getData();
            $nocontrol =  $data['nocontrol'];
            $password =  $data['password'];
            $claveExamen = $data['examen'];
            $aplicador = $data['aplicador'];
            
            $examen = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Examen')
            ->findOneById($claveExamen);

            if(!$examen) 
            {
                return $this->render('InformaticaPrometheusBundle:Evaluation:examNoExist.html.twig');

            } 

            $alumno = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Alumno')
            ->findOneByNocontrol($nocontrol);
            if($alumno) 
            {
                 if( $password == $alumno->getContrasena() ) 
                 {
                      $session = $this->getRequest()->getSession();
                      $session->start();
                      $session->set('nocontrol', $alumno->getNocontrol());
                      $session->set('exam', $claveExamen);
                      
                      return $this->redirect($this->generateUrl('evaluation_instruccions'));
                 }else
                  {
                      return $this->render('InformaticaPrometheusBundle:Evaluation:nofound.html.twig',
                         array('nocontrol'=> $nocontrol,
                         ));
                  } 
            }else
            {
                return $this->render('InformaticaPrometheusBundle:Evaluation:nofound.html.twig',
                    array('nocontrol'=> $nocontrol,
                    ));
            }

        }
        
        return $this->render('InformaticaPrometheusBundle:Evaluation:identification.html.twig',
        array(
            'form'=> $form->createView(),
        ));
    }
    
    
    /**
     * @Route("/evaluation_instruccions", name="evaluation_instruccions")
     * @Template()
     */
    public function instruccionsAction()
    {
         $session = $this->getRequest()->getSession();
         $nocontrol = $session->get('nocontrol');
         $claveExamen = $session->get('exam');

         $alumno = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Alumno')
            ->findOneByNocontrol($nocontrol);
        
        if($alumno)
        {
             $hoja = HojaRespuestasFactory::getHojaRespuestas($claveExamen, $this->getDoctrine());
                          
             $hoja->setFecha( new \DateTime());
             $hoja->setCalificacion(0);
             $hoja->setAlumno($alumno);

             $em = $this->getDoctrine()->getEntityManager();
             $em->persist($hoja);
             $em->flush();
             
             $session->set('activeexamen', true);
             $session->set('hojaid', $hoja->getId());
             
              
             return $this->render('InformaticaPrometheusBundle:Evaluation:instruccions.html.twig',
                array(
                    'alumno'=>$alumno,
                    //'hoja'=> $hoja,
                ));
        }
        else
        {
            return $this->redirect($this->generateUrl('evaluation_identification'));
        }
        
    }
    
    /**
     * @Route("/viewExam", name="evaluation_viewExam")
     * @Template()
     */
    public function viewExamAction(Request $request)
    {

       $session = $this->getRequest()->getSession();
       $nocontrol = $session->get('nocontrol');
       $alumno = null;
       if($nocontrol)
       {
           $alumno = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Alumno')
              ->findOneByNocontrol($nocontrol);
       }     
       if($alumno)
        {
            $hojaid =  $session->get('hojaid');
            $active = $session->get('activeexamen');
            
            $hoja = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:HojaRespuestas')
            ->find($hojaid);
            
            
            if($hoja && $active)
            {
                $formBuilder = new HojaRespuestasType();
                $formBuilder->setHojaRespuestas($hoja);
                $form = $this->createForm($formBuilder);
                
                if ($request->getMethod() == 'POST') {
                    $form->bindRequest($request);
                    $data = $form->getData();
                    
                    foreach($hoja->getPreguntas() as $pregunta => $valor){
                        $valor->setRespuesta($data[$valor->getId()]);
                    }
                    
                    $hoja->evaluar();
                    //Aqui actualizamos la bd con las repuestas
                    $em = $this->getDoctrine()->getEntityManager();
                    $em->merge($hoja);
                    $em->flush();
                    
                     $session->set('activeexamen', false);
                     $session->set('hojaid', $hoja->getId());
                    return $this->redirect($this->generateUrl('evaluation_results'));
                }
                return $this->render('InformaticaPrometheusBundle:Evaluation:viewExam.html.twig',
                    array(
                        'form'=> $form->createView(),
                        'alumno'=>$alumno,
						'hoja' => $hoja,
                    )
                );
            }else{
                 return $this->render('InformaticaPrometheusBundle:Evaluation:examNoFound.html.twig',
                    array(
                        'alumno'=>$alumno,
                        'periodo'=> $this->periodo,
                    )
                );
            }


         }
        else
        {
            return $this->redirect($this->generateUrl('evaluation_identification'));
        }
    }
    
    /**
     * @Route("/resultados/", name="evaluation_results")
     * @Template()
     */
    public function resultsAction(Request $request)
    {
        $session = $this->getRequest()->getSession();
        $nocontrol = $session->get('nocontrol');
       
        $alumno = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Alumno')
           ->findOneByNocontrol($nocontrol);
        
        if($alumno)
        {
            $hojaid =  $session->get('hojaid');
            $hoja = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:HojaRespuestas')
            ->find($hojaid);
            
            if($hoja)
            {  
               return $this->render('InformaticaPrometheusBundle:Evaluation:results.html.twig',
                    array(
                        'alumno'=>$alumno,
                        'hoja'=> $hoja,
                    )
                );
            }
            else
            {
                return $this->redirect($this->generateUrl('evaluation_identification'));
            }                       
        }
        else
        {
            return $this->redirect($this->generateUrl('evaluation_identification'));
        }
    }
    
        
    /**
     * @Route("/close}", name="evaluation_close")
     * @Template()
     */
    public function closeAction()
    {
       $session = $this->getRequest()->getSession();
       $nocontrol = $session->get('nocontrol');
       if($nocontrol)
       {
           $session->save();
           $session->set('nocontrol', null);
           $session->set('exam', null);
           $session->set('activeexamen', null);
           $session->set('hojaid', null);
       }
       return $this->redirect($this->generateUrl('evaluation_identification'));

    }
    
    
    public function desplegarImagenAction($pregunta)
    {
        $preguntae = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:PreguntaEvaluable')
        ->find($pregunta);
        
        return $this->render('InformaticaPrometheusBundle:Evaluation:mostrarImagen.html.twig',
             array(
                'desplegar'=>true,
                'orientacion'=>'izquierda',
                'imagen'=>$preguntae->getPregunta()->getImagen(),
             ));
    }
    
    public function desplegarImagenRespuestaAction($pregunta, $respuesta)
    {
        $preguntae = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:PreguntaEvaluable')
        ->find($pregunta);
        if($preguntae->getPregunta()->getRespuetaImagenes()) {
            return $this->render('InformaticaPrometheusBundle:Evaluation:mostrarImagen.html.twig',
            array(
                'desplegar'=>true,
                'orientacion'=>'derecha',
                'imagen'=>$respuesta,
                ));
        }
        return new Response('<label>'.$respuesta.'</label>');


    }


    
}
















