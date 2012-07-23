<?php

namespace Informatica\PrometheusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/")
 */
class WelcomeController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
         return array(
             'message' => 'Welcome',
             'date' =>  date('g:i a l j F Y'),
         );
    }
    
    /**
     * @Route("/test")
     * @Template()
     */
    public function testAction()
    {
         $mailer = $this->get('opensky_runtime_config:'); 
         $casa = $mailer->get('cas');
         return Response($casa);
    }
    
   
}
