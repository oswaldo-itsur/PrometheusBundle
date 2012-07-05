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
use Informatica\PrometheusBundle\Entity\Utilerias;




/**
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

        $form = $this->createFormBuilder($defaultData)
        ->add('ficha', 'integer')
        ->add('aplicador', 'text')
        ->getForm();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            $data = $form->getData();
            $ficha =  $data['ficha'];
            $aplicador = $data['aplicador'];
            
            //$periodo = $this->container->getParameter('periodo.actual');
            $aspirante = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Aspirante')
            ->findByPeriodoAndFicha($this->periodo->getId(), $ficha);

            if($aspirante)
            {
                 return $this->redirect($this->generateUrl('evaluation_confirmacion',
                     array('ficha' => $ficha,
                     'aplicador' => $aplicador)));
            }else
            {
                return $this->render('InformaticaPrometheusBundle:Evaluation:noencontrado.html.twig',
                    array('ficha'=> $ficha,
                         'periodo'=>$this->periodo,
                    ));
            }

        }
        
        return $this->render('InformaticaPrometheusBundle:Evaluation:identificacion.html.twig',
        array(
            'form'=> $form->createView(),
            'periodo'=>$this->periodo,
        ));
    }
    
    /**
     * @Route("/confirmacion/{ficha}/{aplicador}", name="evaluation_confirmacion")
     * @Template()
     */
    public function confirmacionAction($ficha, $aplicador)
    {

         $id = $this->container->getParameter('periodo.actual');
         $this->periodo = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Periodo')
        ->find($id);
        
         $aspirante = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Aspirante')
         ->findByPeriodoAndFicha($this->periodo->getId(), $ficha);

         if($aspirante)
         {
                 return $this->render('InformaticaPrometheusBundle:Evaluation:confirmacion.html.twig',
                 array(
                    'periodo'=> $this->periodo,
                    'aspirante'=> $aspirante,
                    'aplicador'=> $aplicador,
                ));
         }



    }
    

    
    /**
     * @Route("/instrucciones/{ficha}/{aplicador}", name="evaluation_instrucciones")
     * @Template()
     */
    public function instruccionesAction($ficha, $aplicador)
    {
         $id = $this->container->getParameter('periodo.actual');
         $this->periodo = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Periodo')
        ->find($id);
        
         $aspirante = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Aspirante')
         ->findByPeriodoAndFicha($this->periodo->getId(), $ficha);
         
        if($aspirante->getHoja()){
            return $this->render('InformaticaPrometheusBundle:Evaluation:evaluationprevia.html.twig',
                array(
                    'aspirante'=>$aspirante,
                    'periodo'=> $this->periodo,
                ));
        }
       
        if($aspirante)
        {
             $session = $this->getRequest()->getSession();
             $session->start();

             $manual = $id = $this->container->getParameter('manual.clave');

             $hoja = HojaRespuestasFactory::getHojaRespuestas($manual, $this->getDoctrine());
             $hoja->setAplicador($aplicador);
             $hoja->setAspirante($aspirante);
             $hoja->setFecha( new \DateTime());
             $hoja->setCalificacion(0);
             $hoja->setPeriodo($this->periodo);
             $aspirante->setHoja($hoja);

             $em = $this->getDoctrine()->getEntityManager();
             $em->persist($hoja);
             $em->flush();
             $session->set('aspirante', $aspirante);
                 
             return $this->render('InformaticaPrometheusBundle:Evaluation:instrucciones.html.twig',
                array(
                    'aspirante'=>$aspirante,
                    'periodo'=> $this->periodo,
                    'hoja'=> $hoja,
                    'area' =>1,
                    'seccion' =>1,
                    'tema' =>1,
                    'grupo' =>1,
                ));
        }
        else
        {
            return $this->redirect($this->generateUrl('evaluation_identificacion',array('periodo'=> $this->periodo)));
        }
        
    }
    
    /**
     * @Route("/grupoPreguntas/{ficha}/{area}/{seccion}/{tema}/{grupo}", name="evaluation_grupo")
     * @Template()
     */
    public function grupoAction(Request $request, $ficha,$area,$seccion,$tema,$grupo)
    {
       $id = $this->container->getParameter('periodo.actual');
       $this->periodo = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Periodo')
        ->find($id);
        
       $session = $this->getRequest()->getSession();
       $aspirante = $session->get('aspirante');
       if($aspirante)
        {
            $repository = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:GrupoEvaluable');
            $grupoPreguntas =  $repository->findByPeriodoAndFichaAndAreaAndSeccionAndTemaAndOrder($id,
                              $ficha, $area, $seccion, $tema, $grupo);

            if($grupoPreguntas)
            {
              /*
                if($grupoPreguntas->getPreguntas()->count() <= 0 ){
                    $siguientes = Utilerias::grupoSiguiente($this->getDoctrine(), $id, $aspirante->getFicha(), $area, $seccion, $tema, $grupo);

                    //Mostrar el siguiente grupo de preguntas
                    return $this->redirect($this->generateUrl('evaluation_grupo' ,
                    array(
                        'ficha'=>$aspirante->getFicha(),
                        'area' =>$siguientes['area'],
                        'seccion' => $siguientes['seccion'],
                        'tema' => $siguientes['tema'],
                        'grupo' => $siguientes['grupo'],
                       ))
                    );
                }
                 */
                $formBuilder = new GrupoType();
                $formBuilder->setGrupoPreguntas($grupoPreguntas);
                $form = $this->createForm($formBuilder);
				$hoja = $grupoPreguntas->getTema()->getSeccion()->getArea()->getHoja();
                
                return $this->render('InformaticaPrometheusBundle:Evaluation:grupo.html.twig',
                    array(
                        'form'=> $form->createView(),
                        'aspirante'=>$aspirante,
                        'periodo'=> $this->periodo,
                        'grupoPreguntas'=> $grupoPreguntas,
                        'area' =>$area,
                        'seccion' =>$seccion,
                        'tema' =>$tema,
                        'grupo' =>$grupo,
						'hoja' => $hoja,
                    )
                );
            }else{
                 return $this->render('InformaticaPrometheusBundle:Evaluation:gruponoencontrado.html.twig',
                    array(
                        'aspirante'=>$aspirante,
                        'periodo'=> $this->periodo,
                        'area' =>$area,
                        'seccion' =>$seccion,
                        'tema' =>$tema,
                        'grupo' =>$grupo,
						'hoja' => $hoja,
                    )
                );
            }


         }
        else
        {
            return $this->redirect($this->generateUrl('evaluation_identificacion',array('periodo'=> $this->periodo)));
        }
    }
    
    /**
     * @Route("/despedida/{ficha}}", name="evaluation_despedida")
     * @Template()
     */
    public function despedidaAction($ficha)
    {
        //Se recupera el periodo actual.
        $id = $this->container->getParameter('periodo.actual');
        $this->periodo = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Periodo')
        ->find($id);
        
        //Recuperamos de la session el aspirante que esta contestando la pregunta
        $session = $this->getRequest()->getSession();
        $aspirante = $session->get('aspirante');
        
        if($aspirante)
        {
            //Recperamos la hoja de respuestas del aspirante actual.
            $repository = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:HojaRespuestas');
            $hoja =  $repository->findByPeriodoAndFicha($id, $ficha);

            //Calculamos la calificacion de la hoja
            $aspirante->setHoja($hoja);
            $hoja->evaluar();
        
            //Aqui actualizamos toda la hoja para que se guarde la calificacion
            $em = $this->getDoctrine()->getEntityManager();
            $em->merge($hoja);
            $em->flush();
        
            //Aqui actualizamos el aspirante.
            $em->merge($aspirante);
            $em->flush();
        
            //Mostramos el mensaje de despedida del examen.
            return $this->render('InformaticaPrometheusBundle:Evaluation:despedida.html.twig',
                    array(
                        'aspirante'=>$aspirante,
                        'periodo'=> $this->periodo,
                        'hoja'=> $hoja,
                    )
                );
       }
       else
       {
            return $this->redirect($this->generateUrl('evaluation_identificacion',array('periodo'=> $this->periodo)));
       }
    }
    
    
    
    /**
     * @Route("/terminar}", name="evaluation_finalizar")
     * @Template()
     */
    public function finalizarAction()
    {
       $session = $this->getRequest()->getSession();
       $aspirante = $session->get('aspirante');
       if($aspirante)
       {
           $session->save();
           $aspirante = $session->set('aspirante',null);
           return $this->redirect($this->generateUrl('evaluation_identificacion'));
       }
       else
       {
            return $this->redirect($this->generateUrl('evaluation_identificacion',array('periodo'=> $this->periodo)));
       }

    }
    
    /**
     * @Route("/nuevo", name="evaluation_nuevo")
     * @Template()
     */
    public function nuevoAction(Request $request)
    {
         $em = $this->getDoctrine()->getEntityManager();
        $id = $this->container->getParameter('periodo.actual');
        $periodo = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Periodo')->find($id);

        $aspirante = new Aspirante();
        $aspirante->setPeriodo($periodo);

        $form = $this->createForm(new AspiranteType(), $aspirante);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {

                $em->persist($aspirante);
                $em->flush();
                return $this->redirect($this->generateUrl('evaluation_identificacion'));
            }

        }

        return $this->render('InformaticaPrometheusBundle:Evaluation:nuevoAspirante.html.twig',array(
        'form'=> $form->createView(),
        ));
    }
    

    /**
     * @Route("/guardarRespuestas/{ficha}/{area}/{seccion}/{tema}/{grupo}", name="evaluation_guardarGrupo")
     * @Template()
     */
    public function guardarGrupoAction(Request $request, $ficha,$area,$seccion,$tema,$grupo)
    {
        $id = $this->container->getParameter('periodo.actual');
        $this->periodo = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Periodo')
        ->find($id);

        $session = $this->getRequest()->getSession();
        $aspirante = $session->get('aspirante');
        if($aspirante)
        {
            $repository = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:GrupoEvaluable');
            $grupoPreguntas =  $repository->findByPeriodoAndFichaAndAreaAndSeccionAndTemaAndOrder($id,
                              $ficha, $area, $seccion, $tema, $grupo);
                              
            $formBuilder = new GrupoType();
            $formBuilder->setGrupoPreguntas($grupoPreguntas);
            $form = $this->createForm($formBuilder);
            
            if ($request->getMethod() == 'POST') {
                $form->bindRequest($request);
                $data = $form->getData();

                 foreach($grupoPreguntas->getPreguntas() as $pregunta => $valor){

                     $valor->setRespuesta($data[$valor->getId()]);
                     $elejida =  $data[$valor->getId()];
                     $real = $valor->getPregunta()->getRespuesta();
                     $valor->setContestada(true);
                 }
                 
                 //Se marca le grupo como contestado.
                 $grupoPreguntas->setContestada(true);

                //Se actualiza la bd con las respuestas.
                $em = $this->getDoctrine()->getEntityManager();
                $em->merge($grupoPreguntas);
                $em->flush();
                

                $siguientes = Utilerias::grupoSiguiente($this->getDoctrine(), $id, $aspirante->getFicha(), $area, $seccion, $tema, $grupo);

                //¿Hubo cambio de tema?
                if($siguientes['cambiotema']){
                    //Marcar como contestado y actualizar la bd.
                    $temaev = $grupoPreguntas->getTema();
                    $temaev->setContestada(true);
                    $em->merge($temaev);
                    $em->flush();
                }
                
                //¿Hubo cambio de seccion?
                if($siguientes['cambioseccion']){
                    //Marcar como contestado y actualizar la bd.
                    $seccionev = $temaev->getSeccion();
                    $seccionev->setContestada(true);
                    $em->merge($seccionev);
                    $em->flush();
                }
                
                //¿Hubo cambio de area?
                if($siguientes['cambioarea']){
                    //Marcar como contestado y actualizar la bd.
                    $areaev = $seccionev->getArea();
                    $areaev->setContestada(true);
                    $em->merge($areaev);
                    $em->flush();
                }
                
                //¿Se llego al final del examen?
                if($siguientes['final']){
                   //Redirijir a la despedida
                   return $this->redirect($this->generateUrl('evaluation_despedida' ,
                    array(
                        'ficha'=>$aspirante->getFicha(),
                    )));
                }
                
                //Mostrar el siguiente grupo de preguntas
                return $this->redirect($this->generateUrl('evaluation_grupo' ,
                    array(
                        'ficha'=>$aspirante->getFicha(),
                        'area' =>$siguientes['area'],
                        'seccion' => $siguientes['seccion'],
                        'tema' => $siguientes['tema'],
                        'grupo' => $siguientes['grupo'],
                    ))
                );
             }
        }
        else
        {
            return $this->redirect($this->generateUrl('evaluation_identificacion',array('periodo'=> $this->periodo)));
        }
    }
    
    /**
     * @Route("/reiniciar/{ficha}}", name="evaluation_reiniciar")
     * @Template()
     */
    public function reiniciarAction($ficha)
    {
         $id = $this->container->getParameter('periodo.actual');
         $this->periodo = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Periodo')
        ->find($id);

         $aspirante = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Aspirante')
         ->findByPeriodoAndFicha($this->periodo->getId(), $ficha);

        if($aspirante)
        {
             $session = $this->getRequest()->getSession();
             $session->start();
             $session->set('aspirante', $aspirante);
             $hoja = $aspirante->getHoja();

             return $this->render('InformaticaPrometheusBundle:Evaluation:instrucciones.html.twig',
                array(
                    'aspirante'=>$aspirante,
                    'periodo'=> $this->periodo,
                    'hoja'=> $hoja,
                    'area' =>1,
                    'seccion' =>1,
                    'tema' =>1,
                    'grupo' =>1,
                ));
        }
        else
        {
            return $this->redirect($this->generateUrl('evaluation_identificacion',array('periodo'=> $this->periodo)));
        }
    }
    
    
    /**
     * @Route("/buscar}", name="evaluation_buscar")
     * @Template()
     */
    public function buscarAction(Request $request)
    {
         $id = $this->container->getParameter('periodo.actual');
         $this->periodo = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Periodo')
        ->find($id);


        $defaultData = array('aplicador' => 'Escribe el nombre el aplicador');

        $form = $this->createFormBuilder($defaultData)
        ->add('nombre', 'text')
        ->getForm();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            $data = $form->getData();
            $nombre =  $data['nombre'];

            //$periodo = $this->container->getParameter('periodo.actual');
            $aspirantes = $this->getDoctrine()->getRepository('InformaticaPrometheusBundle:Aspirante')
            ->findByPeriodoAndNombre($this->periodo->getId(), $nombre);

            return $this->render('InformaticaPrometheusBundle:Evaluation:aspirantesencontrados.html.twig',
                     array(
                         'aspirantes' => $aspirantes,
                         'periodo' => $this->periodo,
                     ));

        }

        return $this->render('InformaticaPrometheusBundle:Evaluation:buscar.html.twig',
        array(
            'form'=> $form->createView(),
            'periodo'=>$this->periodo,
        ));

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
















