<?php

namespace Informatica\PrometheusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/ajax")
 */
class AjaxController extends Controller
{
     
    /**
     * @Route("/profesores", name="profesores_array")
     * @Template()
     */
    public function profesoresAction()
    {
       $request = $this->getRequest();
       $AJAXResponse = array('Blanca','Armando','Gamez');
       
       if ($request->isXmlHttpRequest() == true) {
            $response = new Response(json_encode($AJAXResponse));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
       
       return new Response($AJAXResponse[0]);
    }
    
    /**
     * @Route("/alumnos")
     * @Template()
     */
    public function alumnosAction()
    {
      
    }
    
   
}
